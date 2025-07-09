<x-guest-layout>
    <div class="page-content">
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
            Pendaftaran <span id="statusText">{{ $setting && $setting->status_pendaftaran ? 'Dibuka' : 'Ditutup' }}</span>
        </label>
    </div>
</div>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered" id="pendaftar-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Jadwal Tes</th>
                            <th>Hasil Tes</th>
                            <th>Daftar Ulang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
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
                        <select name="hasil_test" id="hasil_test" class="form-select">
                            <option value="0">Tidak Lulus</option>
                            <option value="1">Lulus</option>
                            <option value="2">Cadangan</option>
                        </select>
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
                        <select name="status_daftar_ulang" id="status_daftar_ulang" class="form-select">
                            <option value="0">Belum</option>
                            <option value="1">Sudah</option>
                        </select>
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
            $('#toggleStatus').on('change', function () {
        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: '{{ route('setting.toggle') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function (response) {
                $('#statusText').text(status ? 'Dibuka' : 'Ditutup');
                console.log(response.message);
            },
            error: function () {
                alert('Gagal mengubah status.');
            }
        });
    });
            $('#modalJadwalTes').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                $('#jadwal_id').val(button.data('id'));
                $('#jadwal_test').val(button.data('jadwal'));
            });

            $('#modalHasilTes').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                $('#hasil_id').val(button.data('id'));
                $('#hasil_test').val(button.data('hasil'));
            });

            $('#modalDaftarUlang').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                $('#daftar_id').val(button.data('id'));
                $('#status_daftar_ulang').val(button.data('status'));
            });
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
                            data: 'hasil_test',
                            name: 'hasil_test'
                        },
                        {
                            data: 'status_daftar_ulang',
                            name: 'status_daftar_ulang'
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
