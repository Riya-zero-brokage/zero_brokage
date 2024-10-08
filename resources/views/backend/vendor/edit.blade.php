@extends('backend.layouts.main')
@section('styles')
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }

        .small-image {
            width: 70px;
            /* Adjust as needed */
            height: auto;
            transition: transform 0.3s ease;
            /* Smooth transition effect */
        }

        /* .image-container:hover .small-image {
                        width: 200px; */
        /* Adjust as needed for medium size */
        /* } */
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
    <link rel="stylesheet" href="{{ asset('admin/summernote/summernote.min.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">
            <div class="main-wrapper">

                <div class="main-wrapper">

                    <div class="container border p-2 shadow-sm mt-2">
                        <h4> Edit Vendor</h4>
                    </div>
                    <div class="container mt-4 border p-5 rounded shadow">
                        <form id="addCategoryModal"
                            action="{{ route('vendors.update', $vendor->id ?? '', $vendor->company_name ?? '') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mx-auto">
                                <div class="col-md-4">
                                    <label for="formManager" class="form-label">Manager <b style="color: red;">*</b></label>
                                    <select name="manager_id" id="formManager" class="form-select bg-light-subtle"
                                        aria-label="Default select example" style="box-shadow: none; font-size:1.4rem" required>
                                        <option selected disabled>Select Option</option>
                                        <option value="1" {{ old('manager_id') == '1' ? 'selected' : '' }}>dummy
                                        </option>
                                        <option value="2" {{ old('manager_id') == '2' ? 'selected' : '' }}>person
                                        </option>
                                        <option value="3" {{ old('manager_id') == '3' ? 'selected' : '' }}>thify
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="formFile" class="form-label">Employee<b style="color: red;">*</b></label>
                                    <select name="employee_id" class="form-select bg-light-subtle"
                                        aria-label="Default select example" style="box-shadow: none;font-size:1.4rem" required>
                                        <option value="" selected disabled>Select Option</option>
                                        <option value="1" {{ old('employee_id') == '1' ? 'selected' : '' }}>employee1
                                        </option>
                                        <option value="2" {{ old('employee_id') == '2' ? 'selected' : '' }}>employee2
                                        </option>
                                        <option value="3" {{ old('employee_id') == '3' ? 'selected' : '' }}>employee3
                                        </option>
                                    </select>
                                    @error('employee_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="category">Category</label>
                                    <select class="form-control bg-light-subtle" id="category" name="category" required>
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="category_id-error" class="text-danger"></div>
                                </div>
                            </div>

                            <div class="row mx-auto mt-3">
                                <div class="col-md-4">
                                    <label for="subcategory">Sub Category</label>
                                    <select class="form-control bg-light-subtle" id="subcategory" name="sub_category" required>
                                        <option value="">Select subcategory</option>
                                    </select>
                                    <div id="subcategory_id-error" class="text-danger"></div>
                                </div>

                                <div class="col-md-4">
                                    <label for="menu">Menu</label>
                                    <select class="form-control bg-light-subtle" id="menu" name="menu_id" required>
                                        <option value="">Select menu</option>
                                    </select>
                                    <div id="menu_id-error" class="text-danger"></div>

                                </div>
                                <div class="col-md-4">
                                    <label for="submenu">Sub-Menu</label>
                                    <select class="form-control bg-light-subtle" id="submenu" name="submenu_id" required>
                                        <option value="">Select submenu</option>
                                    </select>
                                    <div id="menu_id-error" class="text-danger"></div>
                                </div>
                            </div>

                            <div class="row mx-auto mt-3">
                                <div class="col-md-6">
                                    <label for="companyname" class="form-label">Company Name<b
                                            style="color: red;">*</b></label><span> (if same name)</span>
                                    <input name="company_name_checkbox" class="form-check-input mx-1" type="checkbox"
                                        id="companyNameCheckbox">
                                    <input name="company_name"
                                        value="{{ old('company_name', $vendor->company_name ?? '') }}" id="companyname"
                                        class="form-control bg-light-subtle" type="text" placeholder="Company name"
                                        aria-label="default input example" required>
                                    @error('company_name')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="lcompanyname" class="form-label">Legal Company Name<b
                                            style="color: red;">*</b></label>
                                    <input name="legal_company_name"
                                        value="{{ old('legal_company_name', $vendor->legal_company_name ?? '') }}"
                                        id="lcompanyname" class="form-control bg-light-subtle" type="text"
                                        placeholder="Legal Company name" aria-label="default input example" required>
                                    @error('legal_company_name')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="state" class="form-label">State<b style="color: red;">*</b></label>
                                    <select id="state" name="state" class="form-select bg-light-subtle" style="font-size: 1.4rem" required>
                                        <option selected disabled>Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ ucwords($state->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="city" class="form-label">City<b style="color: red;">*</b></label>
                                    <select class="form-select bg-light-subtle" id="city" name="city" style="font-size: 1.4rem" required>
                                        <option value="">Select City</option>
                                    </select>
                                    @error('city')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="pinnumber" class="form-label">PIN Code<b
                                            style="color: red;">*</b></label>
                                    <input name="pincode" value="{{ old('pincode', $vendor->pincode ?? '') }}"
                                        id="pinnumber" class="form-control bg-light-subtle" type="text"
                                        placeholder="PIN code number" maxlength="6" onkeyup="validateField(this)"
                                        aria-label="default input example" required>
                                    <div id="pinnumberError" class="errorMessage text-danger"></div>
                                </div>
                                @error('pincode')
                                    <div class="error text-danger ">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="row mt-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label text-dark">Address<b
                                            style="color: red;">*</b></label>
                                    <textarea name="address" class="form-control bg-light-subtle" placeholder="Enter Address"
                                        id="exampleFormControlTextarea1" rows="3" required> {{ $vendor->address ?? '' }}</textarea>
                                </div>
                                @error('address')
                                    <div class="error text-danger ">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <label for="emailAddressVender" class="form-label">Email Address<b
                                            style="color: red;">*</b></label>
                                    <input name="email" value="{{ old('email', $vendor->email ?? '') }}"
                                        class="form-control bg-light-subtle" id="emailAddressVender" type="text"
                                        placeholder="Email address" aria-label="default input example"
                                        onkeyup="validateField(this)" required>
                                    <div id="emailError" class="text-danger"></div>
                                    @error('email')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mt-4 mt-md-0">
                                    <label for="formFile" class="form-label">Whatsapp<b
                                            style="color: red;">*</b></label><span class="mx-3">(Get
                                        notification)</span>
                                    <input name="whatsapp" value="{{ old('whatsapp', $vendor->whatsapp ?? '') }}"
                                        class="form-check-input mx-2" type="checkbox" value=""
                                        id="flexCheckChecked" checked>
                                    <input name="whatsapp" value="{{ old('whatsapp', $vendor->whatsapp ?? '') }}"
                                        class="form-control bg-light-subtle" id="whatsappNumVender" type="text"
                                        placeholder="Whatsapp number" aria-label="default input example"
                                        onkeyup="validateField(this)" maxlength="10" required>
                                    <div id="whatsappError" class="text-danger"></div>
                                    @error('whatsapp')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mt-4 mt-md-0">
                                    <label for="phoneNumVender" class="form-label">Phone Number<b
                                            style="color: red;">*</b></label><span class="mx-3">(Get
                                        notification)</span>
                                    <input name="number" value="{{ old('number', $vendor->number ?? '') }}"
                                        class="form-check-input mx-2" type="checkbox" value=""
                                        id="flexCheckChecked" checked>
                                    <input name="number" value="{{ old('number', $vendor->number ?? '') }}"
                                        class="form-control bg-light-subtle" id="phoneNumVender" type="text"
                                        placeholder="Phone number" aria-label="default input example"
                                        onkeyup="validateField(this)" maxlength="10" required>
                                    <div id="phoneError" class="text-danger"></div>
                                    @error('number')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3 mb-3">
                                    <label for="formFile" class="form-label">Website (if available)</label>
                                    <input name="website" value="{{ old('website', $vendor->website ?? '') }}"
                                        class="form-control bg-light-subtle" type="text" placeholder="www.example.com"
                                        aria-label="default input example">
                                    @error('website')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="formFile" class="form-label">Verified or Approved By Team</label>
                                    <select name="verified" class="form-select bg-light-subtle"
                                        aria-label="Default select example" style="box-shadow: none;font-size:1.4rem">
                                        <option selected disabled value="">Select Option</option>
                                        @foreach ($verifieds as $verified)
                                            <option value="{{ $verified->id }}">{{ $verified->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('verified')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="formFile" class="form-label">Owner name<b
                                            style="color: red;">*</b></label>
                                    <input name="owner_name" value="{{ old('owner_name', $vendor->owner_name ?? '') }}"
                                        class="form-control bg-light-subtle" type="text"
                                        placeholder="Enter owner name" aria-label="default input example" required>
                                    @error('owner_name')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="formFile" class="form-label">DOB<b
                                            style="color: red;">*</b></label>
                                    <input name="dob" value="{{ old('dob', $vendor->dob ?? '') }}"
                                        class="form-control bg-light-subtle" type="date"
                                        placeholder="Enter DOB" aria-label="default input example" required>
                                    @error('dob')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class="row mt-6">
                                <div class="col-md-6 mb-3">
                                    <label for="formFile" class="form-label">Vendor Logo<b
                                            style="color: red;">*</b></label>
                                            <span>
                                                @if ($vendor->gst_image)
                                                    <div class="mb-2 image-container">
                                                        <img id="existingImage"
                                                            src="{{ asset('storage/vendor/gst_image/'. $vendor->logo) }}"
                                                            alt="Current Image" class="small-image">
                                                    </div>
                                                @endif
                                            </span>
                                    <input name="logo" value="{{ old('logo', $vendor->logo ?? '') }}"
                                        class="form-control bg-light-subtle" type="file" 
                                        title="{{ asset('storage/vendor/vendor_image/' . $vendor->vendor_image ?? '') }}"
                                        required>
                                    @error('logo')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="formFile" class="form-label">Vender Image<b
                                            style="color: red;">*</b></label>
                                             @if ($vendor->gst_image)
                                                    <div class="mb-2 image-container">
                                                        <img id="existingImage"
                                                            src="{{ asset('storage/vendor/gst_image/'. $vendor->logo) }}"
                                                            alt="Current Image" class="small-image">
                                                    </div>
                                                @endif
                                    <input name="vendor_image"
                                        value="{{ old('vendor_image', $vendor->vendor_image ?? '') }}"
                                        class="form-control bg-light-subtle" type="file" id="formFile" required>
                                    @error('vendor_image')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 mb-3">
                                    <label for="GSTimage" class="form-label">GST Image<b
                                            style="color: red;">*</b></label>
                                    <span>
                                        @if ($vendor->gst_image)
                                            <div class="mb-2 image-container">
                                                <img id="existingImage"
                                                    src="{{ asset('storage/vendor/gst_image/' . $vendor->gst_image) }}"
                                                    alt="Current Image" class="small-image">
                                            </div>
                                        @endif
                                    </span>
                                    <input name="gst_image" value="{{ old('gst_image', $vendor->gst_image ?? '') }}"
                                        class="form-control bg-light-subtle" type="file" id="GSTimage" required>
                                    <div id="gstImageError" class="text-danger"></div>
                                    @error('gst_image')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="adharImage" class="form-label">Adhar Image<b
                                            style="color: red;">*</b></label>
                                    <span>
                                        @if ($vendor->adhar_image)
                                            <div class="mb-2 image-container">
                                                <img id="existingImage"
                                                    src="{{ asset('storage/vendor/adhar_image/' . $vendor->adhar_image) }}"
                                                    alt="Current Image" class="small-image">
                                            </div>
                                        @endif
                                    </span>
                                    <input name="adhar_image"
                                        value="{{ old('adhar_image', $vendor->adhar_image ?? '') }}"
                                        class="form-control bg-light-subtle" type="file" id="adharImage" required>
                                    <div id="adharImageError" class="text-danger" required></div>
                                    @error('adhar_image')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="PanImage" class="form-label">PAN Image<b
                                            style="color: red;">*</b></label>
                                    <span>
                                        @if ($vendor->pan_image)
                                            <div class="mb-2 image-container">
                                                <img id="existingImage"
                                                    src="{{ asset('storage/vendor/pan_image/' . $vendor->pan_image) }}"
                                                    alt="Current Image" class="small-image">
                                            </div>
                                        @endif
                                    </span>
                                    <input name="pan_image" value="{{ old('pan_image', $vendor->pan_image ?? '') }}"
                                        class="form-control bg-light-subtle" type="file" id="PanImage" required>
                                    <div id="PanImageError" class="text-danger"></div>
                                    @error('pan_image')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>
                            <div class="row mt-md-3">
                                <div class="col-md-4">
                                    <label for="adharvender" class="form-label">Adhar Number<b
                                            style="color: red;">*</b></label>
                                    <input name="adhar_numbere"
                                        value="{{ old('adhar_numbere', $vendor->adhar_numbere ?? '') }}"
                                        class="form-control bg-light-subtle" id="adharvender"
                                        onkeyup="validateField(this)" type="text" placeholder="Adhar Number"
                                        aria-label="default input example" maxlength="12" required>
                                    <div id="adharError" class="text-danger"></div>
                                    @error('adhar_numbere')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="col-md-4">
                                    <label for="gstNumber" class="form-label">GST Number<b
                                            style="color: red;">*</b></label>
                                    <input name="gst_number" value="{{ old('gst_number', $vendor->gst_number ?? '') }}"
                                        class="form-control bg-light-subtle" id="gstNumber" type="text"
                                        placeholder="GST number" aria-label="default input example"
                                        onkeyup="validateField(this)" maxlength="15" required>
                                    <div id="gstError" class="text-danger"></div>
                                    @error('gst_number')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="panCard" class="form-label">PAN Card Number<b
                                            style="color: red;">*</b></label>
                                    <input name="pan_number" value="{{ old('pan_number', $vendor->pan_number ?? '') }}"
                                        class="form-control bg-light-subtle" id="panCard" type="text"
                                        placeholder="PAN Card number" aria-label="default input example"
                                        onkeyup="validateField(this)" maxlength="10" required>
                                    <div id="panError" class="text-danger"></div>
                                    @error('pan_number')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>



                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label for="formFile" class="form-label">Client signature<b
                                            style="color: red;">*</b></label>
                                    <span>
                                        @if ($vendor->client_sign)
                                            <div class="mb-2 image-container">
                                                <img id="existingImage"
                                                    src="{{ asset('storage/vendor/client_sign/' . $vendor->client_sign) }}"
                                                    alt="Current Image" class="small-image">
                                            </div>
                                        @endif
                                    </span>
                                    <input name="client_sign"
                                        value="{{ old('client_sign', $vendor->client_sign ?? '') }}"
                                        class="form-control bg-light-subtle" type="file" id="formFile" required>
                                    @error('client_sign')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>




                                <div class="col-md-6 mb-3">
                                    <label for="formFile" class="form-label">Visiting Card Image<b
                                            style="color: red;">*</b></label>
                                    <span>
                                        @if ($vendor->visiting_card)
                                            <div class="mb-2 image-container">
                                                <img id="existingImage"
                                                    src="{{ asset('storage/vendor/visiting_card/' . $vendor->visiting_card) }}"
                                                    alt="Current Image" class="small-image">
                                            </div>
                                        @endif
                                    </span>

                                    <input name="visiting_card"  value="{{ old('visiting_card', $vendor->visiting_card ?? '') }}" class="form-control bg-light-subtle" type="file"
                                        id="formFile">
                                    @error('visiting_card')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mt-3">

                                <div class="col-md-4">
                                    <label for="formFile" class="form-label">Vendor Name<b
                                            style="color: red;">*</b></label>
                                    <input class="form-control bg-light-subtle"
                                        value="{{ old('vendor_name', $vendor->vendor_name ?? '') }}" type="text"
                                        name="vendor_name" placeholder="Enter Vendor Name"
                                        aria-label="default input example" required>
                                    @error('video')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="formFile" class="form-label">Review Count<b
                                            style="color: red;">*</b></label>
                                    <input class="form-control bg-light-subtle" type="text" name="review_count"
                                        value="{{ old('review_count', $vendor->review_count ?? '') }}"
                                        placeholder="Enter Review Count" aria-label="default input example" required>
                                    @error('video')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="experience" class="form-label">Experience<b
                                            style="color: red;">*</b></label>
                                    <select name="experience" id="experience" class="form-control bg-light-subtle"
                                        required>
                                        <option value="" selected disabled>Select Experience</option>
                                        @for ($i = 0; $i <= 20; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('experience') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <div id="experienceError" class="text-danger"></div>
                                    @error('experience')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>


                            <div class="row mt-3">
                                {{-- <div class="col-md-4">
                                    <label for="formFile" class="form-label">price<b style="color: red;">*</b></label>
                                    <input class="form-control bg-light-subtle" type="text" name="price"
                                        placeholder="Enter price" aria-label="default input example" required>
                                    @error('video')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <div class="col-md-4  mb-3">
                                    <label for="formFile" class="form-label">Official video <b
                                            style="color: red;">*</b></label>
                                    <input name="video" accept="video/*" class="form-control bg-light-subtle"
                                        type="file" id="formFile" required>
                                    <small id="fileHelp" class="form-text text-muted">Max file size: 50MB. Supported
                                        formats:
                                        mp4, m4v.</small>
                                    @error('video')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="formFile" class="form-label">Location<b style="color: red;">*</b></label>
                                    <input class="form-control bg-light-subtle" type="text" name="location_lat"
                                        value="{{ old('location_lat', $vendor->location_lat ?? '') }}"
                                        placeholder="Enter location" aria-label="default input example" required>
                                    @error('video')
                                        <div class="error text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-1 d-flex" style="align-items: center">
                                    <button type="button" id="addlocation" class="btn btn-primary">Add</button>

                                </div>
                                <div class="col-md-4 d-none" id="longitude">
                                    <label for="formFile" class="form-label">Longitude Location<b
                                            style="color: red;">*</b></label>
                                    <div class="d-flex gap-4">
                                        <input class="form-control bg-light-subtle" type="text" name="location_lang"
                                            placeholder="Enter longitude location" aria-label="default input example">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="mb-3 col-md-12">
                                        <label for="summery" class="col-form-label">Desription <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="summery" name="summery">{{ old('summery') }}</textarea>
                                        @error('summery')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#summery').summernote({
                                            placeholder: "Write short description.....",
                                            tabsize: 2,
                                            height: 330
                                        });
                                    });
                                </script>


                            </div>
                            <div class="row mt-3">
                                <div class="">

                                    <button type="submit" id="submitbutton" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('admin/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script>
        document.getElementById('companyNameCheckbox').addEventListener('change', function() {
            const companyNameField = document.getElementById('companyname');
            const legalCompanyNameField = document.getElementById('lcompanyname');

            if (this.checked) {
                legalCompanyNameField.value = companyNameField.value;
            } else {
                legalCompanyNameField.value = ''; // Clear the legal company name if checkbox is unchecked
            }
        });

        // Optional: Sync legal company name when company name is typed
        document.getElementById('companyname').addEventListener('input', function() {
            const checkbox = document.getElementById('companyNameCheckbox');
            if (checkbox.checked) {
                document.getElementById('lcompanyname').value = this.value;
            }
        });
    </script>

    {{-- ...................Show  upload image (start)...................... --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('formFile');
            const imagePreview = document.getElementById('existingImage');

            fileInput.addEventListener('change', function() {
                const file = fileInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Update the existing image with the new file
                        if (imagePreview) {
                            imagePreview.src = e.target.result;
                        } else {
                            // Create a new image element if none exists
                            const newImage = document.createElement('img');
                            newImage.src = e.target.result;
                            newImage.classList.add('small-image');
                            newImage.style.maxWidth = '100%';
                            newImage.style.height = 'auto';
                            fileInput.parentNode.insertBefore(newImage, fileInput);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    {{-- ...................Show  upload image (end)...................... --}}
    <script>
        document.getElementById('addlocation').addEventListener('click', function() {

            document.getElementById('longitude').classList.remove('d-none');
            document.getElementById('addlocation').classList.add('d-none');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#state').on('change', function() {
                var stateId = $(this).val();
                if (stateId) {
                    $.ajax({
                        url: '/fetch-city-vendor/' + stateId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                            $('#city').empty().append('<option value="">Select City</option>');
                            if (response.status === 1) {
                                $.each(response.data, function(key, city) {
                                    $('#city').append("<option value='" + city.id +
                                        "'>" + city.name + "</option>");
                                });
                            } else {
                                $('#city').append(
                                    '<option value="" disabled>No cities found</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            $('#city').empty().append(
                                '<option value="" disabled>Error loading cities</option>');
                        }
                    });
                } else {
                    $('#city').empty().append('<option value="">Select City</option>');
                }
            });
        });

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
                        $('#subcategory').empty().append(
                            '<option value="" selected disabled>Select Subcategory</option>'
                        );
                        if (response.status === 1 && response.data.length > 0) {
                            $.each(response.data, function(key, subcateg) {
                                $('#subcategory').append(
                                    '<option value="' +
                                    subcateg.id + '">' + subcateg
                                    .name +
                                    '</option>');
                            });
                        } else {
                            $('#subcategory').append(
                                '<option value="" disabled>No subcategories found</option>'
                            );
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

        $('#subcategory').on('change', function() {
            var subcategoryId = $(this).val();
            if (subcategoryId) {
                $.ajax({
                    url: '/getMenus/' + subcategoryId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#menu').empty().append(
                            '<option value="" selected disabled>Select Menu</option>'
                        );
                        if (response.status === 1 && response.data.length > 0) {
                            $.each(response.data, function(key, menu) {
                                $('#menu').append('<option value="' +
                                    menu.id +
                                    '">' + menu.name + '</option>');
                            });
                        } else {
                            $('#menu').append(
                                '<option value="" disabled>No menus available</option>'
                            );
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading menus:', xhr);
                        $('#menu').empty().append(
                            '<option value="" disabled>Error loading menus</option>'
                        );
                    }
                });
            } else {
                $('#menu').empty().append(
                    '<option value="" selected disabled>Select Menu</option>'
                );
            }
        });

        $('#menu').on('change', function() {
            var submenuId = $(this).val();
            if (submenuId) {
                $.ajax({
                    url: '/getsubMenus/' + submenuId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#submenu').empty().append(
                            '<option value="" selected disabled>Select SubMenu</option>'
                        );
                        if (response.status === 1 && response.data.length > 0) {
                            $.each(response.data, function(key, submenu) {
                                $('#submenu').append('<option value="' +
                                    submenu.id +
                                    '">' + submenu.name + '</option>');
                            });
                        } else {
                            $('#submenu').append(
                                '<option value="" disabled>No menus available</option>'
                            );
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading menus:', xhr);
                        $('#submenu').empty().append(
                            '<option value="" disabled>Error loading menus</option>'
                        );
                    }
                });
            } else {
                $('#menu').empty().append(
                    '<option value="" selected disabled>Select Menu</option>'
                );
            }
        });
    </script>
@endsection
