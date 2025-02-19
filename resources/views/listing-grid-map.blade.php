{{-- <html lang="en"><head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carlly Motors Grid Map</title>
<link rel="icon" type="image/png" href="images/carlly-favi-icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="css/listing-detail.css">
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
          <!-- Logo -->
          <a class="navbar-brand" href="#">
              <img src="https://carllymotors.com/wp-content/uploads/2024/04/carllymotors_logo_white-1024x263.png.webp" alt="AutoDecar">
          </a>

          <!-- Mobile Toggle Button -->
          <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-expanded="false">
              <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Navbar Links -->
          <div class="navbar-collapse collapse" id="navbarNav" style="">
              <ul class="navbar-nav mx-auto">
                  <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">New cars</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Used car</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">New, review &amp; videos</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Page ▼</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
              </ul>

              <!-- Icons & Buttons -->
              <div class="d-flex align-items-center right-sidebar-nav">
                  <a href="#"> <i class="search-icon fas fa-search"></i> </a>
                  <a href="#"> <i class="fav-icon fas fa-heart"></i> </a>
                  <a href="#"> <i class="login-icon fas fa-user"></i> </a>
                  <a class="nav-link login-nav" href="#">Login / Register</a>
                  <a href="#" class="btn btn-add-listing">Add listing</a>
              </div>
          </div>
      </div>
  </nav> --}}
  @extends('layouts.app')

  @section('content')

<!-- map-view-grid carousuol-->
<div class="container-fluid">
  <div class="row">
      <div class="col-sm-8">
          <div class="grid-view-filter py-3">
              <div class="container d-flex align-items-center justify-content-between under-view-filter-sec">
                <!-- Title -->
                <h4 class="mb-0">Used cars for sale</h4>

                <!-- Controls -->
                <div class="d-flex align-items-center">
                  <!-- View Toggle Buttons -->
                  <div class="btn-group mr-3" role="group">
                    <button type="button" class="btn btn-outline-secondary" aria-label="Grid View">
                      <i class="fas fa-th"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" aria-label="List View">
                      <i class="fas fa-bars"></i>
                    </button>
                  </div>

                  <!-- Sort Dropdown -->
                  <div class="form-group position-relative mr-3" style="
  margin: 0;
">
<label for="sortSelect" class="sr-only">Sort by</label>
<select class="form-control custom-select with-dropdown-icon" id="sortSelect">
  <option selected="">Sort by (Default)</option>
  <option value="lowToHigh">Price: Low to High</option>
  <option value="highToLow">Price: High to Low</option>
  <option value="newest">Newest First</option>
