@extends('layouts.app')

@section('title', 'Contact_Us')

@section('content')

@include('layouts.partials.header')
@include('layouts.partials.sidebar')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<main id="main" class="main">
    @include('layouts.partials.breadcrums')
    @include('layouts.partials.alerts')

    <section class="section dashboard">
        <div class="container-fluid px-0">
            <div class="mb-4 site-banner d-flex align-items-center justify-content-center" style="height:620px; width: 100%; background: url('{{ asset('assets/img/contactimage.png') }}') center center / cover no-repeat;
         border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
            </div>
        </div>


        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 card h-100 shadow-lg border-0" style="background: linear-gradient(to right, #f8f9fa, #e3f2fd);">
                    <h4 class="mb-4 text-primary fw-bold">📍 Meet Us</h4>

                    <div class="mb-3 d-flex align-items-center text-dark">
                        <i class="bi bi-telephone-fill me-3 fs-5 text-success"></i>
                        <span class="fw-medium">+91-7742715000</span>
                    </div>

                    <div class="mb-3 d-flex align-items-center text-dark">
                        <i class="bi bi-envelope-fill me-3 fs-5 text-danger"></i>
                        <a href="mailto:admin@visionworldtech.com" class="text-decoration-none fw-medium text-dark">
                            admin@visionworldtech.com
                        </a>
                    </div>

                    <div class="mb-3 d-flex align-items-center text-dark">
                        <i class="bi bi-globe2 me-3 fs-5 text-primary"></i>
                        <a href="https://www.visionworldtech.com" target="_blank" class="text-decoration-none fw-medium text-dark">
                            www.visionworldtech.com
                        </a>
                    </div>

                    <div class="d-flex align-items-start text-dark">
                        <i class="bi bi-geo-alt-fill me-3 fs-5 text-warning"></i>
                        <span class="fw-medium">A-15 Jai Ambey Nagar in front of Jaipur Hospital,<br>
                            Tonk Road, Jaipur, Rajasthan 302018</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 card h-100 shadow-lg border-0" style="background: linear-gradient(135deg, #f9f7fe 0%, #d0e8f2 100%);">
                    <form method="get" action="">
                        @csrf
                        <h4 class="mb-4 text-primary fw-bold">📬 Contact Us</h4>

                        <div class="mb-3">
                            <input type="text" class="form-control border-0 shadow-sm" placeholder="Name" name="name" required style="background-color: #ffffffcc; transition: box-shadow 0.3s ease;">
                        </div>

                        <div class="mb-3">
                            <textarea rows="4" class="form-control border-0 shadow-sm" placeholder="Message" name="message" required style="background-color: #ffffffcc; transition: box-shadow 0.3s ease;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-gradient w-100 fw-semibold" style="
                background: linear-gradient(45deg, #667eea, #764ba2);
                border: none;
                color: white;
                padding: 0.5rem 1.5rem;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(102,126,234,0.4);
                transition: background 0.3s ease;
            ">
                            Send
                        </button>
                    </form>
                </div>
            </div>
            <style>
                .form-control:focus {
                    box-shadow: 0 0 8px rgba(118, 75, 162, 0.7);
                    background-color: #fff !important;
                    border-color: #764ba2 !important;
                    outline: none;
                }

                .btn-gradient:hover {
                    background: linear-gradient(45deg, #764ba2, #667eea);
                    box-shadow: 0 6px 20px rgba(118, 75, 162, 0.7);
                }

            </style>
        </div>
        </div>
        </div>
    </section>
</main>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Map Script -->
@include('layouts.partials.footer')

@endsection
