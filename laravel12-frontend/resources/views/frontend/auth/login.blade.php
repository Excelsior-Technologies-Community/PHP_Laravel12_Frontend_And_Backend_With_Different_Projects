@extends('layouts.frontend')

@section('title', $lang('login'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 80vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="glass-card p-5" style="background: var(--card-bg); color: var(--text-primary);">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-circle fa-3x mb-3" style="color: var(--gradient-start);"></i>
                            <h2 class="fw-bold">{{ $lang('login') }}</h2>
                            <p class="text-muted">{{ $lang('login_desc') }}</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
                        @endif

                        <form id="loginForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ $lang('email') }} *</label>
                                <input type="email" class="form-control" name="email" required placeholder="{{ $lang('enter_email') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ $lang('password') }} *</label>
                                <input type="password" class="form-control" name="password" required placeholder="{{ $lang('enter_password') }}">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">{{ $lang('remember_me') }}</label>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100" id="loginBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="loginBtnSpinner"></span>
                                <span id="loginBtnText"><i class="fas fa-sign-in-alt me-2"></i>{{ $lang('login') }}</span>
                            </button>
                        </form>

                        <p class="text-center mt-4 mb-0">
                            {{ $lang('dont_have_account') }} <a href="{{ route('register') }}" class="fw-semibold" style="color: var(--gradient-start);">{{ $lang('register_here') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#loginBtn');
            const spinner = $('#loginBtnSpinner');
            const btnText = $('#loginBtnText');

            btn.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('{{ $lang("logging_in") }}...');

            $.ajax({
                url: '{{ route("login") }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorMsg = '';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMsg += value[0] + '<br>';
                        });
                        toastr.error(errorMsg);
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('{{ $lang("something_went_wrong") }}');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');
                    btnText.html('<i class="fas fa-sign-in-alt me-2"></i>{{ $lang("login") }}');
                }
            });
        });
    });
</script>
@endsection
