<x-guest-layout>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Persyaratan Pendaftar</h3>
            </div>
            <div class="card-body">
                Untuk calon pendaftar harap menyiapkan dokumen yang dibutuhkan, dan dibawa saat melakukan test:
                <ul id="persyaratan-list">
                    @foreach ($data as $item)
                        <li data-id="{{ $item->id }}">
                            <span class="text">{{ $item->persyaratan }}</span>
                            <input type="text" class="edit-input form-control d-none" value="{{ $item->persyaratan }}">

                            @if (auth()->user() && auth()->user()->role === 'admin')
                                <button class="btn btn-sm btn-warning btn-edit">Edit</button>
                                <button class="btn btn-sm btn-success btn-update d-none">Simpan</button>
                                <button class="btn btn-sm btn-danger btn-hapus">Hapus</button>
                            @endif
                        </li>
                    @endforeach

                </ul>

                @if (auth()->user() && auth()->user()->role === 'admin')
                    <div class="mt-3">
                        <input type="text" id="input-persyaratan" class="form-control d-inline-block"
                            style="width: 70%;" placeholder="Tambah persyaratan baru">
                        <button id="btn-tambah" class="btn btn-primary">Tambah</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Tambah
                $('#btn-tambah').click(function() {
                    let nama = $('#input-persyaratan').val().trim();
                    if (nama !== '') {
                        $.post('/persyaratan', {
                            nama: nama,
                            _token: '{{ csrf_token() }}'
                        }, function(data) {
                            $('#persyaratan-list').append(`
                            <li data-id="${data.id}">
                                <span class="text">${data.persyaratan}</span>
                                <input type="text" class="edit-input form-control d-none" value="${data.persyaratan}">
                                <button class="btn btn-sm btn-warning btn-edit">Edit</button>
                                <button class="btn btn-sm btn-success btn-update d-none">Simpan</button>
                                <button class="btn btn-sm btn-danger btn-hapus">Hapus</button>
                            </li>
                        `);
                            $('#input-persyaratan').val('');
                        });
                    }
                });

                // Hapus
                $(document).on('click', '.btn-hapus', function() {
                    let li = $(this).closest('li');
                    let id = li.data('id');

                    $.ajax({
                        url: `/persyaratan/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            li.remove();
                        }
                    });
                });

                // Edit
                $(document).on('click', '.btn-edit', function() {
                    let li = $(this).closest('li');
                    li.find('.text').addClass('d-none');
                    li.find('.edit-input').removeClass('d-none');
                    li.find('.btn-edit').addClass('d-none');
                    li.find('.btn-update').removeClass('d-none');
                });

                // Update
                $(document).on('click', '.btn-update', function() {
                    let li = $(this).closest('li');
                    let id = li.data('id');
                    let newNama = li.find('.edit-input').val();

                    $.ajax({
                        url: `/persyaratan/${id}`,
                        type: 'PUT',
                        data: {
                            nama: newNama,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            li.find('.text').text(res.nama).removeClass('d-none');
                            li.find('.edit-input').addClass('d-none');
                            li.find('.btn-edit').removeClass('d-none');
                            li.find('.btn-update').addClass('d-none');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-guest-layout>
