<x-guest-layout>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Frequently Asked Questions</h3>
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach ($faqs as $faq)
                        <div class="accordion-item" data-id="{{ $faq->id }}">
                            <h2 class="accordion-header" id="heading-{{ $faq->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="false"
                                    aria-controls="collapse-{{ $faq->id }}">
                                    <span class="faq-question">{{ $faq->pertanyaan }}</span>
                                    <input type="text" class="form-control edit-pertanyaan d-none"
                                        value="{{ $faq->pertanyaan }}">
                                </button>
                            </h2>
                            <div id="collapse-{{ $faq->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading-{{ $faq->id }}" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="faq-answer">{!! nl2br(e($faq->jawaban)) !!}</div>
                                    <textarea class="form-control edit-jawaban d-none">{{ $faq->jawaban }}</textarea>

                                    @if (auth()->user() && auth()->user()->role === 'admin')
                                        <button class="btn btn-sm btn-warning btn-edit">Edit</button>
                                        <button class="btn btn-sm btn-success btn-simpan d-none">Simpan</button>
                                        <button class="btn btn-sm btn-secondary btn-batal d-none">Batal</button>
                                        <button class="btn btn-sm btn-danger btn-hapus">Hapus</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (auth()->user() && auth()->user()->role === 'admin')
                    <div class="mt-4">
                        <h5>Tambah FAQ</h5>
                        <input type="text" id="faq-pertanyaan" class="form-control mb-2" placeholder="Pertanyaan">
                        <textarea id="faq-jawaban" class="form-control mb-2" placeholder="Jawaban"></textarea>
                        <button id="btn-faq-tambah" class="btn btn-primary">Tambah</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Tambah FAQ
                $('#btn-faq-tambah').click(function() {
                    const pertanyaan = $('#faq-pertanyaan').val();
                    const jawaban = $('#faq-jawaban').val();

                    $.post('/faq', {
                        _token: '{{ csrf_token() }}',
                        pertanyaan,
                        jawaban
                    }, function(data) {
                        location.reload();
                    });
                });

                // Edit FAQ
                $('.btn-edit').click(function() {
                    let item = $(this).closest('.accordion-item');
                    item.find('.faq-question').addClass('d-none');
                    item.find('.edit-pertanyaan').removeClass('d-none');

                    item.find('.faq-answer').addClass('d-none');
                    item.find('.edit-jawaban').removeClass('d-none');

                    item.find('.btn-edit').addClass('d-none');
                    item.find('.btn-simpan, .btn-batal').removeClass('d-none');
                });

                // Batal Edit
                $('.btn-batal').click(function() {
                    let item = $(this).closest('.accordion-item');
                    item.find('.faq-question').removeClass('d-none');
                    item.find('.edit-pertanyaan').addClass('d-none');

                    item.find('.faq-answer').removeClass('d-none');
                    item.find('.edit-jawaban').addClass('d-none');

                    item.find('.btn-edit').removeClass('d-none');
                    item.find('.btn-simpan, .btn-batal').addClass('d-none');
                });

                // Simpan FAQ
                $('.btn-simpan').click(function() {
                    let item = $(this).closest('.accordion-item');
                    let id = item.data('id');
                    let pertanyaan = item.find('.edit-pertanyaan').val();
                    let jawaban = item.find('.edit-jawaban').val();

                    $.ajax({
                        url: `/faq/${id}`,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            pertanyaan: pertanyaan,
                            jawaban: jawaban
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                });

                // Hapus FAQ
                $('.btn-hapus').click(function() {
                    let item = $(this).closest('.accordion-item');
                    let id = item.data('id');

                    $.ajax({
                        url: `/faq/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            item.remove();
                        }
                    });
                });
            });
        </script>
    @endpush

</x-guest-layout>
