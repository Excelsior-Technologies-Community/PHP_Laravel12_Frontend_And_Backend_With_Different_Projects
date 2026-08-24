@extends('layouts.frontend')

@section('title', $lang('services'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 50vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('services') }}</h1>
                    <p class="lead">{{ $lang('services_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-lg-4 col-md-6">
                        <div class="glass-card p-5 h-100">
                            <div class="icon-box mb-4" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end)); display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 1.75rem;">
                                <i class="fas {{ $category->icon ?? 'fa-tag' }}"></i>
                            </div>
                            <h4 class="fw-bold mb-3">{{ $category->name }}</h4>
                            <p class="text-muted">{{ $category->description ?? '' }}</p>
                            <a href="{{ route('contact') }}" class="btn btn-primary-custom mt-3">
                                {{ $lang('get_started') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
