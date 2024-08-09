@extends('backend.layouts.main')
@section('content')

<div class="page-wrapper page-settings">
    <div class="content">
        <div class="content-page-header content-page-headersplit mb-0">
            <h5>Enquiry Listing</h5>
            <div class="list-btn">
                <ul>
                    <li>
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEnquiryModal">
                            Add Enquiry
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive table-div">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($enquiries->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">No data found</td>
                                </tr>
                            @else
                                @foreach ($enquiries as $enquiry)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $enquiry->name }}</td>
                                        <td>{{ $enquiry->move_from_origin }}</td>
                                        <td>
                                            @php
                                                $date = \Carbon\Carbon::parse($enquiry->date_time);
                                            @endphp
                                            @if ($date->isToday())
                                                <span class="badge bg-success">Today</span>
                                            @elseif ($date->isYesterday())
                                                <span class="badge bg-warning text-dark">Yesterday</span>
                                            @elseif ($date->isTomorrow())
                                                <span class="badge bg-primary">Tomorrow</span>
                                            @else
                                                {{ $date->format('d-m-Y') }}
                                            @endif
                                        </td>
                                        <td>{{ $enquiry->email }}</td>
                                        <td>{{ $enquiry->mobile_number }}</td>
                                        <td>
                                            <button class="btn btn-danger delete-enquiry" data-id="{{ $enquiry->id }}">Delete</button>
                                        </td>
                                         
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Enquiry Modal -->
<div class="modal fade" id="addEnquiryModal" tabindex="-1" aria-labelledby="addEnquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEnquiryModalLabel">Add Enquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="enquiryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subcategory" class="form-label">Subcategory</label>
                        <select class="form-control" id="subcategory" name="subcategory_id">
                            <option value="" disabled selected>Select Subcategory</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="move_from_origin" class="form-label">Location</label>
                        <input type="text" id="move_from_origin" name="move_from_origin" class="form-control" placeholder="Enter your location">
                    </div>
                    <div class="mb-3">
                        <label for="date_time" class="form-label">Date and Time</label>
                        <input type="datetime-local" id="date_time" name="date_time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address">
                    </div>
                    <div class="mb-3">
                        <label for="mobile_number" class="form-label">Mobile Number</label>
                        <input type="text" id="mobile_number" name="mobile_number" class="form-control" placeholder="Enter your mobile number">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

    // Fetch subcategories based on category selection
    $('#category').on('change', function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                url: '/fetch-subcategory/' + categoryId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 1) {
                        var subcategory = response.data;
                        $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
                        $.each(subcategory, function(key, subcateg) {
                            $('#subcategory').append('<option value="' + subcateg.id + '">' + subcateg.name + '</option>');
                        });
                    }
                }
            });
        } else {
            $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
        }
    });

    // Handle form submission
    $('#enquiryForm').off('submit').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('enquiry.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 1) {
                    alert(response.message);
                    $('#addEnquiryModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error occurred while submitting the enquiry.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    // Handle enquiry deletion
    $(document).off('click', '.delete-enquiry').on('click', '.delete-enquiry', function() {
        var enquiryId = $(this).data('id');

        if (confirm('Are you sure you want to delete this enquiry?')) {
            $.ajax({
                url: '/enquiry/' + enquiryId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 1) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Error occurred while deleting the enquiry.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        }
    });

    // Clear the form and reset the modal when it is closed
    $('#addEnquiryModal').on('hidden.bs.modal', function () {
        $('#enquiryForm')[0].reset();
        $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
    });

});



</script>
@endsection