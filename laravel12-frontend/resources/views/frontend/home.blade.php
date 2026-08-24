@extends('layouts.frontend')

@section('title', $lang('home'))

@section('content')
    {{-- Hero Section --}}
    <section class="hero-gradient text-white py-5" style="min-height: 85vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('welcome_to_inquirypro') }}</h1>
                    <p class="lead mb-4">{{ $lang('submit_inquiry_desc') }}</p>
                    <div class="d-flex gap-3">
                        <a href="#inquiry-form" class="btn btn-light btn-lg fw-semibold">
                            <i class="fas fa-paper-plane me-2"></i>{{ $lang('submit_inquiry') }}
                        </a>
                        <a href="{{ route('inquiry.track.form') }}" class="btn btn-outline-light btn-lg fw-semibold">
                            <i class="fas fa-search me-2"></i>{{ $lang('track_inquiry') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                    <i class="fas fa-envelope-open-text" style="font-size: 18rem; opacity: 0.9;"></i>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories Section --}}
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">{{ $lang('our_categories') }}</h2>
                <p class="text-muted">{{ $lang('choose_category_desc') }}</p>
            </div>
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-lg-3 col-md-6">
                        <div class="glass-card p-4 text-center h-100">
                            <div class="icon-box mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end)); display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                <i class="fas {{ $category->icon ?? 'fa-tag' }}"></i>
                            </div>
                            <h5 class="fw-semibold">{{ $category->name }}</h5>
                            <p class="text-muted small">{{ $category->description ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-5" style="background: var(--bg-secondary);">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">{{ $lang('how_it_works') }}</h2>
                <p class="text-muted">{{ $lang('how_it_works_desc') }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="glass-card p-5 text-center h-100">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; font-size: 2rem; font-weight: 700;">1</div>
                        <h5 class="fw-semibold">{{ $lang('step1_title') }}</h5>
                        <p class="text-muted">{{ $lang('step1_desc') }}</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="glass-card p-5 text-center h-100">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #7c3aed, #9333ea); color: white; font-size: 2rem; font-weight: 700;">2</div>
                        <h5 class="fw-semibold">{{ $lang('step2_title') }}</h5>
                        <p class="text-muted">{{ $lang('step2_desc') }}</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="glass-card p-5 text-center h-100">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #9333ea, #a855f7); color: white; font-size: 2rem; font-weight: 700;">3</div>
                        <h5 class="fw-semibold">{{ $lang('step3_title') }}</h5>
                        <p class="text-muted">{{ $lang('step3_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">{{ $lang('testimonials') }}</h2>
                <p class="text-muted">{{ $lang('testimonials_desc') }}</p>
            </div>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($testimonials->chunk(1) as $chunk)
                        @foreach($chunk as $index => $testimonial)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="glass-card p-5 text-center">
                                            <div class="mb-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star" style="color: {{ $i <= $testimonial->rating ? '#fbbf24' : '#d1d5db' }};"></i>
                                                @endfor
                                            </div>
                                            <p class="lead mb-4">"{{ $testimonial->message }}"</p>
                                            <div class="d-flex align-items-center justify-content-center gap-3">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-weight: 600;">
                                                    {{ substr($testimonial->name, 0, 1) }}
                                                </div>
                                                <div class="text-start">
                                                    <h6 class="mb-0 fw-semibold">{{ $testimonial->name }}</h6>
                                                    <small class="text-muted">{{ $testimonial->position }}, {{ $testimonial->company }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section>

    {{-- Latest Blogs --}}
    <section class="py-5" style="background: var(--bg-secondary);">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="section-title">{{ $lang('latest_blogs') }}</h2>
                    <p class="text-muted">{{ $lang('latest_blogs_desc') }}</p>
                </div>
                <a href="{{ route('blog') }}" class="btn btn-primary-custom">{{ $lang('view_all') }}</a>
            </div>
            <div class="row g-4">
                @foreach($blogs->take(3) as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="glass-card overflow-hidden h-100">
                            @if($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end)); color: white; font-size: 3rem;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <small class="text-muted">{{ $blog->created_at->format('M d, Y') }}</small>
                                <h5 class="fw-semibold mt-2">{{ $blog->title }}</h5>
                                <p class="text-muted small">{{ $blog->excerpt }}</p>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none fw-semibold">{{ $lang('read_more') }} <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Inquiry Form Section --}}
    <section id="inquiry-form" class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="glass-card p-5">
                        <div class="text-center mb-4">
                            <h2 class="section-title">{{ $lang('submit_inquiry') }}</h2>
                            <p class="text-muted">{{ $lang('submit_inquiry_desc') }}</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="inquiryForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('full_name') }} *</label>
                                    <input type="text" class="form-control" name="name" required placeholder="{{ $lang('enter_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('email') }} *</label>
                                    <input type="email" class="form-control" name="email" required placeholder="{{ $lang('enter_email') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('phone') }}</label>
                                    <input type="text" class="form-control" name="phone" placeholder="{{ $lang('enter_phone') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('subject') }} *</label>
                                    <input type="text" class="form-control" name="subject" required placeholder="{{ $lang('enter_subject') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('category') }} *</label>
                                    <select class="form-select" name="category_id" required>
                                        <option value="">{{ $lang('select_category') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ $lang('attachment') }}</label>
                                    <input type="file" class="form-control" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ $lang('message') }} *</label>
                                    <textarea class="form-control" rows="5" name="message" required placeholder="{{ $lang('enter_message') }}"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom btn-lg px-5" id="submitBtn">
                                        <span class="spinner-border spinner-border-sm d-none" id="btnSpinner"></span>
                                        <span id="btnText"><i class="fas fa-paper-plane me-2"></i>{{ $lang('submit_inquiry') }}</span>
                                    </button>
                                </div>
                            </div>
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
        $('#inquiryForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = $('#submitBtn');
            const spinner = $('#btnSpinner');
            const btnText = $('#btnText');

            btn.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('{{ $lang("submitting") }}...');

            $.ajax({
                url: '{{ route("inquiry.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message);
                    $('#inquiryForm')[0].reset();
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
                    btnText.html('<i class="fas fa-paper-plane me-2"></i>{{ $lang("submit_inquiry") }}');
                }
            });
        });
    });
</script>
@endsection
