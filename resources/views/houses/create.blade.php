<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyRent - Add Property</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        
        body { display: flex; background: #f0f2f5; min-height: 100vh; }

        /* Sidebar Navigation */
        .sidebar {
            width: 260px;
            background: #333;
            color: white;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
        }
        .sidebar h2 { color: #28a745; margin-bottom: 40px; text-align: center; }
        .sidebar a {
            display: block;
            color: #ccc;
            text-decoration: none;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar .active { background: #28a745; color: white; }

        /* Main Content Area */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 40px;
        }

        .page-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Error/Validation Messages Banner */
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            grid-column: span 2;
        }
        .alert-danger ul { margin-left: 20px; }

        /* The Form Container */
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two columns */
            gap: 30px;
        }

        .full-width { grid-column: span 2; }

        h3 { margin-bottom: 15px; color: #333; font-size: 1.1rem; }

        label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        input:focus { border-color: #28a745; }

        /* Media Upload Styling */
        .media-upload {
            border: 2px dashed #ccc;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            background: #fafafa;
            transition: 0.3s;
        }
        .media-upload:hover { border-color: #28a745; background: #f1fff4; }
        .media-upload span { font-size: 2rem; display: block; margin-bottom: 10px; }

        /* Button Styling */
        .btn-group {
            grid-column: span 2;
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-primary { background: #28a745; color: white; flex: 2; }
        .btn-secondary { background: #eee; color: #333; flex: 1; text-decoration: none; text-align: center; }

        /* Status Badge */
        .status-select { background: #fff8e1; border-color: #ffe082; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <h2>🏠 EasyRent</h2>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('houses.create') }}" class="active">Add New House</a>
        <a href="{{ route('houses.index') }}">View Site</a>
        
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 50px;">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ff6b6b; padding: 15px;">
                Logout
            </a>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <h1>Listing New Property</h1>
            <p>Admin Control Panel</p>
        </div>

        <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf

            @if ($errors->any())
                <div class="alert-danger">
                    <strong>Whoops! Something went wrong:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <h3>Property Information</h3>
                <div style="margin-bottom: 20px;">
                    <label for="name">House Name / Title</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Modern Villa Beirut" required>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="location">Exact Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="e.g. Beirut" required>
                </div>

                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label for="price">Price ($/Month)</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                    </div>
                    <div style="flex: 1;">
                        <label for="property_Type">Property Type</label>
                        <select id="property_Type" name="property_Type">
                            <option value="Apartment" {{ old('property_Type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="Villa" {{ old('property_Type') == 'Villa' ? 'selected' : '' }}>Villa</option>
                            <option value="Studio" {{ old('property_Type') == 'Studio' ? 'selected' : '' }}>Studio</option>
                            <option value="Office" {{ old('property_Type') == 'Office' ? 'selected' : '' }}>Office</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <h3>Media Upload (Image or Video)</h3>
                <div class="media-upload" onclick="document.getElementById('fileInput').click()">
                    <span>📁</span>
                    <p id="upload-text">Click to upload House Photos or Video</p>
                    <small>Support: JPG, PNG, MP4</small>
                    <input type="file" id="fileInput" name="media_upload" hidden accept="image/*,video/*" required>
                </div>
                
                <div style="margin-top: 25px;">
                    <label for="status">Listing Status</label>
                    <select id="status" name="status" class="status-select">
                        <option value="Available">Available Now</option>
                        <option value="Maintenance">Under Maintenance</option>
                        <option value="Hidden">Hidden</option>
                    </select>
                </div>
            </div>

            <div class="full-width">
                <label for="description">Detailed Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Mention number of rooms, bathrooms, amenities like WiFi, Parking..." required>{{ old('description') }}</textarea>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Publish Property Now</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Discard Changes</a>
            </div>
        </form>
    </main>

    <script>
        document.getElementById('fileInput').addEventListener('change', function() {
            if (this.files.length > 0) {
                document.getElementById('upload-text').innerText = "Selected: " + this.files[0].name;
                document.querySelector('.media-upload').style.borderColor = "#28a745";
                document.querySelector('.media-upload').style.background = "#f1fff4";
            }
        });
    </script>
</body>
</html>