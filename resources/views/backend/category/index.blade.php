@extends('backend.layouts.main')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">
            <div class="content-page-header content-page-headersplit mb-0">
                <h5>Categories</h5>
                <div class="list-btn d-flex gap-3">
                    <div class="page-headers">
                        <div class="search-bar">
                            <span><i class="fe fe-search"></i></span>
                            <input type="text" id="search" placeholder="Search" class="form-control">
                        </div>
                    </div>
                    @can('categories-create')
                        <ul>
                            <li>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#add_category"><i class="fa fa-plus me-2"></i>Add Category</button>
                            </li>
                        </ul>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-12 ">
                    <div class="table-responsive table-div">
                        {{-- Users Table --}}
                        <div id="usersTable">
                            @include('backend.category.partials.category-index') {{-- Load the users list initially --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="add_category" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="addCategoryForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="addName" name="name"
                                placeholder="Enter Category Name">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="edit-category" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="editCategoryForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editCategoryId" name="category_id">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editName" name="name">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Ensure jQuery is loaded before these scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var searchRoute = `{{ route('categories.index') }}`;
</script>
<script src="{{ asset('admin/assets/js/search.js') }}"></script>
<script>
    // Edit Category Handler
    function editCategory(categoryId, categoryName) {
        $('#editCategoryId').val(categoryId);
        $('#editName').val(categoryName);
        $('#editCategoryForm').attr('action', `/categories/${categoryId}`);
    }



    function editCategory(categoryId, categoryName) {
        // Clear previous error messages
        $('.error-text').text('');

        // Populate the form fields with the selected category's data
        $('#editCategoryId').val(categoryId);
        $('#editName').val(categoryName);

        // Set the form action to the correct URL
        $('#editCategoryForm').attr('action', `/categories/${categoryId}`);
    }

    $(document).ready(function() {
        // Add Category
        $('#addCategoryForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('.error-text').text(''); // Clear previous error messages

            $.ajax({
                type: 'POST',
                url: '{{ route('categories.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#add_category').modal('hide');
                        // alert(response.message);
                        location.reload(); // Reload the page to see the new category
                    } else {
                        alert(response.message);
                    }
                },
                error: function(response) {
                    if (response.status === 422) { // Validation error
                        let errors = response.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });

        // Edit Category
        $('#editCategoryForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let categoryId = $('#editCategoryId').val();
            $('.error-text').text(''); // Clear previous error messages

            $.ajax({
                type: 'POST',
                url: `/categories/${categoryId}`,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#edit-category').modal('hide');
                        // alert(response.message);
                        location.reload(); // Reload the page to see the updated category
                    } else {
                        alert(response.message);
                    }
                },
                error: function(response) {
                    if (response.status === 422) { // Validation error
                        let errors = response.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });

    });
</script>
