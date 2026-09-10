@include('xseven.presensi::frontend.partials.header', ['activePage' => 'dashboard'])
<div class="container">
            <div class="card">
                <div class="info-section">
                    <div class="avatar"><img src="/plugins/xseven/presensi/assets/images/xp-logo.webp" alt="Logo" style="width:100%;height:100%;object-fit:contain;border-radius:inherit"></div>
                    <div class="info-content">
                    <h2>Selamat Datang, {{ $pegawai->nama }}</h2>
                    <p class="info">{{ $pegawai->jabatan ?? '-' }} &middot; {{ $pegawai->departemen ?? '-' }}</p>
                    <p class="info">{{ $tanggal }}</p>
                    <div class="clock" id="clock"></div>
                    @php
                        $sc = 'status-belum';
                        if($statusDisplay === 'Sudah Presensi Masuk') $sc = 'status-masuk';
                        elseif($statusDisplay === 'Presensi Selesai') $sc = 'status-selesai';
                    @endphp
                    <span class="status-badge {{ $sc }}">Status: {{ $statusDisplay }}</span>
                    <p class="info">Jam Kerja: 08:00 - 17:00 WIB</p>
                    @if($presensi && ($presensi->jam_masuk || $presensi->jam_pulang))
                        <div class="work-time">
                            @if($presensi->jam_masuk)
                                <span class="work-pill work-pill-masuk">Jam Masuk: {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }} WIB</span>
                            @endif
                            @if($presensi->jam_pulang)
                                <span class="work-pill work-pill-pulang">Jam Pulang: {{ \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') }} WIB</span>
                            @endif
                        </div>
                    @endif
                    </div>
                </div>
                <div class="action-section">
                    @if(!$presensi || !$presensi->jam_masuk)
                        <button class="btn btn-masuk" onclick="openCamera('masuk')">PRESENSI MASUK</button>
                    @elseif(!$presensi->jam_pulang)
                        <button class="btn btn-pulang" onclick="openCamera('pulang')">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            PRESENSI PULANG
                        </button>
                    @else
                        <button class="btn" disabled>PRESENSI SELESAI HARI INI</button>
                    @endif
                </div>
            </div>

            <div id="msgBox" class="msg"></div>

            <div class="card card-table">
                <div class="table-header"><h3>Presensi Hari ini</h3></div>
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
@include('xseven.presensi::frontend.partials.camera-modal')
</body>
</html>