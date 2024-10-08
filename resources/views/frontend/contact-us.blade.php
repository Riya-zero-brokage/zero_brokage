@extends('frontend.layouts.main')
@section('content')
    <div class="main-wrapper">
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <h2 class="breadcrumb-title">Contact Us</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Contact Us
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="contact-details">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="contact-info flex-fill">
                                <span><i class="feather-phone"></i></span>
                                <div class="contact-data">
                                    <h4>Phone Number</h4>
                                    <p>09429690472</p>
                                    <p>8303361853</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="contact-info flex-fill">
                                <span><i class="feather-mail"></i></span>
                                <div class="contact-data">
                                    <h4>Email Address</h4>
                                    <p>
                                        <a href="mailto:zerobrokage@gmail.com">zerobrokage@gmail.com</a>
                                    </p>
                                    <p>
                                        <a
                                            href="https://truelysell.dreamstechnologies.com/cdn-cgi/l/email-protection#741e1b1c1a07191d001c34110c15190418115a171b19"></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="contact-info flex-fill">
                                <span><i class="feather-map-pin"></i></span>
                                <div class="contact-data">
                                    <h4>Address</h4>
                                    <p>VILL HOSHIYARPUR HOSHIYARPUR C/O-SUSHIL YADAV NOIDA Gautam Buddha Nagar UP 201307</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 shadow p-3 rounded">
                        <div class="contact-queries">
                            <h2>Get In Touch</h2>
                            <form action="https://truelysell.dreamstechnologies.com/html/template/contact-us.html">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Name</label>
                                            <input class="form-control" type="text" placeholder="Enter Name*" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Email</label>
                                            <input class="form-control" type="email" placeholder="Enter Email Address*" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Phone Number</label>
                                            <input class="form-control" type="text" placeholder="Enter Phone Number" />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Message</label>
                                            <textarea class="form-control" rows="4" placeholder="Type Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">
                                            Send Message<i class="feather-arrow-right-circle ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 map-grid">

                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d28030.11937131096!2d77.34992173273241!3d28.57682098217152!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sVILL%20HOSHIYARPUR%20HOSHIYARPUR%20C%2FO-SUSHIL%20YADAV%20NOIDA%20Gautam%20Buddha%20Nagar%20UP%20201307%20IN!5e0!3m2!1sen!2sin!4v1726562413163!5m2!1sen!2sin"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>





        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>
    </div>
@endsection
