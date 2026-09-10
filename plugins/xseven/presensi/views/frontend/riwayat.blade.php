@include('xseven.presensi::frontend.partials.header', ['activePage' => 'riwayat'])
<div class="container">
            <h2 style="font-size:1.25rem;margin-bottom:16px;color:#1e293b;font-weight:700">Riwayat Presensi</h2>
            <div class="card card-table">
                <div style="overflow-x:auto;-webkit-overflow-scrolling:touch">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Foto Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Foto Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $r)
                        <tr>
                            <td data-label="Tanggal">{{ \Carbon\Carbon::parse($r->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</td>
                            <td data-label="Jam Masuk">{{ $r->jam_masuk ? \Carbon\Carbon::parse($r->jam_masuk)->format('H:i') . ' WIB' : '-' }}</td>
                            <td data-label="Foto Masuk">@if($r->foto_masuk)<img class="thumb" src="/presensi/foto/{{ $r->id }}/masuk" onclick="showImg(this.src)" style="width:40px;height:30px;object-fit:cover;border-radius:4px;cursor:pointer">@else - @endif</td>
                            <td data-label="Jam Pulang">{{ $r->jam_pulang ? \Carbon\Carbon::parse($r->jam_pulang)->format('H:i') . ' WIB' : '-' }}</td>
                            <td data-label="Foto Pulang">@if($r->foto_pulang)<img class="thumb" src="/presensi/foto/{{ $r->id }}/pulang" onclick="showImg(this.src)" style="width:40px;height:30px;object-fit:cover;border-radius:4px;cursor:pointer">@else - @endif</td>
                            <td data-label="Status"><span class="badge badge-{{ strtolower($r->status) }}">{{ $r->status }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" style="text-align:center;padding:24px">Belum ada data presensi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
</div>
@include('xseven.presensi::frontend.partials.footer')
</body>
</html>
