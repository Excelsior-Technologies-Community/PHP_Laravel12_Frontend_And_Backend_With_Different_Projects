@extends('backend.layout')

@section('title', 'FAQs')

@section('page_title', 'FAQ Management')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="glass-card p-4 mb-4">
                <h4 class="fw-bold mb-4">Add New FAQ</h4>

                <form id="faqForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Question *</label>
                        <input type="text" class="form-control" name="question" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answer *</label>
                        <textarea class="form-control" name="answer" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" value="0">
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <span class="spinner-border spinner-border-sm d-none" id="faqBtnSpinner"></span>
                        <span id="faqBtnText">Add FAQ</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h4 class="fw-bold mb-4">All FAQs</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Category</th>
                                <th>Sort Order</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                                <tr>
                                    <td class="fw-semibold">{{ $faq->question }}</td>
                                    <td>{{ $faq->category->name ?? 'N/A' }}</td>
                                    <td>{{ $faq->sort_order }}</td>
                                    <td>{{ $faq->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary edit-faq" data-id="{{ $faq->id }}" data-question="{{ $faq->question }}" data-answer="{{ $faq->answer }}" data-category="{{ $faq->category_id }}" data-sort="{{ $faq->sort_order }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this FAQ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No FAQs found</td>
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
        $('#faqForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.faqs.store") }}',
                type: 'POST',
                data: $(this).serialize(),
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
