<footer class="py-5 mt-5" style="background: linear-gradient(135deg, #0f0f1a, #1a1a2e); color: #e4e6eb;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-envelope-open-text me-2" style="color: #7c3aed;"></i>InquiryPro
                </h5>
                <p class="text-muted">
                    Your trusted platform for customer inquiries and support. We connect customers with businesses seamlessly.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-muted hover-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-muted hover-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-muted hover-white"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-muted hover-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-muted text-decoration-none hover-white">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-muted text-decoration-none hover-white">About Us</a></li>
                    <li><a href="{{ route('services') }}" class="text-muted text-decoration-none hover-white">Services</a></li>
                    <li><a href="{{ route('faq') }}" class="text-muted text-decoration-none hover-white">FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="text-muted text-decoration-none hover-white">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Services</h6>
                <ul class="list-unstyled">
                    @foreach($categories->take(5) as $category)
                        <li><a href="{{ route('services') }}" class="text-muted text-decoration-none hover-white">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Contact Info</h6>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: #7c3aed;"></i>Surat, Gujarat, India</li>
                    <li class="mb-2"><i class="fas fa-phone me-2" style="color: #7c3aed;"></i>+91 98765 43210</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2" style="color: #7c3aed;"></i>info@inquirypro.com</li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <div class="text-center text-muted">
            <p class="mb-0">&copy; {{ date('Y') }} InquiryPro. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
    .hover-white:hover {
        color: #e4e6eb !important;
    }
    .dark-mode footer {
        background: linear-gradient(135deg, #050508, #0a0a14) !important;
    }
</style>
