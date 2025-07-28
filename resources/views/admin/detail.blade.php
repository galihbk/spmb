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

        <form method="POST" action="{{ route('admin.ppdb.update', $ppdb->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i></div>
                        <h5 class="mb-0 text-primary">Edit Data Pendaftar</h5>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Peminatan Jurusan</label>
                            <select name="jurusan" class="form-select @error('jurusan') is-invalid @enderror" required
                                @if(auth()->user()->role !== 'admin') disabled @endif>
                                <option disabled {{ $ppdb->jurusan ? '' : 'selected' }}>-- Pilih Jurusan --</option>
                                <option value="DPB" {{ $ppdb->jurusan == 'DPB' ? 'selected' : '' }}>Desain Produk
                                    Busana
                                    (DPB)</option>
                                <option value="TKJ" {{ $ppdb->jurusan == 'TKJ' ? 'selected' : '' }}>Teknik Jaringan
                                    Komputer (TKJ)
                                </option>
                                <option value="TBSM" {{ $ppdb->jurusan == 'TBSM' ? 'selected' : '' }}>Teknik dan
                                    Bisnis
                                    Sepeda Motor (TBSM)
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Pendaftar</label>
                            <input type="text" name="nama" class="form-control" value="{{ $ppdb->nama }}"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="form-select @error('jenis_kelamin') is-invalid @enderror" required
                                @if(auth()->user()->role !== 'admin') disabled @endif>
                                <option disabled {{ $ppdb->jenis_kelamin ? '' : 'selected' }}>-- Pilih Jenis Kelamin --
                                </option>
                                <option value="L" {{ $ppdb->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ $ppdb->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" value="{{ $ppdb->nisn }}"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ $ppdb->nik }}"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" class="form-control"
                                value="{{ $ppdb->asal_sekolah }}" @if(auth()->user()->role !== 'admin') @readonly(true)
                            @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control"
                                value="{{ $ppdb->tempat_lahir }}" @if(auth()->user()->role !== 'admin') @readonly(true)
                            @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="{{ $ppdb->tanggal_lahir }}" @if(auth()->user()->role !== 'admin') @readonly(true)
                            @endif>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>{{ $ppdb->alamat }}</textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KKS</label>
                            <select name="kks" class="form-select @error('kks') is-invalid @enderror" required
                                @if(auth()->user()->role !== 'admin') disabled @endif>
                                <option value="Ya" {{ $ppdb->kks == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ $ppdb->kks == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KPS/PKH</label>
                            <select name="kps" class="form-select @error('kps') is-invalid @enderror" required
                                @if(auth()->user()->role !== 'admin') disabled @endif>
                                <option value="Ya" {{ $ppdb->kps == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ $ppdb->kps == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KIP</label>
                            <select name="kip" class="form-select @error('kip') is-invalid @enderror" required
                                @if(auth()->user()->role !== 'admin') disabled @endif>
                                <option value="Ya" {{ $ppdb->kip == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ $ppdb->kip == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No WA</label>
                            <input type="text" name="wa" class="form-control" value="{{ $ppdb->wa }}"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No WA Orang Tua</label>
                            <input type="text" name="wa_ortu" class="form-control" value="{{ $ppdb->wa_ortu }}"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" value="{{ $ppdb->nama_ayah }}"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" value="{{ $ppdb->nama_ibu }}"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Wali</label>
                            <input type="text" name="nama_wali" class="form-control" value="{{ $ppdb->nama_wali }}"
                                @if(auth()->user()->role !== 'admin') @readonly(true) @endif>
                        </div>

                        <!-- Upload File Section -->
                        @php
                        $fileFields = [
                        'foto' => 'Pas Foto 3x4',
                        'scan_ijazah' => 'Scan Ijazah',
                        'scan_kk' => 'Scan KK',
                        'scan_raport' => 'Scan Raport',
                        'ktp_ayah' => 'KTP Ayah',
                        'ktp_ibu' => 'KTP Ibu',
                        'scan_kip' => 'KIP/KIS',
                        'scan_sktm' => 'Scan SKTM',
                        ];
                        @endphp

                        @foreach ($fileFields as $field => $label)
                        <div class="col-md-6">
                            <label class="form-label">{{ $label }}</label>
                            @if(auth()->user()->role == 'admin')
                            <input type="file" name="{{ $field }}" class="form-control">
                            @endif
                            @if ($ppdb->{$field})
                            <a href="{{ Storage::url($ppdb->{$field}) }}" target="_blank">Lihat File</a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @if(auth()->user()->role == 'admin')
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>