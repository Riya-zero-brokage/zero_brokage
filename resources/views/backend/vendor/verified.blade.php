@extends('backend.layouts.main')

@section('styles')
    <style>
        .preview-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>
@endsection

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
                    @can('verified-create')
                    <ul>
                        <li>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#add-category">
                                <i class="fa fa-plus me-2"></i>Add Verified
                            </button>
                        </li>
                    </ul>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-resposnive table-div">
                        <div id="usersTable">
                            @include('backend.vendor.partials.verified-index') {{-- Load the users list initially --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="add-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Verified</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="addSubCategoryForm" action="{{ route('verified.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter  Name">
                            <div id="name_error" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> Image</label>
                            <div class="form-uploads">
                                <div class="form-uploads-path">
                                    <img id="image-preview-icon" src="{{ asset('admin/assets/img/icons/upload.svg') }}"
                                        alt="img" width="100px" height="100px">
                                    <div class="file-browse">
                                        <h6>Drag & drop image or </h6>
                                        <div class="file-browse-path">
                                            <input type="file" id="image-input-icon" name="image"
                                                accept="image/*">
                                            <a href="javascript:void(0);"> Browse</a>
                                        </div>
                                    </div>
                                    <h5>Supported formats: JPEG, PNG</h5>
                                </div>
                            </div>
                            <div id="image_error" class="text-danger"></div>
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
    <div class="modal fade" id="edit-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Verified</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="editVerifiedForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="verifiedId" name="id">

                        <div class="mb-3">
                            <label class="form-label"> Name</label>
                            <input type="text" class="form-control" id="editName" name="name" placeholder="Enter  Name" >
                            <div id="name_error_edit" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> Image</label>
                            <div class="form-uploads">
                                <div class="form-uploads-path">
                                    <img id="edit-image-preview-image"
                                        src="{{ asset('admin/assets/img/icons/upload.svg') }}" alt="img"
                                        width="100px" height="100px">
                                    <div class="file-browse">
                                        <h6>Drag & drop image or </h6>
                                        <div class="file-browse-path">
                                            <input type="file" id="editImage" name="image"
                                                accept="image/*">
                                            <a href="javascript:void(0);"> Browse</a>
                                        </div>
                                    </div>
                                    <h5>Supported formats: JPEG, PNG</h5>
                                </div>
                            </div>
                            <div id="image_error_edit" class="text-danger"></div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var statusRoute = `{{ route('verified.status') }}`;
        var searchRoute = `{{ route('verified.index') }}`;
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/assets/js/search.js') }}"></script>
    <script src="{{ asset('admin/assets/js/status-update.js') }}"></script>
    <script src="{{ asset('admin/assets/js/preview-img.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#addSubCategoryForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            location.reload(); // Refresh page to show new data
                        }
                    },
                    error: function(xhr) {
                        $('#name_error').text(xhr.responseJSON.errors.name ? xhr
                            .responseJSON.errors.name[0] : '');
                        $('#image_error').text(xhr.responseJSON.errors.image ? xhr.responseJSON
                            .errors.image[0] : '');
                    }
                });
            });
        });



        // Edit Subcategory (Verified)
        window.editVerified = function(id) {
            $.ajax({
                url: `/verified/${id}/edit`,
                method: 'GET',
                success: function(response) {
                    console.log(response);

                    $('#verifiedId').val(response.verified.id);
                    $('#editName').val(response.verified.name);
                    if (response.verified.image) {
                        $('#edit-image-preview-image').attr('src',
                            `/storage/verified/${response.verified.image}`);

                    }
                    $('#edit-category').modal('show'); // Show the modal after loading the data
                }
            });
        }

        // Update Subcategory (Verified)
        $('#editVerifiedForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let id = $('#verifiedId').val();

            $.ajax({
                type: 'POST',
                url: `/verified/${id}`,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-HTTP-Method-Override': 'PUT' // Override POST to PUT for update operation
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // Refresh page to show updated data
                    }
                },
                error: function(xhr) {
                    $('#name_error_edit').text(xhr.responseJSON.errors.name ? xhr.responseJSON.errors
                        .name[0] : '');
                    $('#image_error_edit').text(xhr.responseJSON.errors.image ? xhr.responseJSON.errors
                        .image[0] : '');
                }
            });
        });
    </script>
@endsection
