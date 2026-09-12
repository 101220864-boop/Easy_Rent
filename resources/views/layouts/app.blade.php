<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyRent</title>
    <style>
        /* Global Reset and Typography */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
        }

        /* Navbar - Shared Across Pages */
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

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }

        .navbar nav {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar a:hover, .navbar a.active {
            color: #28a745;
        }

        .register-btn {
            background-color: #28a745;
            color: white !important;
            padding: 10px 20px;
            border-radius: 5px;
        }

        main {
            min-height: 80vh;
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">🏠 EasyRent</div>
       <nav>
    <a href="/">Home</a>
    <a href="{{ route('houses.index') }}">Browse Houses</a>

    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('dashboard') }}" style="color: #28a745; font-weight: bold;">Dashboard</a>
        @endif
        
        <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 15px;">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ff6b6b;">
                Logout
            </a>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}" class="register-btn">Register</a>
    @endauth
</nav>
    </header>

    <main>
        {{ $slot }}
    </main>

</body>
</html>