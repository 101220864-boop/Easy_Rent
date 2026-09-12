<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyRent - Register</title>
    <style>
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1000');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

       
        .auth-container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.8rem;
        }

        
        .auth-form {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
            font-size: 0.9rem;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #28a745; 
        }

        
        .btn-auth {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn-auth:hover {
            background-color: #218838;
        }

        
        .auth-link {
            margin-top: 20px;
            color: #666;
            font-size: 0.9rem;
        }

        a {
            color: #28a745;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        
        .alert-errors {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: left;
            font-size: 0.9rem;
        }
        .alert-errors ul { margin-left: 20px; }
    </style>
</head>
<body>

    <div class="auth-container">
        <h2>Create Account</h2>

        @if ($errors->any())
            <div class="alert-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>
            
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat your password" required>
            
            <button type="submit" class="btn-auth">Register</button>
        </form>
        
        <p class="auth-link">Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </div>

</body>
</html>