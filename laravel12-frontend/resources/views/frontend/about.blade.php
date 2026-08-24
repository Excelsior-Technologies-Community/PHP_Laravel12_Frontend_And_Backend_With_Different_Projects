@extends('layouts.frontend')

@section('title', $lang('about'))

@section('content')
    {{-- Hero Section --}}
    <section class="hero-gradient text-white py-5" style="min-height: 60vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('about_us') }}</h1>
                    <p class="lead">{{ $lang('about_us_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Story --}}
    <section class="py-5">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="section-title">{{ $lang('our_story') }}</h2>
                    <p class="text-muted">{{ $lang('our_story_desc') }}</p>
                    <p class="text-muted">{{ $lang('our_story_desc2') }}</p>
                </div>
                <div class="col-lg-6">
                    <div class="glass-card p-4">
                        <img src="https://via.placeholder.com/600x400/4f46e5/ffffff?text=Our+Story" alt="Our Story" class="img-fluid rounded-3">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission / Vision --}}
    <section class="py-5" style="background: var(--bg-secondary);">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">{{ $lang('mission_vision') }}</h2>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="glass-card p-5 h-100 border-start border-4" style="border-color: #4f46e5 !important;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white;">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ $lang('our_mission') }}</h4>
                        </div>
                        <p class="text-muted">{{ $lang('mission_desc') }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="glass-card p-5 h-100 border-start border-4" style="border-color: #7c3aed !important;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #7c3aed, #9333ea); color: white;">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ $lang('our_vision') }}</h4>
                        </div>
                        <p class="text-muted">{{ $lang('vision_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team Section --}}
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">{{ $lang('our_team') }}</h2>
                <p class="text-muted">{{ $lang('team_desc') }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 text-center">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; font-size: 2rem; font-weight: 700;">JD</div>
                        <h5 class="fw-semibold">John Doe</h5>
                        <p class="text-muted small">CEO & Founder</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 text-center">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, #7c3aed, #9333ea); color: white; font-size: 2rem; font-weight: 700;">AS</div>
                        <h5 class="fw-semibold">Alice Smith</h5>
                        <p class="text-muted small">CTO</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 text-center">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, #9333ea, #a855f7); color: white; font-size: 2rem; font-weight: 700;">BW</div>
                        <h5 class="fw-semibold">Bob Wilson</h5>
                        <p class="text-muted small">Lead Developer</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 text-center">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, #a855f7, #c084fc); color: white; font-size: 2rem; font-weight: 700;">EJ</div>
                        <h5 class="fw-semibold">Emma Johnson</h5>
                        <p class="text-muted small">Marketing Head</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
