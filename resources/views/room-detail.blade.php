@extends('layouts.app')

@section('content')
<main>

    <div class="hero full-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img kenburns" src="{{ asset('img/rooms/1.jpg') }}" alt="">
        <div class="wrapper opacity-mask d-flex align-items-center  text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <small class="slide-animated one">Luxury Hotel Experience</small>
                        <h1 class="slide-animated two">Sierra Double Room</h1>
                        <p class="slide-animated three">Exquisite furnishings for a cosy ambience</p>
                    </div>
                </div>
            </div>
            <div class="mouse_wp slide-animated four">
                <a href="#first_section" class="btn_explore">
                    <div class="mouse"></div>
                </a>
            </div>
            <!-- / mouse -->
        </div>
    </div>
    <!-- /Background Img Parallax -->

    <div class="bg_white" id="first_section">
        <div class="container margin_120_95">
            <div class="row justify-content-between">
                <div class="col-lg-4">
                    <div class="title">
                        <small>Luxury Experience</small>
                        <h2>A deeply space that invites you to truly Switch Off.</h2>
                    </div>
                    <p>The dark wood panelling and furnishings, deluxe red-draped four-poster bed, and magnificent black stone bathroom evoke the charm of a secluded Sierra Nevada getaway. The intimate scale and finish give the room a distinctly personal feel.</p>
                    <p>The dark wood panelling and furnishings, deluxe red-draped four-poster bed, and magnificent black stone bathroom evoke the charm.</p>
                </div>
                <div class="col-lg-6">
                    <div class="room_facilities_list">
                        <ul data-cues="slideInLeft">
                            <li><i class="icon-hotel-double_bed_2"></i> King Size Bed</li>
                            <li><i class="icon-hotel-safety_box"></i> Safety Box</li>
                            <li><i class="icon-hotel-patio"></i>Balcony</li>
                            <li><i class="icon-hotel-tv"></i> 32 Inch TV</li>
                            <li><i class="icon-hotel-disable"></i> Disable Access</li>
                            <li><i class="icon-hotel-dog"></i> Pet Allowed</li>
                            <li><i class="icon-hotel-bottle"></i> Welcome Bottle</li>
                            <li><i class="icon-hotel-wifi"></i> Wifi / Netflix access</li>
                            <li><i class="icon-hotel-hairdryer"></i> Air Dryer</li>
                            <li><i class="icon-hotel-condition"></i> Air Condition</li>
                            <li><i class="icon-hotel-loundry"></i>Loundry Service</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bg_white -->

    <div class="bg_white add_bottom_120">
        <div class="container-fluid p-lg-0">
            <div data-cues="zoomIn">
                <div class="owl-carousel owl-theme carousel_item_centered kenburns rounded-img">
                    <div class="item">
                        <img src="{{ asset('img/rooms/opt_5.jpg') }}" alt="">
                    </div>
                    <div class="item">
                        <img src="{{ asset('img/rooms/opt_1.jpg') }}" alt="">
                    </div>
                    <div class="item">
                        <img src="{{ asset('img/rooms/opt_4.jpg') }}" alt="">
                    </div>
                    <div class="item">
                        <img src="{{ asset('img/rooms/opt_6.jpg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a class="btn_1 outline" data-fslightbox="gallery_1" data-type="image" href="{{ asset('img/rooms/opt_5.jpg') }}">FullScreen Gallery</a>
                <a data-fslightbox="gallery_1" data-type="image" href="{{ asset('img/rooms/opt_1.jpg') }}"></a>
                <a data-fslightbox="gallery_1" data-type="image" href="{{ asset('img/rooms/opt_4.jpg') }}"></a>
                <a data-fslightbox="gallery_1" data-type="image" href="{{ asset('img/rooms/opt_6.jpg') }}"></a>
            </div>
        </div>
    </div>
    <!-- /bg_white -->

    <div class="container margin_120_95" id="reviews">
        <div class="row justify-content-between">
            <div class="col-lg-4 order-lg-2 fixed_title reviews_sum_details">
                <div class="title">
                    <small>Paradise Hotel</small>
                    <h2>Reviews</h2>
                </div>
                <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus.</p>
                <h6>Comfort</h6>
                <div class="row mb-2">
                    <div class="col-xl-10 col-lg-9 col-10">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-2"><strong>9.0</strong></div>
                </div>
                <!-- /row -->
                <h6>Facilities</h6>
                <div class="row mb-2">
                    <div class="col-xl-10 col-lg-9 col-10">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-2"><strong>9.5</strong></div>
                </div>
                <!-- /row -->
                <h6>Location</h6>
                <div class="row mb-2">
                    <div class="col-xl-10 col-lg-9 col-10">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-2"><strong>6.0</strong></div>
                </div>
                <!-- /row -->
                <h6>Price</h6>
                <div class="row mb-2">
                    <div class="col-xl-10 col-lg-9 col-10">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-2"><strong>6.0</strong></div>
                </div>
                <!-- /row -->
            </div>
            <div class="col-lg-7 order-lg-1">
                <div class="review_card">
                    <div class="row">
                        <div class="col-md-2 user_info">
                            <figure><img src="{{ asset('img/avatar4.jpg') }}" alt=""></figure>
                            <h5>Lukas</h5>
                        </div>
                        <div class="col-md-10 review_content">
                            <div class="clearfix mb-3">
                                <span class="rating">8.5<small>/10</small> <strong>Rating average</strong></span>
                                <em>Published 54 minutes ago</em>
                            </div>
                            <h4>"Great Location!!"</h4>
                            <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.</p>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /review_card -->
                <div class="review_card">
                    <div class="row">
                        <div class="col-md-2 user_info">
                            <figure><img src="{{ asset('img/avatar6.jpg') }}" alt=""></figure>
                            <h5>Lukas</h5>
                        </div>
                        <div class="col-md-10 review_content">
                            <div class="clearfix mb-3">
                                <span class="rating">8.5<small>/10</small> <strong>Rating average</strong></span>
                                <em>Published 10 Oct. 2022</em>
                            </div>
                            <h4>"Awesome Experience"</h4>
                            <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.</p>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /review_card -->
                <div class="review_card">
                    <div class="row">
                        <div class="col-md-2 user_info">
                            <figure><img src="{{ asset('img/avatar1.jpg') }}" alt=""></figure>
                            <h5>Marika</h5>
                        </div>
                        <div class="col-md-10 review_content">
                            <div class="clearfix mb-3">
                                <span class="rating">9.0<small>/10</small> <strong>Rating average</strong></span>
                                <em>Published 11 Oct. 2022</em>
                            </div>
                            <h4>"Really great dinner!!"</h4>
                            <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.</p>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="row reply">
                        <div class="col-md-2 user_info">
                            <figure><img src="{{ asset('img/avatar.jpg') }}" alt=""></figure>
                        </div>
                        <div class="col-md-10">
                            <div class="review_content">
                                <strong>Reply from Admin</strong>
                                <em>Published 3 minutes ago</em>
                                <p><br>Hi Monika,<br><br>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.<br><br>Thanks</p>
                            </div>
                        </div>
                    </div>
                    <!-- /reply -->
                </div>
                <!-- /review_card -->
                <p class="text-end"><a href="#0" class="btn_1">Leave a review</a></p>
            </div>
        </div>
    </div>
    <!-- /reviews -->

    <div class="bg_white">
        <div class="container margin_120_95">
            <div data-cue="slideInUp">
                <div class="title">
                    <small>Paradise Hotel</small>
                    <h2>Similar Rooms</h2>
                </div>
                <div class="row" data-cues="slideInUp" data-delay="800">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <a href="{{ url('/rooms') }}" class="box_cat_rooms">
                            <figure>
                                <div class="background-image" data-background="url({{ asset('img/rooms/1.jpg') }})"></div>
                                <div class="info">
                                    <small>From $150/night</small>
                                    <h3>Double Room</h3>
                                    <span>Read more</span>
                                </div>
                            </figure>
                        </a>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <a href="{{ url('/rooms') }}" class="box_cat_rooms">
                            <figure>
                                <div class="background-image" data-background="url({{ asset('img/rooms/2.jpg') }})"></div>
                                <div class="info">
                                    <small>From $190/night</small>
                                    <h3>Deluxe Room</h3>
                                    <span>Read more</span>
                                </div>
                            </figure>
                        </a>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <a href="{{ url('/rooms') }}" class="box_cat_rooms">
                            <figure>
                                <div class="background-image" data-background="url({{ asset('img/rooms/3.jpg') }})"></div>
                                <div class="info">
                                    <small>From $240/night</small>
                                    <h3>Superior Room</h3>
                                    <span>Read more</span>
                                </div>
                            </figure>
                        </a>
                    </div>
                </div>
                <!-- /row-->
            </div>
        </div>
    </div>
    <!-- /bg_white -->

    <div class="container margin_120_95" id="booking_section">
        <div class="row justify-content-between">
            <div class="col-xl-4">
                <div data-cue="slideInUp">
                    <div class="title">
                        <small>Paradise Hotel</small>
                        <h2>Check Availability</h2>
                    </div>
                    <p>Mea nibh meis philosophia eu. Duis legimus efficiantur ea sea. Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu. </p>
                    <p class="phone_element no_borders"><a href="tel://423424234"><i class="bi bi-telephone"></i><span><em>Info and bookings</em>+41 934 121 1334</span></a></p>
                </div>
            </div>
            <div class="col-xl-7">
                <div data-cue="slideInUp" data-delay="200">
                    <div class="booking_wrapper">
                        <div class="col-12">
                            <input type="hidden" id="date_booking" name="date_booking">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="custom_select">
                                    <select class="wide">
                                        <option>Select Room</option>
                                        <option>Double Room</option>
                                        <option>Deluxe Room</option>
                                        <option>Superior Room</option>
                                        <option>Junior Suite</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="qty-buttons mb-3 version_2">
                                            <input type="button" value="+" class="qtyplus" name="adults_booking">
                                            <input type="text" name="adults_booking" id="adults_booking" value="" class="qty form-control" placeholder="Adults">
                                            <input type="button" value="-" class="qtyminus" name="adults_booking">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3 qty-buttons mb-3 version_2">
                                            <input type="button" value="+" class="qtyplus" name="childs_booking">
                                            <input type="text" name="childs_booking" id="childs_booking" value="" class="qty form-control" placeholder="Childs">
                                            <input type="button" value="-" class="qtyminus" name="childs_booking">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / row -->
                    <p class="text-end mt-5"><a href="#0" class="btn_1 outline">Book Now</a></p>
                </div>
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</main>
@endsection

@push('scripts')
<script>
    // Progress bars animation
    $(function() {
        "use strict";
        var $section = $('#reviews');
        $(window).on('scroll', function() {
            var scrollOffset = $(window).scrollTop();
            var containerOffset = $section.offset().top - window.innerHeight;
            if (scrollOffset > containerOffset) {
                $(".progress-bar").each(function() {
                    var each_bar_width = $(this).attr('aria-valuenow');
                    $(this).width(each_bar_width + '%');
                });
            }
        });
    });
</script>
@endpush
