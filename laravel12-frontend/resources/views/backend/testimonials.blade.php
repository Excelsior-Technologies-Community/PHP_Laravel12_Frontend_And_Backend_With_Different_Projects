@extends('backend.layout')

@section('title', 'Testimonials')

@section('page_title', 'Testimonial Management')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="glass-card p-4 mb-4">
                <h4 class="fw-bold mb-4">Add New Testimonial</h4>

                <form id="testimonialForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control" name="position">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" class="form-control" name="company">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message *</label>
                        <textarea class="form-control" name="message" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating *</label>
                        <select class="form-select" name="rating" required>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Avatar</label>
                        <input type="file" class="form-control" name="avatar" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <span class="spinner-border spinner-border-sm d-none" id="testBtnSpinner"></span>
                        <span id="testBtnText">Add Testimonial</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h4 class="fw-bold mb-4">All Testimonials</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Company</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                                <tr>
                                    <td class="fw-semibold">{{ $testimonial->name }}</td>
                                    <td>{{ $testimonial->position }}</td>
                                    <td>{{ $testimonial->company }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" style="color: {{ $i <= $testimonial->rating ? '#fbbf24' : '#d1d5db' }};"></i>
                                        @endfor
                                    </td>
                                    <td>{{ $testimonial->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary edit-testimonial" data-id="{{ $testimonial->id }}" data-name="{{ $testimonial->name }}" data-position="{{ $testimonial->position }}" data-company="{{ $testimonial->company }}" data-message="{{ $testimonial->message }}" data-rating="{{ $testimonial->rating }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.testimonials.delete', $testimonial->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this testimonial?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No testimonials found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#testimonialForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: '{{ route("admin.testimonials.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        toastr.error(Object.values(xhr.responseJSON.errors)[0][0]);
                    } else {
                        toastr.error('Something went wrong');
                    }
                }
            });
        });
    });
</script>
@endsection
