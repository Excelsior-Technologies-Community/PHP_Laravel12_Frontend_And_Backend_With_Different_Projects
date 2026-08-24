@extends('backend.layout')

@section('title', 'Categories')

@section('page_title', 'Category Management')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="glass-card p-4 mb-4">
                <h4 class="fw-bold mb-4">Add New Category</h4>

                <form id="categoryForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug" placeholder="auto-generated">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Font Awesome class)</label>
                        <input type="text" class="form-control" name="icon" placeholder="fa-tag">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="is_active" id="isActive" checked>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <span class="spinner-border spinner-border-sm d-none" id="catBtnSpinner"></span>
                        <span id="catBtnText">Add Category</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h4 class="fw-bold mb-4">All Categories</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Icon</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="fw-semibold">{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td><i class="fas {{ $category->icon ?? 'fa-tag' }}"></i></td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-slug="{{ $category->slug }}" data-icon="{{ $category->icon }}" data-description="{{ $category->description }}" data-active="{{ $category->is_active }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No categories found</td>
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
        $('#categoryForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#categoryBtn');
            const spinner = $('#catBtnSpinner');
            const btnText = $('#catBtnText');

            $.ajax({
                url: '{{ route("admin.categories.store") }}',
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function() {
                    if(spinner.length) { spinner.removeClass('d-none'); btnText.text('Saving...'); }
                },
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
                },
                complete: function() {
                    if(spinner.length) { spinner.addClass('d-none'); btnText.text('Add Category'); }
                }
            });
        });
    });
</script>
@endsection