</select>
<i class="fas fa-chevron-down dropdown-icon"></i>
</div>

                  <!-- Filter Button -->
                  <button type="button" class="btn btn-orange">
                    <i class="fas fa-sliders-h"></i> Filter
                  </button>
                </div>
              </div>
            </div>


          <div class="map-view-grid-carousul">
              <div class="container">
                <div class="row">
                  <!-- Card 1 -->
                  <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                      <div class="card-header position-relative p-0">
                        <div class="badge badge-warning position-absolute" style="top: 10px;left: 10px;z-index: 1;">Featured</div>
                        <div class="badge badge-orange position-absolute" style="top: 10px;right: 10px;z-index: 1;">2024</div>
                        <div id="carousel1" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="carousel-item active">
                              <img src="https://carllymotors.com/demo/images/ford.jpg" class="d-block w-100" alt="Car Image 1">
                            </div>
                            <div class="carousel-item">
                              <img src="https://carllymotors.com/demo/images/ford.jpg" class="d-block w-100" alt="Car Image 2">
                            </div>
                            <div class="carousel-item">
                              <img src="https://carllymotors.com/demo/images/ford.jpg" class="d-block w-100" alt="Car Image 3">
                            </div>
                          </div>
                          <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                      </div>
                      <div class="card-body">
                        <p class="text-muted mb-1">Sedan</p>
                        <h5 class="card-title mb-1">2017 BMV X1 xDrive 20d xline</h5>
                        <p class="middle-carmeter-list" style="
      font-size: 12px;
      color: #000;
  "><i class="fas fa-tachometer-alt"></i> 50,000 kms | <i class="fas fa-gas-pump fa-2x"></i>Petrol <i class="fas fa-cogs fa-2x"></i>Automatic</p>
                        <h6 class="text-orange font-weight-bold">$73,000</h6>
                      </div>
                      <div class="card-footer d-flex align-items-center justify-content-between bg-white">
                        <div class="d-flex align-items-center">
                          <span class="rounded-circle bg-light" style="width: 30px; height: 30px;"></span>
                          <span class="ml-2">Kathryn Murphy</span>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm">View car</a>
                      </div>
                    </div>
                  </div>
                  <!-- Card 2 (Duplicate for demonstration) -->
                  <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                      <div class="card-header position-relative p-0">
                        <div class="badge badge-warning position-absolute" style="top: 10px;left: 10px;z-index: 1;">Featured</div>
                        <div class="badge badge-orange position-absolute" style="top: 10px;right: 10px;z-index: 1;">2024</div>
                        <div id="carousel2" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="carousel-item active">
                              <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 1">
                            </div>
                            <div class="carousel-item">
                              <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 2">
                            </div>
                            <div class="carousel-item">
                              <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 3">
                            </div>
                          </div>
                          <a class="carousel-control-prev" href="#carousel2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carousel2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                      </div>
                      <div class="card-body">
                        <p class="text-muted mb-1">Sedan</p>
                        <h5 class="card-title mb-1">2017 BMV X1 xDrive 20d xline</h5>
                        <p class="middle-carmeter-list" style="
      font-size: 12px;
      color: #000;
  "><i class="fas fa-tachometer-alt"></i> 50,000 kms | <i class="fas fa-gas-pump fa-2x"></i>Petrol <i class="fas fa-cogs fa-2x"></i>Automatic</p>
                        <h6 class="text-orange font-weight-bold">$73,000</h6>
                      </div>
                      <div class="card-footer d-flex align-items-center justify-content-between bg-white">
                        <div class="d-flex align-items-center">
                          <span class="rounded-circle bg-light" style="width: 30px; height: 30px;"></span>
                          <span class="ml-2">Kathryn Murphy</span>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm">View car</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
      <div class="map-view-grid-carousul">
              <div class="container">
                <div class="row">
                  <!-- Card 1 -->
                  <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                      <div class="card-header position-relative p-0">
                        <div class="badge badge-warning position-absolute" style="top: 10px;left: 10px;z-index: 1;">Featured</div>
                        <div class="badge badge-orange position-absolute" style="top: 10px;right: 10px;z-index: 1;">2024</div>
                        <div id="carousel1" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="carousel-item">
                              <img src="https://carllymotors.com/demo/images/ford.jpg" class="d-block w-100" alt="Car Image 1">
                            </div>
                            <div class="carousel-item">
                              <img src="https://carllymotors.com/demo/images/ford.jpg" class="d-block w-100" alt="Car Image 2">
                            </div>
                            <div class="carousel-item active">
                              <img src="https://carllymotors.com/demo/images/ford.jpg" class="d-block w-100" alt="Car Image 3">
                            </div>
                          </div>
                          <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                      </div>
                      <div class="card-body">
                        <p class="text-muted mb-1">Sedan</p>
                        <h5 class="card-title mb-1">2017 BMV X1 xDrive 20d xline</h5>
                        <p class="middle-carmeter-list" style="
      font-size: 12px;
      color: #000;
  "><i class="fas fa-tachometer-alt"></i> 50,000 kms | <i class="fas fa-gas-pump fa-2x"></i>Petrol <i class="fas fa-cogs fa-2x"></i>Automatic</p>
                        <h6 class="text-orange font-weight-bold">$73,000</h6>
                      </div>
                      <div class="card-footer d-flex align-items-center justify-content-between bg-white">
                        <div class="d-flex align-items-center">
                          <span class="rounded-circle bg-light" style="width: 30px; height: 30px;"></span>
                          <span class="ml-2">Kathryn Murphy</span>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm">View car</a>
                      </div>
                    </div>
                  </div>
                  <!-- Card 2 (Duplicate for demonstration) -->
                  <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                      <div class="card-header position-relative p-0">
                        <div class="badge badge-warning position-absolute" style="top: 10px;left: 10px;z-index: 1;">Featured</div>
                        <div class="badge badge-orange position-absolute" style="top: 10px;right: 10px;z-index: 1;">2024</div>
                        <div id="carousel2" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="carousel-item">
                              <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 1">
                            </div>
                            <div class="carousel-item active">
                              <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 2">
                            </div>
                            <div class="carousel-item">
                              <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 3">
                            </div>
                          </div>
                          <a class="carousel-control-prev" href="#carousel2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carousel2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                      </div>
                      <div class="card-body">
                        <p class="text-muted mb-1">Sedan</p>
                        <h5 class="card-title mb-1">2017 BMV X1 xDrive 20d xline</h5>
                        <p class="middle-carmeter-list" style="
      font-size: 12px;
      color: #000;
  "><i class="fas fa-tachometer-alt"></i> 50,000 kms | <i class="fas fa-gas-pump fa-2x"></i>Petrol <i class="fas fa-cogs fa-2x"></i>Automatic</p>
                        <h6 class="text-orange font-weight-bold">$73,000</h6>
                      </div>
                      <div class="card-footer d-flex align-items-center justify-content-between bg-white">
                        <div class="d-flex align-items-center">
                          <span class="rounded-circle bg-light" style="width: 30px; height: 30px;"></span>
                          <span class="ml-2">Kathryn Murphy</span>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm">View car</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div></div>
      <div class="col-sm-4 position-relative d-flex align-items-center map-view-grid-carousul" style="
  display: flex;
  align-items: center;
