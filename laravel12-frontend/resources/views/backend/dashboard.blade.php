@extends('backend.layout')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="glass-card p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Total Inquiries</p>
                        <h3 class="fw-bold mb-0">{{ $total }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                        <i class="fas fa-inbox fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="glass-card p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Read</p>
                        <h3 class="fw-bold mb-0">{{ $read }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="glass-card p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Unread</p>
                        <h3 class="fw-bold mb-0">{{ $unread }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="glass-card p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Today</p>
                        <h3 class="fw-bold mb-0">{{ $today }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                        <i class="fas fa-calendar-day fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
            <h4 class="fw-bold mb-0"><i class="fas fa-envelope me-2" style="color: #4f46e5;"></i>Customer Inquiries</h4>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.inquiry.readAll') }}" class="btn btn-success btn-sm" onclick="return confirm('Mark all inquiries as read?')">
                    <i class="fas fa-check-double me-1"></i>Mark All Read
                </a>
                <form method="GET" class="d-flex gap-2">
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search...">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                    </select>
                    <button class="btn btn-primary-custom"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Reference</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Date</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                        <tr>
                            <td class="fw-semibold">{{ $inquiry->reference_number }}</td>
                            <td>{{ $inquiry->name }}</td>
                            <td>{{ $inquiry->email }}</td>
                            <td>{{ $inquiry->subject }}</td>
                            <td>{{ $inquiry->category->name ?? 'N/A' }}</td>
                            <td>
                                @if($inquiry->is_read)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-danger">Unread</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($inquiry->priority) }}</td>
                            <td>{{ $inquiry->created_at->format('M d, Y') }}</td>
                            <td>
                                @if(!$inquiry->is_read)
                                    <a href="{{ route('admin.inquiry.read', $inquiry->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.inquiry.delete', $inquiry->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No inquiries found</td>
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
@endsection
