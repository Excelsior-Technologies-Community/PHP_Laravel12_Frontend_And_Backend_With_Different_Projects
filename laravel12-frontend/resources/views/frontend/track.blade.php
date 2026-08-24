@extends('layouts.frontend')

@section('title', $lang('track_inquiry'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 60vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('track_inquiry') }}</h1>
                    <p class="lead">{{ $lang('track_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="glass-card p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-search-location fa-3x mb-3" style="color: var(--gradient-start);"></i>
                            <h3 class="fw-bold">{{ $lang('track_your_inquiry') }}</h3>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
                        @endif

                        <form id="trackForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ $lang('reference_number') }} *</label>
                                <input type="text" class="form-control" name="reference_number" required placeholder="INQ-XXXXXXXX">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">{{ $lang('email') }} *</label>
                                <input type="email" class="form-control" name="email" required placeholder="{{ $lang('enter_email') }}">
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100" id="trackBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="trackBtnSpinner"></span>
                                <span id="trackBtnText"><i class="fas fa-search me-2"></i>{{ $lang('track') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#trackForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#trackBtn');
            const spinner = $('#trackBtnSpinner');
            const btnText = $('#trackBtnText');

            btn.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('{{ $lang("tracking") }}...');

            $.ajax({
                url: '{{ route("inquiry.track") }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('{{ $lang("something_went_wrong") }}');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');
                    btnText.html('<i class="fas fa-search me-2"></i>{{ $lang("track") }}');
                }
            });
        });
    });
</script>
@endsection
