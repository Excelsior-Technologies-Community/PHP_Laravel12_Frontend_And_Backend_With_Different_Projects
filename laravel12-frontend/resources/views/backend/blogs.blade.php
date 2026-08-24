@extends('backend.layout')

@section('title', 'Blogs')

@section('page_title', 'Blog Management')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="glass-card p-4 mb-4">
                <h4 class="fw-bold mb-4">Add New Blog</h4>

                <form id="blogForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea class="form-control" name="excerpt" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content *</label>
                        <textarea class="form-control" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <input type="text" class="form-control" name="author">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Featured Image</label>
                        <input type="file" class="form-control" name="featured_image" accept="image/*">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="is_published" id="isPublished" checked>
                        <label class="form-check-label" for="isPublished">Publish</label>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <span class="spinner-border spinner-border-sm d-none" id="blogBtnSpinner"></span>
                        <span id="blogBtnText">Add Blog</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h4 class="fw-bold mb-4">All Blogs</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                                <tr>
                                    <td class="fw-semibold">{{ $blog->title }}</td>
                                    <td>{{ $blog->author ?? 'N/A' }}</td>
                                    <td>
                                        @if($blog->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary edit-blog" data-id="{{ $blog->id }}" data-title="{{ $blog->title }}" data-excerpt="{{ $blog->excerpt }}" data-content="{{ $blog->content }}" data-author="{{ $blog->author }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.blogs.delete', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No blogs found</td>
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
        $('#blogForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: '{{ route("admin.blogs.store") }}',
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
