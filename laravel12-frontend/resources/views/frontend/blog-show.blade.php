@extends('layouts.frontend')

@section('title', $blog->title)

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 50vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <a href="{{ route('blog') }}" class="btn btn-outline-light mb-3">
                        <i class="fas fa-arrow-left me-2"></i>{{ $lang('back_to_blog') }}
                    </a>
                    <h1 class="display-4 fw-bold mb-3">{{ $blog->title }}</h1>
                    <div class="d-flex align-items-center justify-content-center gap-4">
                        <span><i class="far fa-user me-2"></i>{{ $blog->author }}</span>
                        <span><i class="far fa-calendar me-2"></i>{{ $blog->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="img-fluid rounded-4 mb-5 w-100" style="max-height: 400px; object-fit: cover;">
                    @endif

                    <div class="glass-card p-5">
                        <div class="mb-4">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('blog') }}" class="btn btn-primary-custom">
                            <i class="fas fa-arrow-left me-2"></i>{{ $lang('back_to_blog') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