">
<div class="bg-main-marker-icon position-relative">
<!-- Background Markers -->
<div class="bg-marker"></div>
<div class="bg-marker"></div>
<div class="bg-marker"></div>
<div class="bg-marker"></div>
<div class="bg-marker"></div>
<div class="bg-marker"></div>
<div class="bg-marker"></div>
</div>

<!-- Card -->
<div class="card mb-4 shadow-sm position-relative right-card-car-view-grid">
  <div class="card-header position-relative p-0">
    <div class="badge badge-warning position-absolute" style="top: 10px; left: 10px; z-index: 1;">Featured</div>
    <div class="badge badge-orange position-absolute" style="top: 10px; right: 10px; z-index: 1;">2024</div>
    <div id="carousel2" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item">
          <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 1">
        </div>
        <div class="carousel-item active">
          <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 2">
        </div>
        <div class="carousel-item">
          <img src="https://carllymotors.com/demo/images/nisan.jpg" class="d-block w-100" alt="Car Image 3">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carousel2" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carousel2" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
  <div class="card-body">
    <p class="text-muted mb-1">Sedan</p>
    <h5 class="card-title mb-1">2017 BMV X1 xDrive 20d xline</h5>
    <p class="middle-carmeter-list" style="
      font-size: 12px;
      color: #000;
  "><i class="fas fa-tachometer-alt"></i> 50,000 kms | <i class="fas fa-gas-pump fa-2x"></i>Petrol <i class="fas fa-cogs fa-2x"></i>Automatic</p>
    <h6 class="text-orange font-weight-bold">$73,000</h6>
  </div>
  <div class="card-footer d-flex align-items-center justify-content-between bg-white">
    <div class="d-flex align-items-center">
      <span class="rounded-circle bg-light" style="width: 30px; height: 30px;"></span>
      <span class="ml-2">Kathryn Murphy</span>
    </div>
    <a href="#" class="btn btn-outline-primary btn-sm">View car</a>
  </div>
</div>
</div>

  </div>
</div>





<!-- end carousul-->



      <footer class="footer">
		<div class="container">
			<!-- Top Icons -->
			<div class="row text-center">
				<div class="col-md-3 icon-box">
					<div class="row align-items-center">
						<div class="col-sm-3">
							<i class="fas fa-trophy"></i>
						</div>
						<div class="col-sm-9">
							<h6>Top 1 Americas</h6>
							<p>Largest Auto portal</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 icon-box">
					<div class="row align-items-center">
						<div class="col-sm-3">
							<i class="fas fa-car"></i>
						</div>
						<div class="col-sm-9">
							<h6>Car Sold</h6>
							<p>Every 5 minutes</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 icon-box">
					<div class="row align-items-center">
						<div class="col-sm-3">
							<i class="fas fa-tags"></i>
						</div>
						<div class="col-sm-9">
							<h6>Offers</h6>
							<p>Stay updated, pay less</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 icon-box">
					<div class="row align-items-center">
						<div class="col-sm-3">
							<i class="fas fa-balance-scale"></i>
						</div>
						<div class="col-sm-9">
							<h6>Compare</h6>
							<p>Decode the right car</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Footer Links -->
			<div class="row footer-links">
				<div class="col-md-3">
					<h5>About Auto Decar</h5>
					<ul>
						<li><a href="#">About us</a></li>
						<li><a href="#">Careers With Us</a></li>
						<li><a href="#">Terms &amp; Conditions</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Corporate Policies</a></li>
						<li><a href="#">Investors</a></li>
						<li><a href="#">FAQs</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>Popular Used Cars</h5>
					<ul>
						<li><a href="#">Chevrolet</a></li>
						<li><a href="#">Ford</a></li>
						<li><a href="#">Toyota</a></li>
						<li><a href="#">Tesla</a></li>
						<li><a href="#">Honda</a></li>
						<li><a href="#">Nissan</a></li>
						<li><a href="#">Hyundai</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>Other</h5>
					<ul>
						<li><a href="#">Terms and Conditions</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Copyrights</a></li>
						<li><a href="#">Help center</a></li>
						<li><a href="#">How it works</a></li>
						<li><a href="#">Car sales trends</a></li>
						<li><a href="#">Personal loan</a></li>
					</ul>
				</div>
				<div class="col-md-3 newsletter">
					<h5>Newsletter</h5>
					<p>Stay on top of the latest car trends, tips, and tricks for selling your car.</p>
					<input type="email" placeholder="Your email address" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpiYmZkZTQxOS00ZGRkLWU5NDYtOWQ2MC05OGExNGJiMTA3N2YiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDAyNDkwMkRDOTIyMTFFNkI0MzFGRTk2RjM1OTdENTciIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDAyNDkwMkNDOTIyMTFFNkI0MzFGRTk2RjM1OTdENTciIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OTU2NTE1NDItMmIzOC1kZjRkLTk0N2UtN2NjOTlmMjQ5ZGFjIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOmJiZmRlNDE5LTRkZGQtZTk0Ni05ZDYwLTk4YTE0YmIxMDc3ZiIv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&quot;) !important; background-repeat: no-repeat; background-size: 20px; background-position: 97% center; cursor: auto;" data-temp-mail-org="0">
					<div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
					<button class="btn btn-send">Send</button>
				</div>
			</div>

			<!-- Footer Bottom -->
			<div class="footer-bottom mt-4">
				<div class="row">
					<div class="col-md-6 text-left">
						<a href="#" class="footer-logo">
							<img src="https://carllymotors.com/wp-content/uploads/2024/04/carllymotors_logo_white-1024x263.png.webp" alt="AutoDecar">
						</a>

					</div>
					<div class="col-md-6 text-right social-icons footer-social-sec" style="display: flex;justify-content: end;flex-flow: row-reverse;align-items: center;">

						<a href="#"><i class="fab fa-facebook"></i></a>
						<a href="#"><i class="fab fa-linkedin"></i></a>

						<a href="#"><i class="fab fa-instagram"></i></a>
						<a href="#"><i class="fab fa-youtube"></i></a>
					<p class="mt-2" style="
margin-right: 26px;
margin-bottom: 6px;
">© 2025 Carlly Motors. All rights reserved</p></div>
				</div>
			</div>
		</div>
	</footer>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


@endsection

{{-- </body></html> --}}
