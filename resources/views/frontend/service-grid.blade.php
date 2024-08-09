@extends('frontend.layouts.main')
@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/booking_infoPopup.css') }}"> --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Popup Background */
        .popup {
            /* display: block; */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Popup Content */
        .popup-content {
            background-color: #eee7e7;
            margin: 4% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 42%;
            text-align: center;
            border-radius: 5px;
            transform: translateY(-30px);
            transition: transform 0.3s ease;
        }

        .popup.show {
            display: block;
            opacity: 1;
        }

        .popup.show .popup-content {
            transform: translateY(0);
            /* Move to original position */
        }

        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .btn {
            background-color: #007bff;
            /* Bootstrap primary color */
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #1573d6;
            /* Darker blue on hover */
        }
    </style>

    <div class="bg-img">
        <img src="{{ asset('assets/img/bg/work-bg-03.png') }}" alt="img" class="bgimg1">
        <img src="{{ asset('assets/img/bg/work-bg-03.png') }}" alt="img" class="bgimg2">
        <img src="{{ asset('assets/img/bg/feature-bg-03.png') }}" alt="img" class="bgimg3">
    </div>




    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Service Grid</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Service Grid</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- .....................Slider............................... -->
    <div class="row">
        <div class="slider-container">
            <button class="prev" onclick="slideLeft()">&#10094;</button>
            <div class="slider-wrapper">
                <div class="slider">
                    @foreach ($categories as $cat)
                        <div class="slide">
                            <a href=""><img src="{{ asset('storage/assets/icon/' . $cat->icon ?? '') }}"
                                    alt="Quick Booking"><span>{{ $cat->name ?? '' }}</span></a>
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="next" onclick="slideRight()">&#10095;</button>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3 col-sm-12 theiaStickySidebar">
                    <div class="filter-div">
                        <div class="filter-head">
                            <h5>Filter by</h5>
                            <a href="#" class="reset-link" onclick="resetVal()">Reset Filters</a>
                        </div>
                        <div class="filter-content">
                            <h2>Keyword</h2>
                            <input type="text" class="form-control" id="input-keyword"
                                placeholder="What are you looking for?">
                        </div>
                        <div class="filter-content">
                            <h2>Location</h2>
                            <div class="group-img">
                                <input type="text" id="location-val" class="form-control" placeholder="Select Location">
                                <i class="feather-map-pin"></i>
                            </div>
                        </div>
                        <div class="filter-content">
                            <h2>Categories <span><i class="feather-chevron-down"></i></span></h2>
                            <div class="filter-checkbox" id="fill-more">
                                <ul>
                                    <li>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="toggleCheckbox" id="allCategories">
                                            <span><i></i></span>
                                            <b class="check-content">All Categories</b>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="toggleCheckbox categoryCheckbox">
                                            <span><i></i></span>
                                            <b class="check-content">Construction</b>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="toggleCheckbox categoryCheckbox">
                                            <span><i></i></span>
                                            <b class="check-content">Car Wash</b>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="toggleCheckbox categoryCheckbox">
                                            <span><i></i></span>
                                            <b class="check-content">Electrical</b>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="toggleCheckbox categoryCheckbox">
                                            <span><i></i></span>
                                            <b class="check-content">Cleaning</b>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="toggleCheckbox categoryCheckbox">
                                            <span><i></i></span>
                                            <b class="check-content">Interior</b>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="toggleCheckbox categoryCheckbox">
                                            <span><i></i></span>
                                            <b class="check-content">Computer</b>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <a href="javascript:void(0);" id="more" class="more-view">View More <i
                                    class="feather-arrow-down-circle ms-1"></i></a>
                        </div>
                        <div class="filter-content">
                            <h2>Sub Category</h2>
                            <select class="form-control select" id="mySelect">
                                <option value="AllSubCategory">All Sub Category</option>
                                <option value="computer">Computer</option>
                                <option value="construction">Construction1</option>
                                <option value="construction">Construction2</option>
                                <option value="construction">Construction3</option>
                            </select>
                        </div>
                        <!-- <div class="filter-content">
                                                            <h2>Location</h2>
                                                            <div class="group-img">
                                                                <input type="text" class="form-control" placeholder="Select Location">
                                                                <i class="feather-map-pin"></i>
                                                            </div>
                                                        </div> -->
                        <div class="filter-content">
                            <h2 class="mb-4">Price Range</h2>
                            <div class="filter-range">
                                <input type="text" id="range_03">
                            </div>
                            <div class="filter-range-amount">
                                <h5>Price: <span>$5 - $210</span></h5>
                            </div>
                        </div>
                        <div class="filter-content">
                            <h2>By Rating <span><i class="feather-chevron-down"></i></span></h2>
                            <ul class="rating-set">
                                <li>
                                    <label class="checkboxs d-inline-flex">
                                        <input type="checkbox" class="toggleCheckbox">
                                        <span><i></i></span>
                                    </label>
                                    <a class="rating" href="javascript:void(0);">
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <span class="d-inline-block average-rating float-end">(35)</span>
                                    </a>
                                </li>
                                <li>
                                    <label class="checkboxs d-inline-flex">
                                        <input type="checkbox" class="toggleCheckbox">
                                        <span><i></i></span>
                                    </label>
                                    <a class="rating" href="javascript:void(0);">
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <span class="d-inline-block average-rating float-end">(40)</span>
                                    </a>
                                </li>
                                <li>
                                    <label class="checkboxs d-inline-flex">
                                        <input type="checkbox" class="toggleCheckbox">
                                        <span><i></i></span>
                                    </label>
                                    <a class="rating" href="javascript:void(0);">
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <span class="d-inline-block average-rating float-end">(40)</span>
                                    </a>
                                </li>
                                <li>
                                    <label class="checkboxs d-inline-flex">
                                        <input type="checkbox" class="toggleCheckbox">
                                        <span><i></i></span>
                                    </label>
                                    <a class="rating" href="javascript:void(0);">
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <span class="d-inline-block average-rating float-end">(20)</span>
                                    </a>
                                </li>
                                <li>
                                    <label class="checkboxs d-inline-flex">
                                        <input type="checkbox" class="toggleCheckbox">
                                        <span><i></i></span>
                                    </label>
                                    <a class="rating" href="javascript:void(0);">
                                        <i class="fa-regular fa-star filled"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <span class="d-inline-block average-rating float-end">(5)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>


                <div class="col-md-9 col-sm-12">
                    <div class="row sorting-div">
                        <div class="col-lg-4 col-sm-12 ">
                            <div class="count-search">
                                <h6>Found 12 Services</h6>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12 d-flex justify-content-end ">
                            <div class="sortbyset">
                                <div class="sorting-select">
                                    <select class="form-control select">
                                        <option>Price Low to High</option>
                                        <option>Price High to Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-listview">
                                <ul>
                                    <li>
                                        <a href="service-grid.html" class="active">
                                            <i class="feather-grid"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-list.html">
                                            <i class="feather-list"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="myPopup-booking" class="popup">
                        <div class="popup-content">
                            <h3>Login/Sign up</h3>
                            <span class="close" id="closePopup-booking">&times;</span>
                            <img src="{{ asset('assets/img/icons/signup.png') }}" alt="">
                            <h5 class="sign-up-text">Enter your Mobile Number</h5>
                            <input type="tel" id="phoneNumberInput-booking" class="phone-number-field"
                                onkeyup="validateNum(this)" maxlength="10" placeholder="Enter Mobile Number" required>
                            <div id="res"></div>
                            <button id="saveChanges-booking" class="btn"
                                onclick="startCountdown(60)">Continue</button>
                            <!-- <button id="closePopupBtn" class="btn">Close</button> -->
                            <div class="term-condition">
                                <input type="checkbox" class="checkbox" id="checkbox-login-booking">
                                <p>By Continuing, you agree to our <span class="term">Term and Condition</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="row">
                            @foreach ($subcategories as $subcategory)
                                <div class="col-xl-4 col-md-4">
                                    <div class="service-widget servicecontent">
                                        <div class="service-img service-img-grid">
                                            <a href="{{ route('service-details') }}">
                                                <img class="img-fluid serv-img serv-img-grid" alt="Service Image"
                                                    src="{{ Storage::url('assets/subcategory/' . $subcategory->image) }}">
                                            </a>
                                            <div class="fav-item">
                                                <a href="categories.html"><span
                                                        class="item-cat">{{ $subcategory->category->name ?? '' }}</span></a>

                                            </div>
                                            <div class="item-info">
                                                <a href="providers.html"><span class="item-img"><img
                                                            src="{{ asset('assets/img/profiles/avatar-01.jpg') }}"
                                                            class="avatar" alt="User"></span></a>
                                            </div>
                                        </div>
                                        <div class="service-content">
                                            <h3 class="title">
                                                <a
                                                    href="{{ route('service-details') }}">{{ $subcategory->name ?? '' }}</a>
                                            </h3>
                                            <p><i class="feather-map-pin"></i>Maryland City, USA<span class="rate"><i
                                                        class="fas fa-star filled"></i>4.9</span></p>
                                            <div class="serv-info">
                                                <h6>&#8377;{{ $subcategory->discounted_price }}
                                                    @if ($subcategory->discount != null)
                                                        <span
                                                            class="old-price">&#8377;{{ $subcategory->total_price ?? '' }}</span>
                                                    @endif
                                                </h6>
                                                <a class="btn btn-book" id="booking-services">Book Now</a>

                                            </div>

                                            <div>
                                                <a href="{{ route('service-details') }}" class="btn btn-book"
                                                    style="width: 100%; margin-top: 2%;">View details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="blog-pagination rev-page">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item disabled">
                                                <a class="page-link page-prev" href="javascript:void(0);"
                                                    tabindex="-1"><i class="fa-solid fa-arrow-left me-1"></i> PREV</a>
                                            </li>
                                            <li class="page-item active">
                                                <a class="page-link" href="javascript:void(0);">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="javascript:void(0);">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="javascript:void(0);">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link page-next" href="javascript:void(0);">NEXT <i
                                                        class="fa-solid fa-arrow-right ms-1"></i></a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <section class="service-section">
            <div class="container">
                <div class="section-heading">
                    <div class="row align-items-center">
                        <div class="col-md-6 aos" data-aos="fade-up">
                            <h2>Featured Services</h2>
                            <p>Explore the greates our services. You won’t be disappointed</p>
                        </div>
                        <div class="col-md-6 text-md-end aos" data-aos="fade-up">
                            <div class="owl-nav mynav"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="owl-carousel service-slider">
                            <div class="service-widget aos" data-aos="fade-up">
                                <div class="service-img p-2">
                                    <a href="service-details.html">
                                        <img class="img-fluid serv-img" alt="Service Image"
                                            src="{{ asset('assets/img/services/service-01.jpg') }}">
                                    </a>
                                    <div class="fav-item">
                                        <a href="categories.html"><span class="item-cat">Cleaning</span></a>
                                        <a href="javascript:void(0)" class="fav-icon">
                                            <i class="feather-heart"></i>
                                        </a>
                                    </div>

                                </div>
                                <div class="service-content">
                                    <h3 class="title">
                                        <a href="service-details.html">Electric Panel Repairing Service</a>
                                    </h3>
                                    <p><i class="feather-map-pin"></i>New Jersey, USA<span class="rate"><i
                                                class="fas fa-star filled"></i>4.9</span></p>
                                    <div class="serv-info">
                                        <h6>$25.00<span class="old-price">$35.00</span></h6>
                                        <a href="service-details.html" class="btn btn-book">Book Now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="service-widget aos" data-aos="fade-up">
                                <div class="service-img p-2">
                                    <a href="service-details.html">
                                        <img class="img-fluid serv-img" alt="Service Image"
                                            src="{{ asset('assets/img/services/service-02.jpg') }}">
                                    </a>
                                    <div class="fav-item">
                                        <a href="categories.html"><span class="item-cat">Construction</span></a>
                                        <a href="javascript:void(0)" class="fav-icon">
                                            <i class="feather-heart"></i>
                                        </a>
                                    </div>

                                </div>
                                <div class="service-content">
                                    <h3 class="title">
                                        <a href="service-details.html">Toughened Glass Fitting Services</a>
                                    </h3>
                                    <p><i class="feather-map-pin"></i>Montana, USA<span class="rate"><i
                                                class="fas fa-star filled"></i>4.9</span></p>
                                    <div class="serv-info">
                                        <h6>$45.00</h6>
                                        <a href="service-details.html" class="btn btn-book">Book Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="service-widget aos" data-aos="fade-up">
                                <div class="service-img p-2">
                                    <a href="service-details.html">
                                        <img class="img-fluid serv-img" alt="Service Image"
                                            src="{{ asset('assets/img/services/service-03.jpg') }}">
                                    </a>
                                    <div class="fav-item">
                                        <a href="categories.html"><span class="item-cat">Carpentry</span></a>
                                        <a href="javascript:void(0)" class="fav-icon">
                                            <i class="feather-heart"></i>
                                        </a>
                                    </div>

                                </div>
                                <div class="service-content">
                                    <h3 class="title">
                                        <a href="service-details.html">Wooden Carpentry Work</a>
                                    </h3>
                                    <p><i class="feather-map-pin"></i>Montana, USA<span class="rate"><i
                                                class="fas fa-star filled"></i>4.9</span></p>
                                    <div class="serv-info">
                                        <h6>$45.00</h6>
                                        <a href="service-details.html" class="btn btn-book">Book Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="service-widget aos" data-aos="fade-up">
                                <div class="service-img p-2">
                                    <a href="service-details.html">
                                        <img class="img-fluid serv-img" alt="Service Image"
                                            src="{{ asset('assets/img/services/service-11.jpg') }}">
                                    </a>
                                    <div class="fav-item">
                                        <a href="categories.html"><span class="item-cat">Construction</span></a>
                                        <a href="javascript:void(0)" class="fav-icon">
                                            <i class="feather-heart"></i>
                                        </a>
                                    </div>
                                    <div class="item-info">
                                        <a href="providers.html"><span class="item-img"><img
                                                    src="{{ asset('assets/img/profiles/avatar-04.jpg') }}" class="avatar"
                                                    alt="User"></span></a>
                                    </div>
                                </div>
                                <div class="service-content">
                                    <h3 class="title">
                                        <a href="service-details.html">Plumbing Services</a>
                                    </h3>
                                    <p><i class="feather-map-pin"></i>Georgia, USA<span class="rate"><i
                                                class="fas fa-star filled"></i>4.9</span></p>
                                    <div class="serv-info">
                                        <h6>$45.00</h6>
                                        <a href="service-details.html" class="btn btn-book">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- <script>
            var booking_btn = document.getElementById('booking-services');
            var myPopup_booking = document.getElementById('myPopup_booking')
            var closePopup_booking = document.getElementById("closePopup_booking");

            var popup2_booking = document.getElementById("myPopup2_booking");
            var closeSpan2_booking = document.getElementById("closePopup2_booking");
            var editnum_booking = document.getElementById("editnumber_booking");
            var saveChanges_booking = document.getElementById("saveChanges_booking");

            // console.log(booking_btn);


            booking_btn.onclick = function() {
                alert();
                myPopup_booking.classList.add("show");
            };

        </script> --}}

        <script src="{{ asset('assets/js/booking_infoPopup.js') }}"></script>
    @endsection
