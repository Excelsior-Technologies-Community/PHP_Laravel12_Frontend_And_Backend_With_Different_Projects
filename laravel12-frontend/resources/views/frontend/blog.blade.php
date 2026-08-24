@extends('layouts.frontend')

@section('title', $lang('blog'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 50vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('blog') }}</h1>
                    <p class="lead">{{ $lang('blog_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="row g-4">
                @forelse($blogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="glass-card overflow-hidden h-100">
                            @if($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 220px; background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end)); color: white; font-size: 3rem;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <small class="text-muted"><i class="far fa-calendar me-1"></i>{{ $blog->created_at->format('M d, Y') }}</small>
                                    @if($blog->author)
                                        <small class="text-muted"><i class="far fa-user me-1"></i>{{ $blog->author }}</small>
                                    @endif
                                </div>
                                <h5 class="fw-semibold mb-2">{{ $blog->title }}</h5>
                                <p class="text-muted small">{{ $blog->excerpt }}</p>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary-custom btn-sm mt-2">
                                    {{ $lang('read_more') }} <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ $lang('no_blogs_found') }}</p>
                    </div>
                @endforelse
            </div>

            @if($blogs->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $blogs->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
