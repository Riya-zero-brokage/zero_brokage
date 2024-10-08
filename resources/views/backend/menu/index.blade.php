@extends('backend.layouts.main')

@section('styles')
    <style>
        .preview-img {
            width: 150px;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">
            <div class="content-page-header content-page-headersplit mb-0">
                <h5>Menus</h5>
                @can('menus-create')
                <div class="list-btn d-flex gap-3">
                    <div class="page-headers">
                        <div class="search-bar">
                            <span><i class="fe fe-search"></i></span>
                            <input type="text" id="search" placeholder="Search" class="form-control">
                        </div>
                    </div>
                    <ul>
                        <li>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#add-category">
                                <i class="fa fa-plus me-2"></i>Add Menu
                            </button>
                        </li>
                    </ul>
                </div>
                @endcan
            </div>
            <div class="row text-center">
                <div class="col-12">
                    <div class="table-responsive table-div">

                        <div id="usersTable">
                            @include('backend.menu.partials.menu-index') {{-- Load the users list initially --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Menu Modal -->
    <div class="modal fade" id="add-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Menu</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form id="addMenuForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Menu Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Menu Name">
                            <div id="name_error" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category_id">
                                <option value="" disabled selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="category_id-error" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="subcategory" class="form-label">Subcategory</label>
                            <select class="form-control" id="subcategory" name="subcategory">
                                <option value="" selected>Select Subcategory</option>
                            </select>
                            <div id="subcategory-error" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Menu Image</label>
                            <div class="form-uploads">
                                <div class="form-uploads-path">
                                    <img id="image-preview-icon" src="{{ asset('admin/assets/img/icons/upload.svg') }}"
                                        alt="img" class="default-img">
                                    <div class="file-browse">
                                        <h6>Drag & drop image or </h6>
                                        <div class="file-browse-path">
                                            <input type="file" name="image" id="image-input-icon"
                                                accept="image/*">
                                            <a href="javascript:void(0);"> Browse</a>
                                        </div>
                                    </div>
                                    <h5>Supported formats: JPEG, PNG</h5>
                                </div>
                            </div>
                            <div id="image-error" class="text-danger"></div>
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


    <!-- Edit Menu Modal -->
    <div class="modal fade" id="edit-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editCategoryId" name="category_id">
                        <input type="hidden" id="editSubcategoryId" name="subcategory_id">

                        <div class="mb-3">
                            <label class="form-label">Menu Name</label>
                            <input type="text" class="form-control" id="editName" name="name">
                            <div class="text-danger name-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Category</label>
                            <select class="form-control" id="editCategorySelect" name="category_id">
                                <option value="" disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger category_id-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editSubcategory" class="form-label">Subcategory</label>
                            <select class="form-control" id="editSubcategorySelect" name="subcategory">
                                <option value="" selected>Select Subcategory</option>
                            </select>
                            <div class="text-danger subcategory-error"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Menu Image</label>
                            <div class="form-uploads">
                                <div class="form-uploads-path">
                                    <img id="background-preview" src="{{ asset('admin/assets/img/icons/upload.svg') }}"
                                        alt="img" width="100px" height="100px">
                                    <div class="file-browse">
                                        <h6>Drag & drop image or </h6>
                                        <div class="file-browse-path">
                                            <input type="file" id="edit-image-input-bg" name="image"
                                                accept="image/*">
                                            <a href="javascript:void(0);"> Browse</a>
                                        </div>
                                    </div>
                                    <h5>Supported formats: JPEG, PNG</h5>
                                </div>
                            </div>
                            <div class="text-danger image-error"></div>
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

@section('scripts')
    <script>
        var statusRoute = `{{ route('menu.status') }}`;
        var searchRoute = `{{ route('menus.index') }}`;
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/assets/js/search.js') }}"></script>
    <script src="{{ asset('admin/assets/js/status-update.js') }}"></script>
    <script src="{{ asset('admin/assets/js/preview-img.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/sweetalert2.all.min.js') }}"></script> --}}
    <script>
        // Function to preview the image
        function previewImage(input, previewId) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result)
                        .css({
                            'width': '150px',
                            'height': '150px'
                        }); // Set the preview image size to 50px
                };
                reader.readAsDataURL(file);
            }
        }

        // Event listener for background image preview
        $('#edit-image-input-bg').on('change', function() {
            previewImage(this, 'background-preview');
        });
    </script>
    <script>
        $(document).ready(function() {

            // Fetch subcategories when a category is selected in the add form
            $('#category').off('change').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '/fetch-subcategory/' + categoryId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#subcategory').empty().append(
                                '<option value="" selected disabled>Select Subcategory</option>'
                            );

                            if (response.status === 1 && response.data.length > 0) {
                                $.each(response.data, function(key, subcateg) {
                                    $('#subcategory').append('<option value="' +
                                        subcateg.id + '">' + subcateg.name +
                                        '</option>');
                                });
                            }
                        },
                        error: function() {
                            $('#subcategory').empty().append(
                                '<option value="" disabled>Error loading subcategories</option>'
                            );
                        }
                    });
                } else {
                    $('#subcategory').empty().append(
                        '<option value="" selected disabled>Select Subcategory</option>');
                }
            });

            // Handle Add Menu Form Submission
            $('#addMenuForm').off('submit').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'), // Use the action attribute of the form
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            location.reload(); // Refresh the page to show new data
                        }
                    },
                    error: function(xhr) {
                        // Clear previous error messages
                        $('#name_error').text('');
                        $('#category_id-error').text('');
                        $('#subcategory-error').text('');
                        $('#image-error').text('');

                        // Display new error messages
                        if (xhr.responseJSON.errors) {
                            $('#name_error').text(xhr.responseJSON.errors.name ? xhr
                                .responseJSON.errors.name[0] : '');
                            $('#category_id-error').text(xhr.responseJSON.errors.category_id ?
                                xhr.responseJSON.errors.category_id[0] : '');
                            $('#subcategory-error').text(xhr.responseJSON.errors.subcategory ?
                                xhr.responseJSON.errors.subcategory[0] : '');
                            $('#image-error').text(xhr.responseJSON.errors.image ? xhr
                                .responseJSON.errors.image[0] : '');
                        }
                    }
                });
            });

            // Function to handle the edit category modal
            window.editCategory = function(id) {
                $.ajax({
                    url: `/menus/${id}/edit`,
                    method: 'GET',
                    success: function(response) {
                        $('#editCategoryId').val(response.menu.id);
                        $('#editName').val(response.menu.name);
                        $('#editCategorySelect').val(response.menu.category_id).trigger('change');

                        // Fetch and populate subcategories based on the selected category
                        $.ajax({
                            url: `/fetch-subcategory/${response.menu.category_id}`,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(subResponse) {
                                $('#editSubcategorySelect').empty().append(
                                    '<option value="" selected>Select Subcategory</option>'
                                );
                                subResponse.data.forEach(sub => {
                                    $('#editSubcategorySelect').append(
                                        `<option value="${sub.id}" ${sub.id == response.menu.subcategory_id ? 'selected' : ''}>${sub.name}</option>`
                                    );
                                });
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });

                        if (response.menu.image) {
                            $('#background-preview').attr('src',
                                `/storage/menu/${response.menu.image}`);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching the menu data:', xhr);
                    }
                });
            };

            // Function to handle form submission for editing a menu
            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#editCategoryId').val();
                let formData = new FormData(this);

                $.ajax({
                    method: 'POST',
                    url: `/menus/${id}`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            if (response.success) {
                                location.reload(); // Refresh page to show updated data
                            }
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $('#editCategoryForm .name-error').text(errors.name ? errors.name[0] :
                            '');
                        $('#editCategoryForm .category_id-error').text(errors.category_id ?
                            errors.category_id[0] : '');
                        $('#editCategoryForm .subcategory-error').text(errors.subcategory ?
                            errors.subcategory[0] : '');
                        $('#editCategoryForm .image-error').text(errors.image ? errors.image[
                            0] : '');
                    }
                });
            });

            // Function to display validation errors (optional helper function)
            function displayErrors(errors) {
                for (let field in errors) {
                    $(`.${field}-error`).text(errors[field][0]);
                }
            }

            // Handle Category Change in Edit Form
            $('#editCategorySelect').on('change', function() {
                const categoryId = $(this).val();
                $.ajax({
                    url: `/fetch-subcategory/${categoryId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#editSubcategorySelect').empty().append(
                            '<option value="" selected>Select Subcategory</option>'
                        );
                        response.data.forEach(sub => {
                            $('#editSubcategorySelect').append(
                                `<option value="${sub.id}">${sub.name}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
