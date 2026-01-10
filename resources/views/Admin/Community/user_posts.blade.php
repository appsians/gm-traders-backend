@extends('layouts.app')

@section('content')
<style>
    .table-responsive {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto !important;
    }

    table th, table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .bulk-actions {
        display: none;
        padding: 12px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        margin-bottom: 20px;
        align-items: center;
        gap: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .bulk-actions.show {
        display: flex;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bulk-actions-info {
        color: white;
        font-weight: 500;
        flex: 1;
    }

    .bulk-actions button {
        padding: 8px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .bulk-delete-btn {
        background: #dc3545;
        color: white;
    }

    .bulk-delete-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    .select-all-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .row-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-cell {
        width: 50px;
        text-align: center;
    }

    .post-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
    }

    .image-preview-modal img {
        max-width: 100%;
        height: auto;
    }
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Community Posts - {{ $user->first_name }} {{ $user->last_name }}</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('community.posts') }}">Community Posts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Posts</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('community.posts') }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> Back to All Posts
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Community Posts by {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</h6>
                    
                    <!-- Bulk Actions Bar -->
                    <div class="bulk-actions" id="bulkActions">
                        <div class="bulk-actions-info">
                            <span id="selectedCount">0</span> item(s) selected
                        </div>
                        <button type="button" class="bulk-delete-btn" id="bulkDeleteBtn">
                            <i class="fa fa-trash"></i> Delete Selected
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="userPostsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-cell">
                                        <input type="checkbox" id="selectAll" class="select-all-checkbox" title="Select All">
                                    </th>
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Likes</th>
                                    <th>Comments</th>
                                    <th>Before Image</th>
                                    <th>After Image</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body image-preview-modal">
                <img id="previewImage" src="" alt="Preview">
            </div>
        </div>
    </div>
</div>

<!-- Likes Modal -->
<div class="modal fade" id="likesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post Likes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="likesLoading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="likesContainer" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-hover" id="likesTable">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Liked At</th>
                                </tr>
                            </thead>
                            <tbody id="likesTableBody">
                                <!-- Likes will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                    <div id="noLikes" class="text-center py-4" style="display: none;">
                        <p class="text-muted">No likes found for this post.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comments Modal -->
<div class="modal fade" id="commentsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="commentsLoading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="commentsContainer" style="display: none;">
                    <div class="bulk-actions mb-3" id="commentsBulkActions" style="display: none;">
                        <div class="bulk-actions-info">
                            <span id="selectedCommentsCount">0</span> comment(s) selected
                        </div>
                        <button type="button" class="bulk-delete-btn" id="bulkDeleteCommentsBtn">
                            <i class="fa fa-trash"></i> Delete Selected
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="commentsTable">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="selectAllComments" class="select-all-checkbox">
                                    </th>
                                    <th>User</th>
                                    <th>Comment</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="commentsTableBody">
                                <!-- Comments will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                    <div id="noComments" class="text-center py-4" style="display: none;">
                        <p class="text-muted">No comments found for this post.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var userId = {{ $userId }};
    var table = $('#userPostsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('community.user.posts.data', $userId) }}",
            type: "GET",
        },
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'checkbox-cell',
                render: function(data, type, row) {
                    return '<input type="checkbox" class="row-checkbox" value="' + row.id + '">';
                }
            },
            { data: 'id', name: 'id' },
            { 
                data: 'description', 
                name: 'description',
                render: function(data, type, row) {
                    return '<span title="' + (row.description || '') + '">' + (data || '-') + '</span>';
                }
            },
            { 
                data: 'likes_count', 
                name: 'likes_count',
                render: function(data, type, row) {
                    var count = data || 0;
                    var btnClass = count > 0 ? 'btn-info' : 'btn-secondary';
                    return '<button class="btn btn-sm ' + btnClass + ' view-likes-btn" data-post-id="' + row.id + '" data-count="' + count + '" title="View Likes">' +
                           '<i class="fa fa-heart"></i> ' + count +
                           '</button>';
                }
            },
            { 
                data: 'comments_count', 
                name: 'comments_count',
                render: function(data, type, row) {
                    var count = data || 0;
                    var btnClass = count > 0 ? 'btn-info' : 'btn-secondary';
                    return '<button class="btn btn-sm ' + btnClass + ' view-comments-btn" data-post-id="' + row.id + '" data-count="' + count + '" title="View Comments">' +
                           '<i class="fa fa-comments"></i> ' + count +
                           '</button>';
                }
            },
            { 
                data: 'before_image', 
                name: 'before_image',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="' + data + '" class="post-image" onclick="previewImage(\'' + data + '\')" alt="Before">';
                    }
                    return '-';
                }
            },
            { 
                data: 'after_image', 
                name: 'after_image',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="' + data + '" class="post-image" onclick="previewImage(\'' + data + '\')" alt="After">';
                    }
                    return '-';
                }
            },
            { data: 'created_at', name: 'created_at' },
            { 
                data: 'id', 
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<div class="action-buttons">' +
                           '<button class="btn btn-sm btn-danger delete-btn" data-id="' + row.id + '" title="Delete">' +
                           '<i class="fa fa-trash"></i>' +
                           '</button>' +
                           '</div>';
                }
            }
        ],
        order: [[1, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            emptyTable: "No community posts found for this user",
            zeroRecords: "No matching community posts found"
        }
    });

    // Bulk selection functionality
    var selectedIds = new Set();

    // Select All checkbox
    $(document).on('change', '#selectAll', function() {
        var isChecked = $(this).is(':checked');
        $('.row-checkbox').prop('checked', isChecked);
        selectedIds.clear();
        
        if (isChecked) {
            table.rows({ search: 'applied' }).nodes().each(function(row) {
                var id = $(row).find('.row-checkbox').val();
                if (id) selectedIds.add(id);
            });
        }
        
        updateBulkActions();
    });

    // Individual row checkbox
    $(document).on('change', '.row-checkbox', function() {
        var id = $(this).val();
        var isChecked = $(this).is(':checked');
        
        if (isChecked) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
            $('#selectAll').prop('checked', false);
        }
        
        updateBulkActions();
    });

    // Update bulk actions bar
    function updateBulkActions() {
        var count = selectedIds.size;
        $('#selectedCount').text(count);
        
        if (count > 0) {
            $('#bulkActions').addClass('show');
        } else {
            $('#bulkActions').removeClass('show');
        }
        
        // Update select all checkbox state
        var totalRows = table.rows({ search: 'applied' }).count();
        $('#selectAll').prop('indeterminate', count > 0 && count < totalRows);
    }

    // Bulk delete
    $(document).on('click', '#bulkDeleteBtn', function() {
        if (selectedIds.size === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one item to delete.'
            });
            return;
        }

        Swal.fire({
            title: 'Delete Selected Posts?',
            text: 'Are you sure you want to delete ' + selectedIds.size + ' selected post(s)? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                var idsArray = Array.from(selectedIds);
                
                $.ajax({
                    url: '{{ route("community.bulk.delete") }}',
                    type: 'POST',
                    data: {
                        ids: idsArray,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Selected posts deleted successfully'
                            });
                            selectedIds.clear();
                            $('#selectAll').prop('checked', false);
                            updateBulkActions();
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: response.message || 'Something went wrong'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error occurred'
                        });
                    }
                });
            }
        });
    });

    // Update checkboxes when table is redrawn (pagination, search, etc.)
    table.on('draw', function() {
        $('.row-checkbox').each(function() {
            var id = $(this).val();
            if (selectedIds.has(id)) {
                $(this).prop('checked', true);
            }
        });
        updateBulkActions();
    });

    // Delete button click handler
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Delete Post?',
            text: 'Are you sure you want to delete this post? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/community/delete/' + id,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(data) {
                        if (data.status === true || data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: data.message || 'Post deleted successfully!'
                            });
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: data.message || 'Something went wrong.'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error occurred.'
                        });
                    }
                });
            }
        });
    });

    // Image preview function
    window.previewImage = function(imageSrc) {
        $('#previewImage').attr('src', imageSrc);
        var modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        modal.show();
    };

    // Likes management
    var currentLikesPostId = null;

    // View likes button click
    $(document).on('click', '.view-likes-btn', function() {
        var postId = $(this).data('post-id');
        currentLikesPostId = postId;
        
        var modal = new bootstrap.Modal(document.getElementById('likesModal'));
        modal.show();
        
        loadLikes(postId);
    });

    function loadLikes(postId) {
        $('#likesLoading').show();
        $('#likesContainer').hide();
        $('#noLikes').hide();
        
        $.ajax({
            url: '/community/post/' + postId + '/likes',
            type: 'GET',
            success: function(response) {
                $('#likesLoading').hide();
                
                if (response.status && response.data && response.data.length > 0) {
                    $('#likesContainer').show();
                    renderLikes(response.data);
                } else {
                    $('#noLikes').show();
                }
            },
            error: function(xhr) {
                $('#likesLoading').hide();
                $('#noLikes').show();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Failed to load likes'
                });
            }
        });
    }

    function renderLikes(likes) {
        var html = '';
        likes.forEach(function(like) {
            html += '<tr data-like-id="' + like.id + '">' +
                   '<td>' +
                   '<div class="d-flex align-items-center">' +
                   (like.profile_image ? '<img src="' + like.profile_image + '" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">' : '<div class="rounded-circle bg-secondary me-2" style="width: 32px; height: 32px;"></div>') +
                   '<div><strong>' + like.user_name + '</strong></div>' +
                   '</div>' +
                   '</td>' +
                   '<td>' + like.user_email + '</td>' +
                   '<td>' + like.created_at + '</td>' +
                   '</tr>';
        });
        $('#likesTableBody').html(html);
    }

    // Comments management
    var selectedCommentIds = new Set();
    var currentPostId = null;

    // View comments button click
    $(document).on('click', '.view-comments-btn', function() {
        var postId = $(this).data('post-id');
        currentPostId = postId;
        selectedCommentIds.clear();
        $('#selectAllComments').prop('checked', false);
        $('#commentsBulkActions').hide();
        
        var modal = new bootstrap.Modal(document.getElementById('commentsModal'));
        modal.show();
        
        loadComments(postId);
    });

    function loadComments(postId) {
        $('#commentsLoading').show();
        $('#commentsContainer').hide();
        $('#noComments').hide();
        
        $.ajax({
            url: '/community/post/' + postId + '/comments',
            type: 'GET',
            success: function(response) {
                $('#commentsLoading').hide();
                
                if (response.status && response.data && response.data.length > 0) {
                    $('#commentsContainer').show();
                    renderComments(response.data);
                } else {
                    $('#noComments').show();
                }
            },
            error: function(xhr) {
                $('#commentsLoading').hide();
                $('#noComments').show();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Failed to load comments'
                });
            }
        });
    }

    function renderComments(comments) {
        var html = '';
        comments.forEach(function(comment) {
            html += '<tr data-comment-id="' + comment.id + '">' +
                   '<td><input type="checkbox" class="comment-checkbox" value="' + comment.id + '"></td>' +
                   '<td>' +
                   '<div class="d-flex align-items-center">' +
                   (comment.profile_image ? '<img src="' + comment.profile_image + '" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">' : '<div class="rounded-circle bg-secondary me-2" style="width: 32px; height: 32px;"></div>') +
                   '<div><strong>' + comment.user_name + '</strong><br><small class="text-muted">' + comment.user_email + '</small></div>' +
                   '</div>' +
                   '</td>' +
                   '<td>' + (comment.comment || '-') + '</td>' +
                   '<td>' + comment.created_at + '</td>' +
                   '<td><button class="btn btn-sm btn-danger delete-comment-btn" data-comment-id="' + comment.id + '" title="Delete Comment"><i class="fa fa-trash"></i></button></td>' +
                   '</tr>';
        });
        $('#commentsTableBody').html(html);
    }

    // Select all comments checkbox
    $(document).on('change', '#selectAllComments', function() {
        var isChecked = $(this).is(':checked');
        $('.comment-checkbox').prop('checked', isChecked);
        selectedCommentIds.clear();
        
        if (isChecked) {
            $('.comment-checkbox').each(function() {
                selectedCommentIds.add($(this).val());
            });
        }
        
        updateCommentsBulkActions();
    });

    // Individual comment checkbox
    $(document).on('change', '.comment-checkbox', function() {
        var id = $(this).val();
        var isChecked = $(this).is(':checked');
        
        if (isChecked) {
            selectedCommentIds.add(id);
        } else {
            selectedCommentIds.delete(id);
            $('#selectAllComments').prop('checked', false);
        }
        
        updateCommentsBulkActions();
    });

    function updateCommentsBulkActions() {
        var count = selectedCommentIds.size;
        $('#selectedCommentsCount').text(count);
        
        if (count > 0) {
            $('#commentsBulkActions').show();
        } else {
            $('#commentsBulkActions').hide();
        }
    }

    // Bulk delete comments
    $(document).on('click', '#bulkDeleteCommentsBtn', function() {
        if (selectedCommentIds.size === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one comment to delete.'
            });
            return;
        }

        Swal.fire({
            title: 'Delete Selected Comments?',
            text: 'Are you sure you want to delete ' + selectedCommentIds.size + ' selected comment(s)? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                var idsArray = Array.from(selectedCommentIds);
                
                $.ajax({
                    url: '{{ route("community.comments.bulk.delete") }}',
                    type: 'POST',
                    data: {
                        ids: idsArray,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Selected comments deleted successfully'
                            });
                            selectedCommentIds.clear();
                            $('#selectAllComments').prop('checked', false);
                            updateCommentsBulkActions();
                            if (currentPostId) {
                                loadComments(currentPostId);
                                table.ajax.reload(null, false);
                            }
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: response.message || 'Something went wrong'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error occurred'
                        });
                    }
                });
            }
        });
    });

    // Delete single comment
    $(document).on('click', '.delete-comment-btn', function(e) {
        e.preventDefault();
        var commentId = $(this).data('comment-id');
        
        Swal.fire({
            title: 'Delete Comment?',
            text: 'Are you sure you want to delete this comment? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/community/comment/' + commentId,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(data) {
                        if (data.status === true || data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: data.message || 'Comment deleted successfully!'
                            });
                            if (currentPostId) {
                                loadComments(currentPostId);
                                table.ajax.reload(null, false);
                            }
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: data.message || 'Something went wrong.'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error occurred.'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection

