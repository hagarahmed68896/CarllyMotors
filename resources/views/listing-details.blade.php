        @extends('layouts.app')
        @section('content')
		<!-- #strat breadcrums-->
		<div class="car-list-details-breadcrums container">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#">Home</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						Used cars for sale
					</li>
				</ol>
			</nav>
			<hr />
		</div>

		<div class="container mt-4 listing-detail">
			<div class="row">
				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<div id="carCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @php
                                        $images = [
                                            $car->listing_img1,
                                            $car->listing_img2,
                                            $car->listing_img3,
                                            $car->listing_img4,
                                            $car->listing_img5
                                        ];
                                        $images = array_filter($images); // Remove null values
                                    @endphp

                                    @foreach ($images as $index => $image)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset(env("FILE_BASE_URL").$image) }}" class="d-block w-100" alt="Car Image">
                                            <div class="button-container">
                                                <a href="#" class="button">
                                                    <span class="button-icon">📹</span>
                                                    <span>Video</span>
                                                </a>
                                                <a href="#" class="button">
                                                    <span class="button-icon">🖼️</span>
                                                    <span>All images</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                 <a class="carousel-control-prev" href="#carCarousel" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								</a>
								<a class="carousel-control-next" href="#carCarousel" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
								</a>
							</div>
							<ul class="nav nav-tabs mt-3" id="carTabs" role="tablist">
								<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#overview" role="tab" aria-selected="true">Overview</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#specs" role="tab" aria-selected="false">Specs &amp; Features</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#recommended" role="tab" aria-selected="false">Recommended Cars</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#loan" role="tab" aria-selected="false">Loan Calculator</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab" aria-selected="false">New Car Reviews</a></li>
							</ul>
							<div class="tab-content mt-3">
								<div class="tab-pane fade active show" id="overview" role="tabpanel">
									<h5 class="mt-3">Description</h5>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
									<p>
										Nulla egestas augue vitae mollis semper. Phasellus congue neque et pulvinar gravida. Nam placerat, massa a consequat scelerisque, lacus enim mattis felis, pellentesque volutpat risus nisl et sapien.
										Proin ac elit vitae velit iaculis varius non quis massa. Nunc fringilla nulla sit amet mattis viverra. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Ut
										hendrerit non nisl auctor sollicitudin. Nunc id viverra erat, quis viverra elit.
									</p>
									<div class="file-upload-detail-list">
										<div class="file-upload-detail-list">
											<a href="#" class="listing-file-detail-btn">
												<div class="pdf-icon">PDF</div>
											 	<div class="button-text">Download brochure</div>
											</a>
										</div>
									</div>
									<div class="overview-title mt-5">Car Overview</div>
									<div class="row">
										<div class="col-md-6">
											<div class="overview-item">
												<i class="fas fa-car"></i>
												<span>Condition:</span>
												<span class="value">{{$car->car_type}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-hashtag"></i>
												<span>Stock number:</span>
												<span class="value">AB9084329457</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-barcode"></i>
												<span>VIN number:</span>
												<span class="value">{{$car->vin_number}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-calendar-alt"></i>
												<span>Year:</span>
												<span class="value">{{$car->listing_year}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-users"></i>
												<span>Seats:</span>
												<span class="value">{{$car->features_seats}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-city"></i>
												<span>City MPG:</span>
												<span class="value">20</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-road"></i>
												<span>Highway MPG:</span>
												<span class="value">24</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="overview-item">
												<i class="fas fa-cogs"></i>
												<span>Cylinders:</span>
												<span class="value">{{$car->features_cylinders}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-gas-pump"></i>
												<span>Fuel Type:</span>
												<span class="value">{{$car->features_fuel_type}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-door-closed"></i>
												<span>Doors:</span>
												<span class="value">{{$car->features_door}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-palette"></i>
												<span>Color:</span>
												<span class="value">{{$car->car_color}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-cog"></i>
												<span>Transmission:</span>
												<span class="value">{{$car->features_gear}}</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-tachometer-alt"></i>
												<span>Engine Size:</span>
												<span class="value">2.9</span>
											</div>
											<div class="overview-item">
												<i class="fas fa-car-side"></i>
												<span>Drive Type:</span>
												<span class="value">AWD – All-wheel drive</span>
											</div>
										</div>
									</div>

									<div class="features-title mt-5">Features</div>
                                    @if (!empty($car->features_others))
                                    @php
                                        // Convert the JSON string to an array
                                        $features = json_decode($car->features_others, true);
                                    @endphp
                                    @if (is_array($features) && count($features) > 0)
                                        <div class="row">
                                            @foreach (array_chunk($features, ceil(count($features) / 3)) as $column)
                                                <div class="col-md-4">
                                                    @foreach ($column as $feature)
                                                        <div class="feature-item">
                                                            <i class="fas fa-check-circle"></i>
                                                            <span>{{ trim($feature) }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No features available.</p>
                                    @endif
                                @else
                                    <p>No features available.</p>
                                @endif

									<div id="accordion" class="custom-accordion">
										<!-- Comfort & Convenience -->
										<div class="card">
											<div class="card-header accordion-header" id="headingOne">
												<h5 class="mb-0">
													<button class="btn btn-link accordion-button collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
														Comfort &amp; Convenience
														<span class="icon"><i class="fa fa-arrow-down"></i></span>
													</button>
												</h5>
											</div>
											<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
												<div class="card-body">
													<!-- Content for Comfort & Convenience -->
													Content for Comfort &amp; Convenience.
												</div>
											</div>
										</div>

										<!-- Interior -->
										<div class="card">
											<div class="card-header accordion-header" id="headingTwo">
												<h5 class="mb-0">
													<button class="btn btn-link accordion-button collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
														Interior
														<span class="icon"><i class="fa fa-arrow-down"></i></span>
													</button>
												</h5>
											</div>
											<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="">
												<div class="card-body">
													<!-- Content for Interior -->
													Content for Interior.
												</div>
											</div>
										</div>

										<!-- Exterior -->
										<div class="card">
											<div class="card-header accordion-header" id="headingThree">
												<h5 class="mb-0">
													<button class="btn btn-link accordion-button collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
														Exterior
														<span class="icon"><i class="fa fa-arrow-down"></i></span>
													</button>
												</h5>
											</div>
											<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion" style="">
												<div class="card-body">
													<!-- Content for Exterior -->
													Content for Exterior.
												</div>
											</div>
										</div>

										<!-- Safety -->
										<div class="card">
											<div class="card-header accordion-header" id="headingFour">
												<h5 class="mb-0">
													<button class="btn btn-link accordion-button collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
														Safety
														<span class="icon"><i class="fa fa-arrow-down"></i></span>
													</button>
												</h5>
											</div>
											<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion" style="">
												<div class="card-body">
													<!-- Content for Safety -->
													Content for Safety.
												</div>
											</div>
										</div>

										<!-- Entertainment & Communication -->
										<div class="card">
											<div class="card-header accordion-header" id="headingFive">
												<h5 class="mb-0">
													<button class="btn btn-link accordion-button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
														Entertainment &amp; Communication
														<span class="icon rotate"><i class="fa fa-arrow-down"></i></span>
													</button>
												</h5>
											</div>
											<div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordion" style="">
												<div class="card-body">
													<!-- Content for Entertainment & Communication -->
													Content for Entertainment &amp; Communication.
												</div>
											</div>
										</div>
									</div>

									<div class="calculator-container">
										<h1>Auto Loan Calculator</h1>
										<p>Use our calculator to estimate your monthly car payments.</p>

										<!-- Form Section -->
										<form>
											<div class="form-group">
												<label for="totalPrice">Total Price</label>
												<input type="number" class="form-control" id="totalPrice" placeholder="$" />
											</div>

											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="downPayment">Down payment</label>
													<input type="text" class="form-control" id="downPayment" placeholder="0%" />
												</div>
												<div class="form-group col-md-6">
													<label for="terms">Terms</label>
													<select id="terms" class="custom-select">
														<option selected="">12 months</option>
														<option>24 months</option>
														<option>36 months</option>
														<option>48 months</option>
													</select>
												</div>
											</div>

											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="interestRate">Interest rate</label>
													<input type="number" class="form-control" id="interestRate" placeholder="1.3" />
												</div>
												<div class="form-group col-md-6">
													<label for="paymentFrequency">Payment Frequency</label>
													<select id="paymentFrequency" class="custom-select">
														<option selected="">Monthly</option>
														<option>Bi-weekly</option>
														<option>Weekly</option>
													</select>
												</div>
											</div>
										</form>

										<!-- Results Section -->
										<div class="result-section">
											<p>Down payment amount <span id="downPaymentAmount">$0</span></p>
											<p>Amount financed <span id="amountFinanced">$600.00</span></p>
											<p>Monthly payment <span class="result-highlight" id="monthlyPayment">$60.00</span></p>
										</div>

										<!-- Apply Button -->
										<button class="btn btn-primary btn-block">Apply for a loan</button>
									</div>

									<div class="listing-overview-location mt-5 mb-3">
										<h1>Location</h1>
										<ul class="mb-3">
											<li><i class="fa fa-map-marker-alt"></i>2972 Westheimer Rd. Santa Ana, Illinois 85486</li>
										</ul>
										<iframe
											class="w-100"
											src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3464.226141639047!2d-95.42471662500128!3d29.74216773283025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c0e92e0628c9%3A0xcffbb134c76ad5bf!2skreative%20Solutions!5e0!3m2!1sen!2s!4v1737483148385!5m2!1sen!2s"
											height="450"
											style="border:0;"
											allowfullscreen=""
											loading="lazy"
											referrerpolicy="no-referrer-when-downgrade"
										></iframe>
									</div>

									<h2 class="mt-5">Car User Reviews &amp; Rating</h2>

									<!-- Rating Summary -->
									<div class="d-flex align-items-center">
										<span class="rating"><i class="fas fa-star"></i> <strong>4.8</strong></span>
										<p class="ml-3 mb-0">
											Overall Rating <br />
											<small>Base on <strong>372 Reviews</strong></small>
										</p>
									</div>

									<!-- Tabs -->
									<ul class="nav nav-tabs mt-3" id="reviewTabs">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#all">All</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#mileage">Mileage</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#performance">Performance</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#safety">Safety</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#looks">Looks</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#comfort">Comfort</a>
										</li>
									</ul>

									<!-- Tab Content -->
									<div class="tab-content mt-3 px-0">
										<!-- All Reviews -->
										<div class="tab-pane fade show active" id="all">
											<h5>372 Rating and Reviews</h5>
											<div class="review-card mt-3">
												<div class="d-flex align-items-center rating-reviews-list">
													<div class="profile-circle mr-3"></div>
													<div>
														<h6 class="mb-0">Leslie Alexander</h6>
														<span class="rating">
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
														</span>
													</div>
													<small class="ml-auto text-muted">August 13, 2023</small>
												</div>
												<p class="mt-2">
													It's really easy to use and it is exactly what I am looking for. A lot of good looking templates &amp; it's highly customizable. Live support is helpful, solved my issue in no time.
												</p>
												<div class="mt-2">
													<div class="gray-box"></div>
													<div class="gray-box"></div>
													<div class="gray-box"></div>
												</div>
												<div class="mt-3">
													<p>
														Is this review helpful?
														<button class="btn btn-sm btn-outline-secondary ml-2">Yes</button>
														<button class="btn btn-sm btn-outline-secondary ml-1">No</button>
													</p>
												</div>
											</div>
											<div class="review-card mt-3">
												<div class="d-flex align-items-center rating-reviews-list">
													<div class="profile-circle mr-3"></div>
													<div>
														<h6 class="mb-0">Leslie Alexander</h6>
														<span class="rating">
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
														</span>
													</div>
													<small class="ml-auto text-muted">August 13, 2023</small>
												</div>
												<p class="mt-2">
													It's really easy to use and it is exactly what I am looking for. A lot of good looking templates &amp; it's highly customizable. Live support is helpful, solved my issue in no time.
												</p>
												<div class="mt-2">
													<div class="gray-box"></div>
													<div class="gray-box"></div>
													<div class="gray-box"></div>
												</div>
												<div class="mt-3">
													<p>
														Is this review helpful?
														<button class="btn btn-sm btn-outline-secondary ml-2">Yes</button>
														<button class="btn btn-sm btn-outline-secondary ml-1">No</button>
													</p>
												</div>
											</div>
											<a href="#" class="view-more-review">
												View more reviews
												<i class="fas fa-chevron-down"></i>
											</a>
											<div class="comment-form p-4 border rounded">
												<h4 class="mb-3">Leave a Reply</h4>
												<p class="text-muted">Your email address will not be published</p>
												<form class="review-post-comment">
													<div class="form-row">
														<div class="form-group col-md-6">
															<label for="name">Name</label>
															<input type="text" class="form-control" id="name" placeholder="Your name" />
														</div>
														<div class="form-group col-md-6">
															<label for="email">Email address</label>
															<input type="email" class="form-control" id="email" placeholder="Your email" />
														</div>
													</div>
													<div class="form-check mb-3">
														<input type="checkbox" class="form-check-input" id="saveInfo" />
														<label class="form-check-label" for="saveInfo">Save your name, email for the next time review</label>
													</div>
													<div class="form-group">
														<label for="message">Review</label>
														<textarea class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
													</div>
													<button type="submit" class="btn btn-orange btn-block">Post Comment</button>
												</form>
											</div>
										</div>

										<!-- Other Tabs (Example Placeholder) -->
										<div class="tab-pane fade" id="mileage">
											<h5>Mileage Reviews</h5>
											<p>No reviews yet.</p>
										</div>
										<div class="tab-pane fade" id="performance">
											<h5>Performance Reviews</h5>
											<p>No reviews yet.</p>
										</div>
										<div class="tab-pane fade" id="safety">
											<h5>Safety Reviews</h5>
											<p>No reviews yet.</p>
										</div>
										<div class="tab-pane fade" id="looks">
											<h5>Looks Reviews</h5>
											<p>No reviews yet.</p>
										</div>
										<div class="tab-pane fade" id="comfort">
											<h5>Comfort Reviews</h5>
											<p>No reviews yet.</p>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="specs" role="tabpanel">Specs &amp; Features content goes here...</div>
								<div class="tab-pane fade" id="recommended" role="tabpanel">Recommended Cars content goes here...</div>
								<div class="tab-pane fade" id="loan" role="tabpanel">Loan Calculator content goes here...</div>
								<div class="tab-pane fade" id="reviews" role="tabpanel">New Car Reviews content goes here...</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="right-listing-detail-section">
						<!-- Car Details Section -->
						<div class="card">
							<h4 class="mb-2">{{$car->listing_model}}</h4>
							<p class="text-muted mb-4"><i class="fas fa-road"></i> {{$car->features_speed}} kms &nbsp; <i class="fas fa-gas-pump"></i> {{$car->features_fuel_type}} &nbsp; <i class="fas fa-cogs"></i> {{$car->features_gaer}} &nbsp; <i class="fas fa-user"></i>{{$car->user->fname}}{{$car->user->lname}}</p>
							<p class="price">${{$car->listing_price}}</p>
							<p class="text-muted">Monthly installment payment: $4,000</p>
							<p class="text-muted">New car price: $100,000</p>
							<div class="icon-group mt-3">
								<button class="btn btn-outline-secondary"><i class="fas fa-heart"></i></button>
								<button class="btn btn-outline-secondary"><i class="fas fa-random"></i></button>
								<button class="btn btn-outline-secondary"><i class="fas fa-share"></i></button>
							</div>
						</div>

						<!-- Dealer Details Section -->
						<div class="card">
							<div class="d-flex align-items-center mb-3">
								<div class="rounded-circle bg-light" style="width: 60px; height: 60px;"><img src="{{env('FILE_BASE_URL'.$car->user->image)}}" alt="User-Image"></div>
								<div class="ml-3">
									<h6 class="">Car Empire</h6>
									<span class="verified-badge">Verified dealer</span>
								</div>
							</div>
							<p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{$car->user->location}}</p>
							<div class="bg-light rounded mb-3" style="height: 100px;"></div>
							<h6 class="mb-3">Contact dealer</h6>
							<div class="d-flex justify-content-between">
								<a href="tel:{{$car->user->phone}}"><button class="contact-btn btn-call">{{$car->user->phone}}</button></a>
								<button class="contact-btn btn-chat">Chat</button>
							</div>
						</div>
					</div>

					<div class="report-list-car-right">
						<ul>
							<li>
								<a href="#"><i class="fa fa-light fa-flag"></i>Report this listing</a>
							</li>
						</ul>
					</div>
					<div class="container my-4 recmended-used-car-section px-0">
                        <!-- Recommended Cars Section -->
                        <div class="card">
                            <h5>Recommended Used Cars</h5>
                            <p class="text-muted">Showing {{ count($recommendedCars) }} more cars you might like</p>
                            <ul class="car-list">
                                @foreach ($recommendedCars as $recommendedCar)
                                    <li class="car-list-item">
                                        <div class="car-image">
                                            <!-- Display the car image -->
                                            <img src="{{ env('FILE_BASE_URL') . $recommendedCar->listing_img1 }}" alt="Car Image" class="img-fluid">
                                        </div>
                                        <div class="text-list-para">
                                            <p class="car-title">{{$recommendedCar->listing_year}} {{ $recommendedCar->listing_type }} {{ $recommendedCar->listing_model }}</p>
                                            <p class="car-price">${{ number_format($recommendedCar->listing_price) }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="view-more">
                                <a href="#">View more reviews <i class="fas fa-chevron-down"></i></a>
                            </div>
                        </div>

				</div>
			</div>
			</div>
		</div>
        @endsection

