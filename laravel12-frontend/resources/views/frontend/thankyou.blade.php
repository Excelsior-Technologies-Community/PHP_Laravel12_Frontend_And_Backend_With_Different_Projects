@extends('layouts.frontend')

@section('title', $lang('thank_you'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 80vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); color: white; font-size: 3rem;">
                        <i class="fas fa-check"></i>
                    </div>
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('thank_you') }}</h1>
                    <p class="lead mb-4">{{ $lang('thank_you_desc') }}</p>

                    <div class="glass-card p-4 mb-4" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);">
                        <p class="text-muted small mb-1">{{ $lang('your_reference_number') }}</p>
                        <h3 class="fw-bold text-white mb-0">{{ $reference }}</h3>
                    </div>

                    <p class="text-white-50 mb-4">{{ $lang('save_reference') }}</p>

                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('inquiry.track.form') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-search me-2"></i>{{ $lang('track_inquiry') }}
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-home me-2"></i>{{ $lang('back_to_home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
