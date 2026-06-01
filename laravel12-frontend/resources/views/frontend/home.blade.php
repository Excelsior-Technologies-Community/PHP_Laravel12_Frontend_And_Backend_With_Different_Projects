<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Inquiry Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4f46e5, #7c3aed, #9333ea);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .main-card {
            width: 100%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .15);
        }

        .left-panel {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, .15),
                rgba(255, 255, 255, .05)
            );
            color: white;
            padding: 50px;
        }

        .right-panel {
            background: white;
            padding: 40px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
        }

        .btn-submit {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            font-weight: 600;
        }

        .btn-submit:hover {
            background: #4338ca;
            color: white;
        }

        .dashboard-btn {
            text-decoration: none;
        }

        .icon-box {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, .2);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="main-card">

    <div class="row g-0">

        <div class="col-lg-5">
            <div class="left-panel h-100">

                <div class="icon-box">
                    <i class="fas fa-envelope-open-text fa-2x"></i>
                </div>

                <h2 class="fw-bold">
                    Customer Inquiry Portal
                </h2>

                <p class="mt-3">
                    Submit your inquiry quickly and our team will get back to you as soon as possible.
                </p>

                <hr>

                <p>
                    <i class="fas fa-check-circle"></i>
                    Fast Response
                </p>

                <p>
                    <i class="fas fa-check-circle"></i>
                    Secure Data Storage
                </p>

                <p>
                    <i class="fas fa-check-circle"></i>
                    Real-Time Dashboard Tracking
                </p>

                <a href="{{ route('dashboard') }}" class="btn btn-light mt-4 dashboard-btn">
                    <i class="fas fa-chart-line"></i>
                    Open Admin Dashboard
                </a>

            </div>
        </div>

        <div class="col-lg-7">

            <div class="right-panel">

                <h3 class="mb-4">
                    Send Your Inquiry
                </h3>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('inquiry.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter your name"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>

                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>

                        <input
                            type="text"
                            class="form-control"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Enter phone number"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>

                        <textarea
                            class="form-control"
                            rows="5"
                            name="message"
                            placeholder="Write your inquiry here..."
                        >{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Submit Inquiry
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>

