@extends('backend.layouts.main')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">
            <div class="content-page-header content-page-headersplit mb-0">
                <h5>Reviews</h5>
                <div class="list-btn d-flex gap-3">

                    <div class="page-headers">
                        <div class="search-bar">
                            <span><i class="fe fe-search"></i></span>
                            <input type="text" id="search" placeholder="Search" class="form-control">
                        </div>
                    </div>
                    @can('reviews-create')
                        <ul>
                            <li>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#add-review">
                                    <i class="fa fa-plus me-2"></i>Add Review
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
                            @include('backend.review.partials.review-index') {{-- Load the users list initially --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-review">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form id="addreviewForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name"
                                placeholder="Enter name">{{ old('name') }}</input>
                            <div id="name_error" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea type="text" class="form-control" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
                            <div id="description_error" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profession</label>
                            <input type="text" class="form-control" name="profession"
                                placeholder="Enter profession">{{ old('profession') }}</input>
                            <div id="profession_error" class="text-danger"></div>
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
    <div class="modal fade" id="edit-review">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form id="editreviewForm" method="POST" action="{{ route('reviews.update', 'review_id') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editReviewId" name="review_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="editname" name="name"
                                placeholder="Enter name"></input>
                            <div id="editName_error" class="text-danger"></div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="editdescription" name="description" placeholder="Enter description"></textarea>
                            <div id="editDescription_error" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profession</label>
                            <input type="text" class="form-control" id="editprofession" name="profession"
                                placeholder="Enter profession"></input>
                            <div id="editProfession_error" class="text-danger"></div>
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
@endsection

@section('scripts')
    <script>
        var statusRoute = `{{ route('reviews.status') }}`;
        var searchRoute = `{{ route('reviews.index') }}`;
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/assets/js/search.js') }}"></script>
    <script src="{{ asset('admin/assets/js/status-update.js') }}"></script>
    <script>
        function editCategory(id) {
            $.ajax({
                url: `/reviews/${id}/edit`,
                method: 'GET',
                success: function(data) {
                    $('#editReviewId').val(data.id);
                    $('#editname').val(data.name);
                    $('#editdescription').val(data.description);
                    $('#editprofession').val(data.profession);

                    // Update form action URL
                    $('#editreviewForm').attr('action', `/reviews/${data.id}`);

                    // Show the modal
                    $('#edit-review').modal('show');
                },
                error: function() {
                    alert('Error fetching review data.');
                }
            });
        }

        // for validation in addition

        $(document).ready(function() {
            $('#addreviewForm').off('submit').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    method: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        $('#add-review').modal('hide'); // Hide the modal
                        if (response) {
                            location.reload(); // Refresh page to show updated data
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $('#name_error').text('');
                            $('#description_error').text('');
                            $('#profession_error').text('');
                            if (errors.name) {
                                $('#name_error').text(errors.name[0]);
                            }
                            if (errors.description) {
                                $('#description_error').text(errors.description[0]);
                            }
                            if (errors.profession) {
                                $('#profession_error').text(errors.profession[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
