@extends('layouts.frontend')

@section('title', $lang('tracking_result'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 50vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('tracking_result') }}</h1>
                    <p class="lead">{{ $lang('tracking_result_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="glass-card p-5">
                        <div class="text-center mb-4">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end)); color: white; font-size: 2rem;">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h3 class="fw-bold">{{ $lang('inquiry_details') }}</h3>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small">{{ $lang('reference_number') }}</label>
                                <p class="fw-semibold">{{ $inquiry->reference_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">{{ $lang('status') }}</label>
                                <p>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'in_progress' => 'info',
                                            'resolved' => 'success',
                                            'closed' => 'secondary'
                                        ];
                                        $statusColor = $statusColors[$inquiry->status] ?? 'primary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }} fs-6">{{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">{{ $lang('subject') }}</label>
                                <p class="fw-semibold">{{ $inquiry->subject }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">{{ $lang('category') }}</label>
                                <p class="fw-semibold">{{ $inquiry->category->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">{{ $lang('priority') }}</label>
                                <p class="fw-semibold">{{ ucfirst($inquiry->priority) }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">{{ $lang('date') }}</label>
                                <p class="fw-semibold">{{ $inquiry->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small">{{ $lang('message') }}</label>
                                <p class="fw-semibold">{{ $inquiry->message }}</p>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('inquiry.track.form') }}" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search me-2"></i>{{ $lang('track_another') }}
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-primary-custom">
                                <i class="fas fa-home me-2"></i>{{ $lang('back_to_home') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
