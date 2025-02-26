@extends('layouts.app')

@section('content')
<style>
h1,
h2,
h3,
h4,
h5,
h6 {
    color: #2c3145;
}

a,
a:hover,
a:focus,
a:active {
    text-decoration: none;
    outline: none;
}

ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.section_all {
    position: relative;
    padding-top: 80px;
    padding-bottom: 80px;
    min-height: 100vh;
}

.section-title {
    font-weight: 700;
    text-transform: capitalize;
    letter-spacing: 1px;
}

.section-subtitle {
    letter-spacing: 0.4px;
    line-height: 28px;
    max-width: 550px;
}

.section-title-border {
    background-color: #000;
    height: 1 3px;
    width: 44px;
}

.section-title-border-white {
    background-color: #fff;
    height: 2px;
    width: 100px;
}

.text_custom {
    color: #760e13;
}

.about_icon i {
    font-size: 22px;
    height: 65px;
    width: 65px;
    line-height: 65px;
    display: inline-block;
    background: #fff;
    border-radius: 35px;
    color: #760e13;
    box-shadow: 0 8px 20px -2px rgba(158, 152, 153, 0.5);
}

.about_header_main .about_heading {
    max-width: 450px;
    font-size: 24px;
}

.about_icon span {
    position: relative;
    top: -10px;
}

.about_content_box_all {
    padding: 28px;
}
</style>
<section class="section_all bg-light" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section_title_all text-center">
                    <h3 class="font-weight-bold">Welcome To <span class="text-custom">Carlly Motors</span></h3>
                    <p class="section_subtitle mx-auto text-muted">
                        At Carlly Motors, we understand the complexities
                        and challenges of car ownership and maintenance. To address these, we have
                        developed two specialized apps: one for customers looking to buy, sell, or
                        maintain their vehicles, and another for service providers offering their
                        skills and services. This dual-app ecosystem ensures a seamless connection
                        between car owners and service professionals, enhancing the overall user
                        experience.
                    </p>
                    <div class="">
                        <i class=""></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row vertical_content_manage mt-5">
            <div class="col-lg-6">
                <div class="about_header_main mt-3">
                    <div class="about_icon_box">
                        <p class="text_custom font-weight-bold">Driving Innovation in the Automotive World</p>
                    </div>
                    <h4 class="about_heading text-capitalize font-weight-bold mt-4">Our Vision and Mission</h4>
                    <p class="text-muted mt-3">Founded in 2023 in the vibrant city of Dubai,
                        Carlly Motors has rapidly emerged as a trailblazer in the automotive service
                        industry.
                    </p>

                    <p class="text-muted mt-3">
                        Our mission is to transform the automotive landscape by providing
                        an all-encompassing platform for both car owners and service providers. We
                        strive to deliver unparalleled convenience, efficiency, and reliability
                        through our innovative mobile applications tailored for distinct user
                        experiences.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="img_about mt-3" >
                    <img src="{{asset('aboutus.jpg')}}" alt=""  style="border-radius:10px" class="img-fluid mx-auto d-block">
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12 col-sm-12 bg-light text-center border-end border-bottom py-5 px-3">
                <i class="bi bi-images text-danger fs-1"></i>
                <h4 class="mb-3 fw-normal text-uppercase">Our Services</h4>
            </div>

            <div class="col-md-6 col-sm-6 bg-light text-center border-end py-5 px-3">
                <i class="bi bi-pencil-square text-danger fs-1"></i>
                <h4 class="mb-3 fw-normal text-uppercase">Accessibility</h4>
                <p class="text-secondary">
                    Carlly Motors offers a wide range of automotive
                    services accessible through our apps. These include car buying and selling,
                    auctions, access to both new and used car parts, roadside assistance,
                    vehicle transportation, comprehensive car insurance, and professional repair
                    services. Our platform caters to every aspect of vehicle management, making
                    it a one-stop solution for all automotive needs.
                </p>
            </div>
            <div class="col-md-6 col-sm-6 bg-light text-center border-end py-5 px-3">
                <i class="bi bi-briefcase text-danger fs-1"></i>
                <h4 class="mb-3 fw-normal text-uppercase">Quality and Excellence</h4>
                <p class="text-secondary">
                    Quality assurance is paramount at Carlly Motors. We
                    meticulously vet all service providers through a rigorous verification
                    process, ensuring that only qualified and trustworthy professionals are part
                    of our network. Our commitment to excellence is unwavering, and we
                    continuously strive to enhance our services through customer feedback and
                    technological advancements.
                </p>
            </div>
            <hr>
            <div class="col-md-12 col-sm-12 bg-light text-center py-5 px-3">
                <i class="bi bi-book text-danger fs-1"></i>
                <h4 class="mb-3 fw-normal text-uppercase">Join Us on Our Journey</h4>
                <p class="text-secondary">
                    As we continue to grow and expand our services in
                    Dubai and beyond, we invite you to join us on this exciting journey. Whether
                    you are a car owner seeking reliable services or a service provider looking
                    to expand your reach, Carlly Motors provides the tools and platform to meet
                    your needs. Together, we are setting new standards in the automotive service
                    industry, driving towards a more connected and efficient future.

                </p>
            </div>
        </div>
        <hr>

        <div class="row mt-3">
            <div class="col-lg-3">
                <div class="about_content_box_all mt-3">
                    <div class="about_detail text-center">
                        <div class="about_icon">
                        <i class="fas fa-trophy me-3 fs-3"></i>
                        </div>
                        <h5 class="text-dark text-capitalize mt-3 font-weight-bold">Top 1 Americas</h5>
                        <p class="edu_desc mt-3 mb-0 text-muted">
                        Largest Auto portal
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="about_content_box_all mt-3">
                    <div class="about_detail text-center">
                        <div class="about_icon">
                        <i class="fas fa-car me-3 fs-3"></i>
                        </div>
                        <h5 class="text-dark text-capitalize mt-3 font-weight-bold">Car Sold</h5>
                        <p class="edu_desc mb-0 mt-3 text-muted">
                        Every 5 minutes
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="about_content_box_all mt-3">
                    <div class="about_detail text-center">
                        <div class="about_icon">
                        <i class="fas fa-tags me-3 fs-3"></i>
                        </div>
                        <h5 class="text-dark text-capitalize mt-3 font-weight-bold">Offers</h5>
                        <p class="edu_desc mb-0 mt-3 text-muted">
                            Stay updated, pay less
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="about_content_box_all mt-3">
                    <div class="about_detail text-center">
                        <div class="about_icon">
                        <i class="fas fa-balance-scale me-3 fs-3"></i>
                        </div>
                        <h5 class="text-dark text-capitalize mt-3 font-weight-bold">Compare</h5>
                        <p class="edu_desc mb-0 mt-3 text-muted">
                            Decode the right car
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection