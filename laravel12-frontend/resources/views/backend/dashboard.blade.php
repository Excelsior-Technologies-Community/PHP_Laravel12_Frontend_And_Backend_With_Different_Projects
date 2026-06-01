<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

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

        .table td {
            vertical-align: middle;
        }

        .search-box {
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="container py-4">

    <div class="header-card shadow-custom mb-4">
        <h2>
            <i class="fas fa-chart-line"></i>
            Inquiry Management Dashboard
        </h2>
        <p class="mb-0">
            Monitor and manage customer inquiries.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card shadow-custom bg-primary text-white">
                <div class="card-body">
                    <h6>Total Inquiries</h6>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card shadow-custom bg-success text-white">
                <div class="card-body">
                    <h6>Read Inquiries</h6>
                    <h2>{{ $read }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card shadow-custom bg-warning">
                <div class="card-body">
                    <h6>Unread Inquiries</h6>
                    <h2>{{ $unread }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card shadow-custom bg-info text-white">
                <div class="card-body">
                    <h6>Today's Inquiries</h6>
                    <h2>{{ $today }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="table-container shadow-custom">

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h4>
                <i class="fas fa-envelope"></i>
                Customer Inquiries
            </h4>

            <form method="GET" class="d-flex search-box">
                <input
                    type="text"
                    class="form-control me-2"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name or email"
                >

                <button class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="table-responsive">

            <table class="table table-hover table-bordered">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
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
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $inquiry->name }}</td>
                            <td>{{ $inquiry->email }}</td>
                            <td>{{ $inquiry->phone }}</td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($inquiry->message, 80) }}
                            </td>

                            <td>
                                @if($inquiry->is_read)
                                    <span class="badge bg-success badge-status">
                                        Read
                                    </span>
                                @else
                                    <span class="badge bg-danger badge-status">
                                        Unread
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if(!$inquiry->is_read)
                                    <a
                                        href="{{ route('inquiry.read', $inquiry->id) }}"
                                        class="btn btn-success btn-sm"
                                    >
                                        <i class="fas fa-check"></i> Read
                                    </a>
                                @endif

                                <a
                                    href="{{ route('inquiry.delete', $inquiry->id) }}"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this inquiry?')"
                                >
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                No inquiries found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>