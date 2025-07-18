<x-guest-layout>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <h3 class="">Masuk</h3>
                                    <p>Tidak punya akun? <a href="{{ route('register') }}">Daftar disini</a>
                                    </p>
                                </div>
                                <div class="login-separater text-center mb-4"> <span>MASUK DENGAN EMAIL</span>
                                    <hr>
                                </div>
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="inputEmailAddress" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="inputEmailAddress"
                                                placeholder="Email Address" name="email">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label">Kata Sandi</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" class="form-control border-end-0"
                                                    id="inputChoosePassword" placeholder="Enter Password"
                                                    name="password">
                                                <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                        class="bx bx-hide"></i></a>
                                            </div>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="bx bxs-lock-open"></i>Masuk</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#show_hide_password a").on('click', function(event) {
                    event.preventDefault();
                    if ($('#show_hide_password input').attr("type") == "text") {
                        $('#show_hide_password input').attr('type', 'password');
                        $('#show_hide_password i').addClass("bx-hide");
                        $('#show_hide_password i').removeClass("bx-show");
                    } else if ($('#show_hide_password input').attr("type") == "password") {
                        $('#show_hide_password input').attr('type', 'text');
                        $('#show_hide_password i').removeClass("bx-hide");
                        $('#show_hide_password i').addClass("bx-show");
                    }
                });
            });
        </script>
    @endpush
</x-guest-layout>
