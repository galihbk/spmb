<x-guest-layout>
    <div class="page-content">
        <div class="card mb-4">
            <div class="card-body">
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($banners as $key => $banner)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="height: 400px">
                                <img src="{{ asset('storage/banners/' . $banner->image) }}" class="d-block w-100"
                                    alt="banner">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            @if (auth()->user() && auth()->user()->role === 'admin')
                <div class="card-footer text-end">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#bannerModal">Kelola
                        Banner</button>
                </div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Pendaftar</p>
                                <h4 class="my-1 text-info">{{ $totalPendaftar }}</h4>
                                <p class="mb-0 font-13"><br></p>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="bx bxs-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Terdaftar</p>
                                <h4 class="my-1 text-success">{{ $totalSudahDaftarUlang }}</h4>
                                <p class="mb-0 font-13"><br></p>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                    class="bx bxs-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Belum Selesai</p>
                                <h4 class="my-1 text-danger">{{ $totalBelumSelesai }}</h4>
                                <p class="mb-0 font-13"><br></p>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i
                                    class="bx bxs-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bannerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- List Banner -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Banner</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bannerList">
                            @foreach ($banners as $banner)
                                <tr data-id="{{ $banner->id }}">
                                    <td><img src="{{ asset('storage/banners/' . $banner->image) }}" height="100"></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btn-edit"
                                            data-id="{{ $banner->id }}">Edit</button>
                                        <button class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $banner->id }}">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <form id="formAddBanner" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image">Tambah Banner</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="urutan">Urutan</label>
                            <input type="number" name="urutan" class="form-control" required>
                        </div>
                        <button class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Tambah banner
                $('#formAddBanner').submit(function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    $.ajax({
                        url: "{{ route('banners.store') }}",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success(res) {
                            alert(res.message);
                            location.reload();
                        },
                        error(err) {
                            alert("Terjadi kesalahan.");
                        }
                    });
                });

                // Hapus banner
                $('.btn-delete').click(function() {
                    let id = $(this).data('id');
                    if (confirm("Yakin hapus banner ini?")) {
                        $.ajax({
                            url: `/banners/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success(res) {
                                alert(res.message);
                                location.reload();
                            }
                        });
                    }
                });

                // Edit banner
                $('.btn-edit').click(function() {
                    let id = $(this).data('id');
                    let row = $(this).closest('tr');
                    row.find('td:eq(0)').html(`
            <form class="formEditBanner" data-id="${id}" enctype="multipart/form-data">
                <input type="file" name="image" class="form-control mb-2" required>
                <button class="btn btn-sm btn-success">Simpan</button>
            </form>
        `);
                });

                // Submit update
                $(document).on('submit', '.formEditBanner', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    let formData = new FormData(this);
                    $.ajax({
                        url: `/banners/${id}`,
                        type: 'POST',
                        data: formData,
                        method: 'POST',
                        headers: {
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        contentType: false,
                        processData: false,
                        success(res) {
                            alert(res.message);
                            location.reload();
                        }
                    });
                });
            });
        </script>
    @endpush

</x-guest-layout>
