@extends('layouts.frontend')

@section('title', $lang('testimonials'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 50vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('testimonials') }}</h1>
                    <p class="lead">{{ $lang('testimonials_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="row g-4">
                @forelse($testimonials as $testimonial)
                    <div class="col-lg-4 col-md-6">
                        <div class="glass-card p-5 h-100">
                            <div class="mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="color: {{ $i <= $testimonial->rating ? '#fbbf24' : '#d1d5db' }};"></i>
                                @endfor
                            </div>
                            <p class="fst-italic mb-4">"{{ $testimonial->message }}"</p>
                            <div class="d-flex align-items-center gap-3 mt-auto">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-weight: 600; flex-shrink: 0;">
                                    {{ substr($testimonial->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $testimonial->name }}</h6>
                                    <small class="text-muted">{{ $testimonial->position }}, {{ $testimonial->company }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ $lang('no_testimonials') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
