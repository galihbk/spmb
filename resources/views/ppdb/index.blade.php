<x-guest-layout>
    <div class="page-content">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @php
            $ppdb = \App\Models\Ppdb::where('user_id', auth()->id())->first();
        @endphp

        @if (!$ppdb)
        @if($setting && $setting->status_pendaftaran == 0)
         <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary">Pendafataran Peserta Didik Baru</h5>
                    </div>
                    <hr>
                    <div class="alert alert-info">
                        Pendaftaran belum di buka, silahkan tunggu informasi selanjutnya!
                    </div>
                </div>
            </div>
        @elseif($setting && $setting->status_pendaftaran == 1)
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary">Form Pendaftaran Siswa Baru</h5>
                    </div>
                    <hr>
                    <form class="row g-3" method="POST" action="{{ route('ppdb.submit') }}"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="col-md-6">
                            <label class="form-label">Peminatan Jurusan</label>
                            <select name="jurusan" class="form-select @error('jurusan') is-invalid @enderror" required>
                                <option disabled {{ old('jurusan') ? '' : 'selected' }}>-- Pilih Jurusan --</option>
                                <option value="DPB" {{ old('jurusan') == 'DPB' ? 'selected' : '' }}>Desain Produk
                                    Busana
                                    (DPB)</option>
                                <option value="TKJ" {{ old('jurusan') == 'TKJ' ? 'selected' : '' }}>Teknik Jaringan
                                    Komputer (TKJ)
                                </option>
                                <option value="TBSM" {{ old('jurusan') == 'TBSM' ? 'selected' : '' }}>Teknik dan
                                    Bisnis
                                    Sepeda Motor (TBSM)
                                </option>
                            </select>
                            @error('jurusan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Pendaftar</label>
                            <input type="text" name="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                <option disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>-- Pilih Jenis Kelamin --
                                </option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn"
                                class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}"
                                required>
                            @error('nisn')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik') }}" required>
                            @error('nik')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah"
                                class="form-control @error('asal_sekolah') is-invalid @enderror"
                                value="{{ old('asal_sekolah') }}" required>
                            @error('asal_sekolah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir"
                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                value="{{ old('tempat_lahir') }}" required>
                            @error('tempat_lahir')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KKS</label>
                            <select name="kks" class="form-select @error('kks') is-invalid @enderror" required>
                                <option value="Ya" {{ old('kks') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('kks') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('kks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KPS/PKH</label>
                            <select name="kps" class="form-select @error('kps') is-invalid @enderror" required>
                                <option value="Ya" {{ old('kps') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('kps') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('kps')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KIP</label>
                            <select name="kip" class="form-select @error('kip') is-invalid @enderror" required>
                                <option value="Ya" {{ old('kip') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('kip') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('kip')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No WA</label>
                            <input type="text" name="wa"
                                class="form-control @error('wa') is-invalid @enderror" value="{{ old('wa') }}"
                                required>
                            @error('wa')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No WA Orang Tua</label>
                            <input type="text" name="wa_ortu"
                                class="form-control @error('wa_ortu') is-invalid @enderror"
                                value="{{ old('wa_ortu') }}">
                            @error('wa_ortu')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah"
                                class="form-control @error('nama_ayah') is-invalid @enderror"
                                value="{{ old('nama_ayah') }}" required>
                            @error('nama_ayah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu"
                                class="form-control @error('nama_ibu') is-invalid @enderror"
                                value="{{ old('nama_ibu') }}" required>
                            @error('nama_ibu')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Wali</label>
                            <input type="text" name="nama_wali"
                                class="form-control @error('nama_wali') is-invalid @enderror"
                                value="{{ old('nama_wali') }}">
                            @error('nama_wali')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pas Foto 3x4 (Background Merah)</label>
                            <input type="file" name="foto"
                                class="form-control @error('foto') is-invalid @enderror" required>
                            @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan Ijazah SD</label>
                            <input type="file" name="scan_ijazah"
                                class="form-control @error('scan_ijazah') is-invalid @enderror" required>
                            @error('scan_ijazah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan Kartu Keluarga</label>
                            <input type="file" name="scan_kk"
                                class="form-control @error('scan_kk') is-invalid @enderror" required>
                            @error('scan_kk')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan Biodata Raport SMP/MTs</label>
                            <input type="file" name="scan_raport"
                                class="form-control @error('scan_raport') is-invalid @enderror" required>
                            @error('scan_raport')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan KTP Orang Tua Ayah</label>
                            <input type="file" name="ktp_ayah"
                                class="form-control @error('ktp_ayah') is-invalid @enderror" required>
                            @error('ktp_ayah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan KTP Orang Tua Ibu</label>
                            <input type="file" name="ktp_ibu"
                                class="form-control @error('ktp_ibu') is-invalid @enderror" required>
                            @error('ktp_ibu')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan KIP/KIS atau Sejenisnya</label>
                            <input type="file" name="scan_kip"
                                class="form-control @error('scan_kip') is-invalid @enderror">
                            @error('scan_kip')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan SKTM</label>
                            <input type="file" name="scan_sktm"
                                class="form-control @error('scan_sktm') is-invalid @enderror">
                            @error('scan_sktm')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary px-5">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
            
            @endif
        @else
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary">Status Pendaftaran</h5>
                    </div>
                    <hr>
                    <div class="alert alert-info">
                        @if (is_null($ppdb->jadwal_test))
                            <strong>Status:</strong> Pendaftaran berhasil. Admin belum menetapkan jadwal tes. Silakan
                            cek kembali nanti.
                        @elseif ($ppdb->hasil_test == 0)
                            <strong>Status:</strong> Jadwal tes:
                            <strong>{{ \Carbon\Carbon::parse($ppdb->jadwal_test)->translatedFormat('d F Y') }}</strong><br>
                            Hasil tes belum dinilai atau Anda belum mengikuti tes.
                        @elseif ($ppdb->hasil_test == 1 && $ppdb->status_daftar_ulang == 0)
                            <strong>Selamat!</strong> Anda <span class="text-success">dinyatakan diterima</span>.<br>
                            Silakan melakukan <strong>daftar ulang</strong> di sekolah sesuai ketentuan yang berlaku.
                        @elseif ($ppdb->hasil_test == 1 && $ppdb->status_daftar_ulang == 1)
                            <strong>Selamat!</strong> Anda telah <span class="text-success">resmi diterima</span>
                            sebagai siswa SMK.<br>
                            Silakan menghubungi bagian pendaftaran sekolah untuk informasi lebih lanjut.
                        @elseif ($ppdb->hasil_test == 2)
                            <strong>Informasi:</strong> Saat ini Anda berada di status <strong>cadangan</strong>.
                            Silakan tunggu pengumuman selanjutnya dari sekolah.
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-guest-layout>
