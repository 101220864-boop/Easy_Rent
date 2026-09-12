<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyRent - Home</title>
    <style>
        /* General Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
        }

        /* 1. Navbar Styles */
        .navbar {
            background-color: #333;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo a {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .nav-links {
            list-style: none;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 25px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: #28a745;
        }
        .logout-btn {
            background: none;
            border: none;
            color: #ff6b6b;
            font-weight: 500;
            font-size: 1rem;
            font-family: inherit;
            cursor: pointer;
            transition: color 0.3s;
            padding: 0;
        }
        .logout-btn:hover {
            color: #ff4747;
        }

        /* 2. Hero Section - Simple & Beautiful */
        .hero {
            position: relative;
            height: 65vh; 
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1500') no-repeat center center/cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            padding: 0 20px;
        }

        .hero h1 { 
            font-size: 3rem; 
            margin-bottom: 15px; 
            font-weight: bold;
        }

        /* Pure Simple Highlight */
        .highlight-text {
            color: #28a745;
            display: inline-block;
        }

        .hero p { 
            font-size: 1.2rem; 
            margin-bottom: 30px; 
            color: #e0e0e0;
        }

        /* Simple Animated Pulse Button (No complex JS) */
        .cta-btn {
            display: inline-block;
            padding: 12px 35px;
            background: #28a745;
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            animation: pulseBtn 2s infinite; /* Gentle breathing animation */
        }
        
        .cta-btn:hover {
            background: #218838;
            transform: scale(1.05); /* Soft zoom-in on hover */
        }

        /* 3. Featured Houses Grid */
        .browse-section {
            padding: 60px 50px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .browse-section h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2rem;
            color: #333;
        }
        .house-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        .house-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .house-card:hover { 
            transform: translateY(-8px); 
        }
        .house-card img, .house-card video { width: 100%; height: 200px; object-fit: cover; }
        
        .card-content { padding: 20px; }
        .card-content h3 { margin-bottom: 10px; color: #333; }
        .card-content p { color: #666; margin-bottom: 5px; }
        .price { color: #28a745; font-weight: bold; font-size: 1.2rem; display: block; margin-top: 10px; }

        .view-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color: #333;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .view-btn:hover { background-color: #28a745; }

        .no-houses {
            text-align: center;
            grid-column: 1 / -1;
            color: #888;
            font-size: 1.2rem;
            padding: 40px;
        }

        
        .why-us {
            background-color: #fff;
            padding: 60px 50px;
            text-align: center;
        }
        .features-container {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            margin-top: 40px;
        }
        .feature-box { max-width: 300px; }
        .feature-box h3 { margin: 15px 0; color: #28a745; }

        
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
        }

       
        @keyframes pulseBtn {
            0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <a href="{{ url('/') }}">EasyRent 🏠</a>
        </div>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('houses.index') }}">Browse Houses</a></li>
            
            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ url('/dashboard') }}" style="color: #28a745; font-weight: bold;">Dashboard</a></li>
                @endif
                
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            Logout ({{ auth()->user()->name }})
                        </button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Registration</a></li>
            @endauth
        </ul>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Find Your <span class="highlight-text">Dream House</span> in Seconds</h1>
            <p>Simplifying the process of finding rental properties online safely.</p>
            <a href="{{ route('houses.index') }}" class="cta-btn">Start Browsing Houses →</a>
        </div>
    </section>

    <section class="browse-section">
        <h2>Available Houses</h2>
        <div class="house-grid">
            
            @forelse($houses as $house)
                <div class="house-card">
                    
                    @if($house->media_upload)
                        @if(in_array(pathinfo($house->media_upload, PATHINFO_EXTENSION), ['mp4', 'mov', 'webm']))
                            <video src="{{ asset('storage/' . $house->media_upload) }}" controls class="house-video"></video>
                        @else
                            <img src="{{ asset('storage/' . $house->media_upload) }}" alt="{{ $house->name }}" class="house-img">
                        @endif
                    @endif

                    <div class="card-content">
                        <h3>{{ $house->name }}</h3>
                        <p>📍 {{ $house->location }}</p>
                        <p>🏠 Type: {{ $house->property_Type }}</p>
                        <span class="price">${{ number_format($house->price) }} / Month</span>
                        <a href="{{ route('houses.index') }}" class="view-btn">View Details</a>
                    </div>
                </div>
            @empty
                <div class="no-houses">
                    <p>No houses available at the moment. Check back later!</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="why-us">
        <h2>Why us?</h2>
        <div class="features-container">
            <div class="feature-box">
                <span>⚡</span>
                <h3>Fast Search</h3>
                <p>Find suitable houses quickly without the struggle.</p>
            </div>
            <div class="feature-box">
                <span>🤝</span>
                <h3>Direct Contact</h3>
                <p>Send rental requests directly through the system.</p>
            </div>
            <div class="feature-box">
                <span>📋</span>
                <h3>Easy Management</h3>
                <p>Organized management for rental requests and houses.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 EasyRent - CSC 400 Web Programming Project</p>
        <p>Created by Batoul Ghamloush & Israa Dawood</p>
    </footer>

</body>
</html>