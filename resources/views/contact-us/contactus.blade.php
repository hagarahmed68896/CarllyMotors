@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #fafbfb;
    }

    /* ===== Hero Banner ===== */
    .contact-hero {
        background: linear-gradient(to right, #5a0b0f, #8a1c20);
        color: white;
        padding: 80px 20px;
        text-align: center;
    }

    .contact-hero h1 {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .contact-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* ===== Contact Card ===== */
    .contact-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        padding: 40px;
        margin-top: -60px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 15px;
    }

    .btn-custom {
        background: #5a0b0f;
        color: #fff;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: #8a1c20;
        color: #fff;
    }

    .btn-whatsapp {
        background-color: #25D366;
        color: #fff;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-whatsapp:hover {
        background-color: #1ebe57;
        color: #fff;
    }

    /* Breadcrumb links */
    .breadcrumb-item a {
        color: #5a0b0f;
        text-decoration: none;
        font-weight: 600;
    }

    .breadcrumb-item a:hover {
        color: #8a1c20;
        text-decoration: none;
    }
</style>

<!-- ===== Hero Section ===== -->
<div class="contact-hero mb-4">
    <h1>Contact Us</h1>
    <p>We’d love to hear from you! Send us your message or reach us directly via WhatsApp.</p>
</div>



<!-- ===== Contact Form ===== -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="contact-card">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="subject" class="form-label">Your Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                      <div class="col-md-6">
  <label for="phone" class="form-label">Your Phone</label>
  <div class="input-group">
    <span class="input-group-text bg-light text-muted fw-semibold border-end-0">+971</span>
    <input type="tel" 
           class="form-control border-start-0" 
           id="phone" 
           name="phone"
           placeholder="5XXXXXXXX"
           pattern="[0-9]{9}" 
           maxlength="9"
           required>
  </div>
</div>

<style>
/* ✅ Optional styling for cleaner look */
.input-group-text {
  border-radius: 8px 0 0 8px !important;
}

.form-control {
  border-radius: 0 8px 8px 0 !important;
}

@media (max-width: 576px) {
  .input-group-text, 
  .form-control {
    font-size: 0.95rem;
  }
}
</style>

                        <div class="col-12">
                            <label for="body" class="form-label">Your Message</label>
                            <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
                        </div>
                    </div>
<!-- ✅ Buttons Section (Stay in one line on all screens) -->
<div class="action-buttons d-flex justify-content-between align-items-center mt-4 flex-nowrap">
  <a href="https://wa.me/971566350025" 
     class="btn btn-whatsapp d-flex justify-content-center align-items-center py-2 px-3 flex-fill me-2">
    <i class="fab fa-whatsapp me-2"></i> WhatsApp
  </a>

  <button type="submit" 
          class="btn btn-custom py-2 px-3 flex-fill ms-2">
    Send Message
  </button>
</div>

<style>
/* ✅ WhatsApp Button */
.btn-whatsapp {
  background-color: #25D366;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  transition: 0.3s;
  white-space: nowrap; /* prevent text from wrapping */
}
.btn-whatsapp:hover {
  background-color: #1eb85b;
  color: #fff;
}

/* ✅ Custom Button */
.btn-custom {
  background-color: #760e13;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  transition: 0.3s;
  white-space: nowrap;
}
.btn-custom:hover {
  background-color: #5b0b0f;
  color: #fff;
}

/* ✅ Responsive behavior (no wrapping) */
.action-buttons {
  overflow-x: auto; /* allows horizontal scroll if too narrow */
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none; /* hide scrollbar for modern browsers */
}
.action-buttons::-webkit-scrollbar {
  display: none; /* hide scrollbar for Safari/Chrome */
}

/* Optional: Make buttons scale slightly smaller on very narrow screens */
@media (max-width: 400px) {
  .action-buttons .btn {
    font-size: 0.9rem;
    padding: 0.5rem 0.8rem;
  }
}
</style>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
