@extends('layouts.frontend')

@section('title', $lang('dashboard'))

@section('content')
    <section class="py-5">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">{{ $lang('welcome') }}, {{ Auth::user()->name }}</h2>
            </div>

            {{-- Stats Cards --}}
            <div class="row g-4 mb-5">
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 border-start border-4" style="border-color: #4f46e5 !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted small mb-1">{{ $lang('total_inquiries') }}</p>
                                <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                                <i class="fas fa-inbox fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 border-start border-4" style="border-color: #f59e0b !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted small mb-1">{{ $lang('pending') }}</p>
                                <h3 class="fw-bold mb-0">{{ $stats['pending'] }}</h3>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 border-start border-4" style="border-color: #3b82f6 !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted small mb-1">{{ $lang('in_progress') }}</p>
                                <h3 class="fw-bold mb-0">{{ $stats['in_progress'] }}</h3>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                                <i class="fas fa-spinner fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 border-start border-4" style="border-color: #10b981 !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted small mb-1">{{ $lang('resolved') }}</p>
                                <h3 class="fw-bold mb-0">{{ $stats['resolved'] }}</h3>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter and Search --}}
            <div class="glass-card p-4 mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">{{ $lang('search') }}</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="{{ $lang('search_inquiries') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ $lang('filter_by_status') }}</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">{{ $lang('all_statuses') }}</option>
                            <option value="pending">{{ $lang('pending') }}</option>
                            <option value="in_progress">{{ $lang('in_progress') }}</option>
                            <option value="resolved">{{ $lang('resolved') }}</option>
                            <option value="closed">{{ $lang('closed') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="glass-card p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ $lang('reference') }}</th>
                                <th>{{ $lang('subject') }}</th>
                                <th>{{ $lang('category') }}</th>
                                <th>{{ $lang('status') }}</th>
                                <th>{{ $lang('priority') }}</th>
                                <th>{{ $lang('date') }}</th>
                                <th>{{ $lang('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="inquiryTable">
                            @forelse($inquiries as $inquiry)
                                <tr>
                                    <td class="fw-semibold">{{ $inquiry->reference_number }}</td>
                                    <td>{{ $inquiry->subject }}</td>
                                    <td>{{ $inquiry->category->name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $statusColors = ['pending' => 'warning', 'in_progress' => 'info', 'resolved' => 'success', 'closed' => 'secondary'];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$inquiry->status] ?? 'primary' }}">{{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}</span>
                                    </td>
                                    <td>{{ ucfirst($inquiry->priority) }}</td>
                                    <td>{{ $inquiry->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('inquiry.track.form') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">{{ $lang('no_inquiries') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($inquiries->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $inquiries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            filterTable();
        });
        $('#statusFilter').on('change', function() {
            filterTable();
        });

        function filterTable() {
            const query = $('#searchInput').val().toLowerCase();
            const status = $('#statusFilter').val().toLowerCase();
            $('#inquiryTable tr').each(function() {
                const text = $(this).text().toLowerCase();
                const matchesQuery = text.includes(query);
                const matchesStatus = !status || text.includes(status);
                $(this).toggle(matchesQuery && matchesStatus);
            });
        }
    });
</script>
@endsection
