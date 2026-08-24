@extends('layouts.frontend')

@section('title', $lang('contact'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 50vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('contact_us') }}</h1>
                    <p class="lead">{{ $lang('contact_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="glass-card p-5 h-100">
                        <h3 class="fw-bold mb-4">{{ $lang('get_in_touch') }}</h3>
                        <div class="d-flex align-items-start mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; flex-shrink: 0;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $lang('address') }}</h6>
                                <p class="text-muted small mb-0">Surat, Gujarat, India</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: linear-gradient(135deg, #7c3aed, #9333ea); color: white; flex-shrink: 0;">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $lang('phone') }}</h6>
                                <p class="text-muted small mb-0">+91 98765 43210</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: linear-gradient(135deg, #9333ea, #a855f7); color: white; flex-shrink: 0;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $lang('email') }}</h6>
                                <p class="text-muted small mb-0">info@inquirypro.com</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: linear-gradient(135deg, #a855f7, #c084fc); color: white; flex-shrink: 0;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $lang('working_hours') }}</h6>
                                <p class="text-muted small mb-0">Mon - Fri: 9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="glass-card p-5">
                        <h3 class="fw-bold mb-4">{{ $lang('send_message') }}</h3>

                        @if(session('success'))
                            <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
                        @endif

                        <form id="contactForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('full_name') }} *</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('email') }} *</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('phone') }}</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('subject') }} *</label>
                                    <input type="text" class="form-control" name="subject" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ $lang('message') }} *</label>
                                    <textarea class="form-control" rows="5" name="message" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom" id="contactSubmitBtn">
                                        <span class="spinner-border spinner-border-sm d-none" id="contactBtnSpinner"></span>
                                        <span id="contactBtnText"><i class="fas fa-paper-plane me-2"></i>{{ $lang('send_message') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="glass-card overflow-hidden">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.5!2d72.8!3d21.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDE0JzA1LjQiTiA3MsKwNDcnMjQuNCJF!5e0!3m2!1sen!2sin!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#contactSubmitBtn');
            const spinner = $('#contactBtnSpinner');
            const btnText = $('#contactBtnText');

            btn.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('{{ $lang("sending") }}...');

            $.ajax({
                url: '{{ route("contact.store") }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success(response.message);
                    $('#contactForm')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorMsg = '';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMsg += value[0] + '<br>';
                        });
                        toastr.error(errorMsg);
                    } else {
                        toastr.error('{{ $lang("something_went_wrong") }}');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');
                    btnText.html('<i class="fas fa-paper-plane me-2"></i>{{ $lang("send_message") }}');
                }
            });
        });
    });
</script>
@endsection
