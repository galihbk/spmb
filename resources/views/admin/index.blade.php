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
                    <h5 class="mb-0 text-primary">List Pendaftar</h5>
                    <div class="ms-auto">
                        <div class="ms-auto">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="toggleStatus"
                                    {{ $setting && $setting->status_pendaftaran ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggleStatus">
                                    Pendaftaran <span
                                        id="statusText">{{ $setting && $setting->status_pendaftaran ? 'Dibuka' : 'Ditutup' }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <a href="{{ route('admin.form-ppdb') }}" class="btn btn-primary">Tambah Pendaftar</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="pendaftar-table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Jadwal Tes</th>
                                <th>Hasil Tes</th>
                                <th>Daftar Ulang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalJadwalTes" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.update-jadwal') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="jadwal_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Jadwal Tes</h5>
                    </div>
                    <div class="modal-body">
                        <input type="date" name="jadwal_test" id="jadwal_test" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modalUploadBukti" tabindex="-1" aria-labelledby="modalUploadBuktiLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form form id="uploadBuktiForm" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUploadBuktiLabel">Upload Bukti Daftar Ulang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bukti_daftar_ulang" class="form-label">Pilih File (PDF/JPG/PNG)</label>
                        <input type="file" class="form-control" id="bukti_daftar_ulang" name="bukti_daftar_ulang"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Kirim</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal: Hasil Tes -->
    <div class="modal fade" id="modalHasilTes" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.update-hasil') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="hasil_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Hasil Tes</h5>
                    </div>
                    <div class="modal-body">
                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Keterangan</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Tes Wawancara</td>
                                    <td><input type="number" placeholder="1-100" name="wawancara" min="0"
                                            value="0" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Tes Baca Tulis</td>
                                    <td><input type="number" placeholder="1-100" name="baca_tulis" min="0"
                                            value="0" class="form-control"></td>

                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tes Baca Tulis Qur'an</td>
                                    <td><input type="number" placeholder="1-100" name="btq" min="0"
                                            value="0" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Tes Buta Warna</td>
                                    <td><input type="number" placeholder="1-100" name="buta_warna" min="0"
                                            value="0" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Tes Fisik</td>
                                    <td><input type="number" placeholder="1-100" name="fisik" min="0"
                                            value="0" class="form-control"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Daftar Ulang -->
    <div class="modal fade" id="modalDaftarUlang" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.update-daftarulang') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="daftar_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Daftar Ulang</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3" id="buktiContainer">
                            <label for="">Bukti Daftar Ulang:</label>
                            <br>
                            <a href="#" target="_blank" id="buktiLink" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-file-earmark-arrow-down"></i> Download Bukti
                            </a>
                        </div>
                        <div class="form-group">
                            <label for="">Status Daftar Ulang</label>
                            <select name="status_daftar_ulang" id="status_daftar_ulang" class="form-select">
                                <option value="1">Terima</option>
                                <option value="2">Tolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#toggleStatus').on('change', function() {
                let status = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: '{{ route('setting.toggle') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        $('#statusText').text(status ? 'Dibuka' : 'Ditutup');
                        console.log(response.message);
                    },
                    error: function() {
                        alert('Gagal mengubah status.');
                    }
                });
            });

            // Modal: Jadwal Tes
            $('#modalJadwalTes').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                $('#jadwal_id').val(button.data('id'));
                $('#jadwal_test').val(button.data('jadwal'));
            });

            $('#modalUploadBukti').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let id = button.data('id');

                let form = $('#uploadBuktiForm');
                let url = "{{ route('ppdb.uploadBukti', ':id') }}"; // placeholder
                url = url.replace(':id', id); // ganti :id dengan id asli

                form.attr('action', url);
            });

            // Modal: Hasil Tes
            $('#modalHasilTes').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                $('#hasil_id').val(button.data('id'));
                // Kalau ingin isi nilai sebelumnya, kamu bisa sesuaikan di sini
            });

            // Modal: Update Status Daftar Ulang
            $('#modalDaftarUlang').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let id = button.data('id');
                let buktiUrl = button.data('bukti');

                $('#daftar_id').val(id);

                if (buktiUrl) {
                    $('#buktiContainer').show();
                    $('#buktiLink').attr('href', buktiUrl);
                } else {
                    $('#buktiContainer').hide();
                    $('#buktiLink').attr('href', '#');
                }
            });

            // DataTables Init
            $(function() {
                $('#pendaftar-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('admin.data') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'jurusan',
                            name: 'jurusan'
                        },
                        {
                            data: 'jadwal_test',
                            name: 'jadwal_test'
                        },
                        {
                            data: 'nilai_test',
                            name: 'nilai_test'
                        },
                        {
                            data: 'status_daftar_ulang',
                            name: 'status_daftar_ulang'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'aksi',
                            name: 'aksi',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    @endpush

</x-guest-layout>
