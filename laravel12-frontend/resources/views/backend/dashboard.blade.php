<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .header-card {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border-radius: 20px;
            padding: 25px;
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            transition: .3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .shadow-custom {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
        }

        .badge-status {
            padding: 8px 12px;
            font-size: 13px;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 3px;
        }

        .pagination .page-item.active .page-link {
            background: #4f46e5;
            border-color: #4f46e5;
        }

        .search-box {
            max-width: 500px;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        {{-- Header --}}
        <div class="header-card shadow-custom mb-4">
            <h2>
                <i class="fas fa-chart-line"></i>
                Inquiry Management Dashboard
            </h2>
            <p class="mb-0">
                Monitor and manage customer inquiries.
            </p>
        </div>

        {{-- Statistics --}}
        <div class="row mb-4">

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total</h6>
                        <h2>{{ $total }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <h6>Read</h6>
                        <h2>{{ $read }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card bg-warning">
                    <div class="card-body">
                        <h6>Unread</h6>
                        <h2>{{ $unread }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <h6>Today</h6>
                        <h2>{{ $today }}</h2>
                    </div>
                </div>
            </div>

        </div>

        {{-- Main Table --}}
        <div class="table-container shadow-custom">

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

                <h4>
                    <i class="fas fa-envelope"></i>
                    Customer Inquiries
                </h4>

                <div class="d-flex gap-2 flex-wrap">

                    {{-- Mark All Read --}}
                    <a href="{{ route('inquiry.readAll') }}" class="btn btn-success btn-sm"
                        onclick="return confirm('Mark all inquiries as read?')">
                        <i class="fas fa-check-double"></i>
                        Mark All Read
                    </a>

                    {{-- Search + Filter --}}
                    <form method="GET" class="d-flex search-box gap-2">

                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Search name/email">

                        <select name="status" class="form-control">
                            <option value="">All</option>

                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>
                                Read
                            </option>

                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>
                                Unread
                            </option>
                        </select>

                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>

                    </form>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover table-bordered">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($inquiries as $key => $inquiry)

                            <tr>

                                <td>
                                    {{ $inquiries->firstItem() + $key }}
                                </td>

                                <td>{{ $inquiry->name }}</td>

                                <td>{{ $inquiry->email }}</td>

                                <td>{{ $inquiry->phone }}</td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($inquiry->message, 80) }}
                                </td>

                                <td>
                                    @if($inquiry->is_read)
                                        <span class="badge bg-success">
                                            Read
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Unread
                                        </span>
                                    @endif
                                </td>

                                <td>

                                    @if(!$inquiry->is_read)

                                        <a href="{{ route('inquiry.read', $inquiry->id) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i>
                                        </a>

                                    @endif

                                    <a href="{{ route('inquiry.delete', $inquiry->id) }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this inquiry?')">

                                        <i class="fas fa-trash"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center">
                                    No inquiries found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination Numbers Only --}}
            @if($inquiries->lastPage() > 1)

                <div class="d-flex justify-content-center mt-4">

                    <nav>

                        <ul class="pagination">

                            @for($i = 1; $i <= $inquiries->lastPage(); $i++)

                                <li class="page-item {{ $i == $inquiries->currentPage() ? 'active' : '' }}">

                                    <a class="page-link" href="{{ $inquiries->appends(request()->query())->url($i) }}">

                                        {{ $i }}

                                    </a>

                                </li>

                            @endfor

                        </ul>

                    </nav>

                </div>

            @endif

        </div>

    </div>

    {{-- jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            preventDuplicates: true,
            positionClass: "toast-top-right",
            timeOut: "3000",
            extendedTimeOut: "1000"
        };
    </script>

    @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if(session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

</body>

</html>