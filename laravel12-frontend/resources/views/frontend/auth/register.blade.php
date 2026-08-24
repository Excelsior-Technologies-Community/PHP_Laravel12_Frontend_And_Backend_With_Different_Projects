@extends('layouts.frontend')

@section('title', $lang('register'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 80vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="glass-card p-5" style="background: var(--card-bg); color: var(--text-primary);">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-plus fa-3x mb-3" style="color: var(--gradient-start);"></i>
                            <h2 class="fw-bold">{{ $lang('register') }}</h2>
                            <p class="text-muted">{{ $lang('register_desc') }}</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
                        @endif

                        <form id="registerForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ $lang('full_name') }} *</label>
                                <input type="text" class="form-control" name="name" required placeholder="{{ $lang('enter_name') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ $lang('email') }} *</label>
                                <input type="email" class="form-control" name="email" required placeholder="{{ $lang('enter_email') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ $lang('phone') }}</label>
                                <input type="text" class="form-control" name="phone" placeholder="{{ $lang('enter_phone') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ $lang('password') }} *</label>
                                <input type="password" class="form-control" name="password" required placeholder="{{ $lang('enter_password') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ $lang('confirm_password') }} *</label>
                                <input type="password" class="form-control" name="password_confirmation" required placeholder="{{ $lang('confirm_password') }}">
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100" id="registerBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="registerBtnSpinner"></span>
                                <span id="registerBtnText"><i class="fas fa-user-plus me-2"></i>{{ $lang('register') }}</span>
                            </button>
                        </form>

                        <p class="text-center mt-4 mb-0">
                            {{ $lang('already_have_account') }} <a href="{{ route('login') }}" class="fw-semibold" style="color: var(--gradient-start);">{{ $lang('login_here') }}</a>
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
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#registerBtn');
            const spinner = $('#registerBtnSpinner');
            const btnText = $('#registerBtnText');

            btn.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('{{ $lang("registering") }}...');

            $.ajax({
                url: '{{ route("register") }}',
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
                    btnText.html('<i class="fas fa-user-plus me-2"></i>{{ $lang("register") }}');
                }
            });
        });
    });
</script>
@endsection
