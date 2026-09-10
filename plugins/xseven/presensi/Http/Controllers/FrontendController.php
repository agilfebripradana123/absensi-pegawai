<?php namespace XSeven\Presensi\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use BackendAuth;
use XSeven\Presensi\Models\Pegawai;
use XSeven\Presensi\Models\Presensi;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function loginForm()
    {
        if (BackendAuth::check()) {
            return redirect('/presensi/dashboard');
        }
        return response()->view('xseven.presensi::frontend.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'login'    => $request->input('login'),
            'password' => $request->input('password'),
        ];

        $user = BackendAuth::authenticate($credentials);

        if (!$user) {
            return back()->withErrors(['login' => 'Email/Username atau password salah.']);
        }

        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai || !$pegawai->status) {
            BackendAuth::logout();
            return back()->withErrors(['login' => 'Akun pegawai tidak aktif.']);
        }

        return redirect('/presensi/dashboard');
    }

    public function logout()
    {
        BackendAuth::logout();
        return redirect('/presensi/login');
    }

    public function dashboard()
    {
        $pegawai = $this->getPegawai();
        if (!$pegawai) return redirect('/presensi/login');

        $today     = Carbon::now('Asia/Jakarta')->toDateString();
        $presensi  = Presensi::where('pegawai_id', $pegawai->id)
            ->where('tanggal', $today)
            ->first();

        $statusDisplay = 'Belum Presensi';
        if ($presensi) {
            if ($presensi->jam_pulang) {
                $statusDisplay = 'Presensi Selesai';
            } elseif ($presensi->jam_masuk) {
                $statusDisplay = 'Sudah Presensi Masuk';
            }
        }

        $records = Presensi::where('pegawai_id', $pegawai->id)
            ->where('tanggal', $today)
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->view('xseven.presensi::frontend.dashboard', [
            'pegawai'       => $pegawai,
            'presensi'      => $presensi,
            'statusDisplay' => $statusDisplay,
            'tanggal'       => Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y'),
            'records'       => $records,
        ]);
    }

    public function riwayat()
    {
        $pegawai = $this->getPegawai();
        if (!$pegawai) return redirect('/presensi/login');

        $records = Presensi::where('pegawai_id', $pegawai->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return response()->view('xseven.presensi::frontend.riwayat', [
            'records'  => $records,
            'pegawai'  => $pegawai,
        ]);
    }

    public function checkin(Request $request)
    {
        $pegawai = $this->getPegawai();
        if (!$pegawai) return response()->json(['error' => 'Silakan login terlebih dahulu.'], 401);

        $request->validate([
            'foto' => 'required|string',
        ]);

        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $existing = Presensi::where('pegawai_id', $pegawai->id)->where('tanggal', $today)->first();

        if ($existing && $existing->jam_masuk) {
            return response()->json(['error' => 'Anda sudah melakukan presensi masuk hari ini.'], 422);
        }

        $fotoPath = $this->saveFoto($request->input('foto'), 'masuk');
        $now = Carbon::now('Asia/Jakarta');
        $status = $now->format('H:i') > '08:00' ? 'Terlambat' : 'Hadir';

        if ($existing) {
            $existing->jam_masuk = $now->format('H:i:s');
            $existing->foto_masuk = $fotoPath;
            $existing->status = $status;
            $existing->save();
        } else {
            Presensi::create([
                'pegawai_id' => $pegawai->id,
                'tanggal'    => $today,
                'jam_masuk'  => $now->format('H:i:s'),
                'foto_masuk' => $fotoPath,
                'status'     => $status,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Presensi masuk berhasil.']);
    }

    public function checkout(Request $request)
    {
        $pegawai = $this->getPegawai();
        if (!$pegawai) return response()->json(['error' => 'Silakan login terlebih dahulu.'], 401);

        $request->validate([
            'foto' => 'required|string',
        ]);

        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $existing = Presensi::where('pegawai_id', $pegawai->id)->where('tanggal', $today)->first();

        if (!$existing || !$existing->jam_masuk) {
            return response()->json(['error' => 'Anda harus melakukan presensi masuk terlebih dahulu.'], 422);
        }

        if ($existing->jam_pulang) {
            return response()->json(['error' => 'Anda sudah melakukan presensi pulang hari ini.'], 422);
        }

        $fotoPath = $this->saveFoto($request->input('foto'), 'pulang');
        $existing->jam_pulang = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $existing->foto_pulang = $fotoPath;
        $existing->save();

        return response()->json(['success' => true, 'message' => 'Presensi pulang berhasil.']);
    }

    public function viewFoto($id, $type)
    {
        $pegawai = $this->getPegawai();
        $record  = Presensi::findOrFail($id);

        if ($pegawai && $record->pegawai_id !== $pegawai->id) {
            if (!BackendAuth::getUser()) {
                abort(403);
            }
        }

        $field = $type === 'pulang' ? 'foto_pulang' : 'foto_masuk';
        $path  = storage_path('app/' . $record->$field);

        if (!$record->$field || !file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    private function getPegawai()
    {
        $user = BackendAuth::getUser();
        if (!$user) return null;
        return Pegawai::where('user_id', $user->id)->where('status', 1)->first();
    }

    private function saveFoto($base64, $type)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
            $ext  = strtolower($matches[1]);
            if (!in_array($ext, ['jpeg', 'jpg', 'png'])) {
                throw new \Exception('Tipe file tidak diizinkan.');
            }
            $data    = substr($base64, strpos($base64, ',') + 1);
            $decoded = base64_decode($data);

            if (strlen($decoded) > 2 * 1024 * 1024) {
                throw new \Exception('Ukuran foto maksimal 2MB.');
            }

            $dir     = "uploads/presensi/{$type}";
            Storage::makeDirectory($dir);
            $filename = Str::uuid() . '.' . ($ext === 'jpeg' ? 'jpg' : $ext);
            $path     = "{$dir}/{$filename}";
            Storage::put($path, $decoded);
            return $path;
        }
        throw new \Exception('Format foto tidak valid.');
    }
}
