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
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary">Detail Data Pendaftar</h5>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Peminatan Jurusan</label>
                            <input type="text" class="form-control" value="{{ $ppdb->jurusan }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Pendaftar</label>
                            <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->nama}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->jenis_kelamin}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NISN</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->nisn}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->nik}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Asal Sekolah</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->asal_sekolah}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->tempat_lahir}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->tanggal_lahir}}" readonly>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" readonly>{{ $ppdb->alamat }}</textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KKS</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->kks}}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KPS/PKH</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->kps}}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">KIP</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->kip}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No WA</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->wa}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No WA Orang Tua</label>
                             <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->wa_ortu}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->nama_ayah}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Ibu</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->nama_ibu}}" readonly>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Wali</label>
                              <input type="text" name="nama"
                                class="form-control" value="{{$ppdb->nama_wali}}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pas Foto 3x4 (Background Merah)</label>
                            @if ($ppdb && $ppdb->foto)
    <div>
        <a href="{{ Storage::url($ppdb->foto) }}" target="_blank">Lihat Foto</a>
    </div>
@endif

                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan Ijazah SD</label>
                            @if ($ppdb && $ppdb->scan_ijazah)
    <div>
        <a href="{{ Storage::url($ppdb->scan_ijazah) }}" target="_blank">Lihat Foto</a>
    </div>
@endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan Kartu Keluarga</label>
                            @if ($ppdb && $ppdb->scan_kk)
    <div>
        <a href="{{ Storage::url($ppdb->scan_kk) }}" target="_blank">Lihat Foto</a>
    </div>
@endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan Biodata Raport SMP/MTs</label>
                            @if ($ppdb && $ppdb->scan_raport)
    <div>
        <a href="{{ Storage::url($ppdb->scan_raport) }}" target="_blank">Lihat Foto</a>
    </div>
@endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan KTP Orang Tua Ayah</label>
                            @if ($ppdb && $ppdb->ktp_ayah)
    <div>
        <a href="{{ Storage::url($ppdb->ktp_ayah) }}" target="_blank">Lihat Foto</a>
    </div>
@endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan KTP Orang Tua Ibu</label>
                            @if ($ppdb && $ppdb->ktp_ibu)
    <div>
        <a href="{{ Storage::url($ppdb->ktp_ibu) }}" target="_blank">Lihat Foto</a>
    </div>
@endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan KIP/KIS atau Sejenisnya</label>
                           @if ($ppdb && $ppdb->scan_kip)
    <div>
        <a href="{{ Storage::url($ppdb->scan_kip) }}" target="_blank">Lihat Foto</a>
    </div>
@endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Scan SKTM</label>
                            @if ($ppdb && $ppdb->scan_sktm)
    <div>
        <a href="{{ Storage::url($ppdb->sktm) }}" target="_blank">Lihat Foto</a>
    </div>
@endif
                        </div>
                </div>
            </div>
            </div>
    </div>
</x-guest-layout>
