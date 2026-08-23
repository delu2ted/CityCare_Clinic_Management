<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CityCare Medical Centre</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero {
            background:
                linear-gradient(135deg, rgba(81,60,115,0.85) 0%, rgba(118,87,171,0.85) 55%, rgba(176,141,192,0.85) 100%),
                url('{{ asset('images/landing-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 5rem 0;
        }
        .site-nav {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
        }
        .section-title {
            font-weight: 700;
            color: #495057;
        }
        .dept-card, .doctor-card {
            border: 1px solid #e9ecef;
            border-radius: .75rem;
            padding: 1.5rem;
            height: 100%;
            transition: box-shadow .15s, border-color .15s;
        }
        .dept-card:hover, .doctor-card:hover {
            border-color: #d172e9;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        footer {
            background: #34324a;
            color: #cfcbe0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg site-nav sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:32px;" onerror="this.style.display='none'">
                CityCare Medical Centre
            </a>
            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">Log In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Book Appointment</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Compassionate Care, Close to Home</h1>
            <p class="lead mb-4">CityCare Medical Centre brings together experienced doctors, modern facilities, and a patient-first approach — so you and your family always have somewhere trusted to turn.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Book an Appointment</a>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                    <h2 class="section-title mb-3">Our Mission</h2>
                    <p class="text-muted">
                        To provide accessible, high-quality healthcare to every patient who walks through our doors — combining modern medical practice with genuine, personal attention. We believe good healthcare starts with being seen, heard, and cared for.
                    </p>
                </div>
                <div class="col-md-6">
                    <h2 class="section-title mb-3">Why CityCare?</h2>
                    <ul class="text-muted">
                        <li>Experienced doctors across multiple specializations</li>
                        <li>Simple online appointment booking</li>
                        <li>Transparent billing and payment tracking</li>
                        <li>Digital medical records — no more lost paper files</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-4">Our Departments</h2>
            <div class="row g-4">
                @forelse($departments ?? [] as $dept)
                    <div class="col-md-4">
                        <div class="dept-card">
                            <h5>{{ $dept->name }}</h5>
                            <p class="text-muted small mb-0">{{ $dept->description ?? 'Quality care from our specialist team.' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-md-4">
                        <div class="dept-card"><h5>General Medicine</h5><p class="text-muted small mb-0">Everyday health concerns and checkups.</p></div>
                    </div>
                    <div class="col-md-4">
                        <div class="dept-card"><h5>Pediatrics</h5><p class="text-muted small mb-0">Dedicated care for infants, children, and teens.</p></div>
                    </div>
                    <div class="col-md-4">
                        <div class="dept-card"><h5>Cardiology</h5><p class="text-muted small mb-0">Heart health screening and treatment.</p></div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center mb-4">Meet Our Doctors</h2>
            <div class="row g-4">
                @forelse($doctors ?? [] as $doc)
                    <div class="col-md-4">
                        <div class="doctor-card text-center">
                            <img src="{{ asset('images/doctor-placeholder.png') }}" alt="Doctor" class="rounded-circle mb-2" style="width:64px;height:64px;object-fit:cover;" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($doc->user->name ?? 'Doctor') }}&background=d8b4e2&color=513c73&size=128'">
                            <h6 class="mb-1">{{ $doc->user->name ?? 'Doctor' }}</h6>
                            <p class="text-muted small mb-0">{{ $doc->specialization }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">Our doctor profiles will appear here soon.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <h2 class="section-title mb-3">Visit Us</h2>
                    <p class="text-muted mb-1">📍 KG 123 St, Kigali, Rwanda</p>
                    <p class="text-muted mb-1">🕗 Mon – Sat: 8:00 AM – 5:00 PM</p>
                    <p class="text-muted mb-0">☎️ +250 788 000 000</p>
                </div>

                <div class="col-md-6">
                    <h2 class="section-title mb-3">Get in Touch</h2>
                    <p class="text-muted mb-3">✉️ info@citycareclinic.test — or send us a message directly:</p>

                    @if(session('contact_sent'))
                        <div class="alert alert-success">Thank you! Your message has been sent.</div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="mb-2">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="mb-2">
                            <textarea name="message" class="form-control" rows="3" placeholder="Your message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Send Message</button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <footer class="py-4 text-center small">
        <div class="container">
            &copy; {{ date('Y') }} CityCare Medical Centre. All rights reserved.
        </div>
    </footer>

</body>
</html>