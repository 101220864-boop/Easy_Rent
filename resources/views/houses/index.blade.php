<x-app-layout>
    <style>
        /* Unique Page Hero Section */
        .hero {
            height: 250px;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
            url("https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1200");
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero h1 { font-size: 2.5rem; margin-bottom: 10px; }

        /* Search Box */
        .search-box {
            background: white;
            width: 80%;
            max-width: 900px;
            margin: -40px auto 40px;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            position: relative;
            z-index: 2;
        }

        .search-box input, .search-box select {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        .search-box button {
            padding: 12px 30px;
            border: none;
            background: #28a745;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .search-box button:hover { background: #218838; }

        /* Main Content Layout Split */
        .page-content {
            display: flex;
            gap: 30px;
            padding: 0 50px 50px;
            max-width: 1300px;
            margin: 0 auto;
        }

        /* Sidebar Filters */
        .filter-panel {
            width: 260px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            height: fit-content;
        }

        .filter-panel h3 { border-bottom: 2px solid #28a745; padding-bottom: 10px; margin-bottom: 15px; }
        .filter-panel h4 { margin: 20px 0 10px; font-size: 1rem; }
        .filter-panel label { display: block; margin: 8px 0; color: #555; cursor: pointer; }

        /* Houses Grid */
        .houses-section { flex: 1; }
        .section-title { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .section-title p { color: #28a745; font-weight: bold; }

        .houses-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .house-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
            position: relative;
        }

        .house-card:hover { transform: translateY(-5px); }
        .house-card img, .house-card video { width: 100%; height: 200px; object-fit: cover; }

        .badge {
            position: absolute;
            top: 10px; left: 10px;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: bold;
            z-index: 5;
            color: white;
        }
        .badge-available { background: #28a745; }
        .badge-rented { background: #dc3545; }

        .card-body { padding: 15px; }
        .house-header { display: flex; justify-content: space-between; margin-bottom: 10px; align-items: center; }
        .house-header h3 { font-size: 1.1rem; color: #333; }
        .house-header p { color: #28a745; font-weight: bold; }

        .location { color: #888; font-size: 0.9rem; margin-bottom: 10px; }
        .description-text { color: #666; font-size: 0.85rem; margin-bottom: 15px; line-height: 1.4; }
        .features { padding: 10px 0; border-top: 1px solid #eee; margin-bottom: 15px; }

        .rent-btn {
            width: 100%;
            padding: 12px;
            border: 1px solid #28a745;
            background: transparent;
            color: #28a745;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .rent-btn:hover:not(:disabled) {
            background: #28a745;
            color: white;
        }

        .rent-btn:disabled {
            border-color: #999;
            color: #999;
            cursor: not-allowed;
            background: #eee;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 20px auto;
            width: 80%;
            max-width: 1200px;
            border-radius: 5px;
            text-align: center;
        }

        .no-results {
            text-align: center;
            grid-column: 1 / -1;
            padding: 50px;
            color: #777;
            font-size: 1.2rem;
        }
    </style>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="hero">
        <h1>Find Your Perfect Home</h1>
        <p>Browse available houses for rent and choose the best one for you.</p>
    </section>

    <section class="search-box">
        <input type="text" id="searchInput" placeholder="Search by location...">

        <select id="priceFilter">
            <option value="all">All Prices</option>
            <option value="low">$300 - $500</option>
            <option value="medium">$500 - $800</option>
            <option value="high">$800+</option>
        </select>

        <button onclick="filterHouses()">Search</button>
    </section>

    <main class="page-content">
        <aside class="filter-panel">
            <h3>Filter</h3>
            
            <h4>Location</h4>
            <label><input type="checkbox" class="location-filter" value="all" id="allLocations" checked onchange="toggleAllFilters('location')"> All Locations</label>
            <label><input type="checkbox" class="location-filter" value="beirut" onchange="handleSubFilter('location')"> Beirut</label>
            <label><input type="checkbox" class="location-filter" value="saida" onchange="handleSubFilter('location')"> Saida</label>
            <label><input type="checkbox" class="location-filter" value="jbeil" onchange="handleSubFilter('location')"> Jbeil</label>
            <label><input type="checkbox" class="location-filter" value="tripoli" onchange="handleSubFilter('location')"> Tripoli</label>

            <h4>Property Type</h4>
            <label><input type="checkbox" class="type-filter" value="all" id="allTypes" checked onchange="toggleAllFilters('type')"> All Types</label>
            <label><input type="checkbox" class="type-filter" value="apartment" onchange="handleSubFilter('type')"> Apartment</label>
            <label><input type="checkbox" class="type-filter" value="house" onchange="handleSubFilter('type')"> House</label>
            <label><input type="checkbox" class="type-filter" value="villa" onchange="handleSubFilter('type')"> Villa</label>
        </aside>

        <section class="houses-section">
            <div class="section-title">
                <h2>Available Houses</h2>
                <p id="resultCount">Showing {{ $houses->count() }} results</p>
            </div>

            <div class="houses-container">
                @forelse($houses as $house)
                    <div class="house-card" data-location="{{ strtolower($house->location) }}" data-price="{{ $house->price }}" data-type="{{ strtolower($house->property_Type) }}">
                        
                        @if($house->status === 'rented')
                            <span class="badge badge-rented">RENTED / SOLD OUT</span>
                        @else
                            <span class="badge badge-available">AVAILABLE</span>
                        @endif
                        
                        @if($house->media_upload)
                            @if(in_array(pathinfo($house->media_upload, PATHINFO_EXTENSION), ['mp4']))
                                <video src="{{ asset('storage/' . $house->media_upload) }}" controls></video>
                            @else
                                <img src="{{ asset('storage/' . $house->media_upload) }}" alt="{{ $house->name }}">
                            @endif
                        @else
                            <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994" alt="Default House">
                        @endif

                        <div class="card-body">
                            <div class="house-header">
                                <h3>{{ $house->name }}</h3>
                                <p>${{ number_format($house->price) }}<span>/mo</span></p>
                            </div>
                            <p class="location">📍 {{ $house->location }}</p>
                            
                            <div class="features">
                                <p class="description-text">Type: <strong>{{ $house->property_Type }}</strong></p>
                                <p class="description-text">{{ Str::limit($house->description, 70) }}</p>
                            </div>

                            @if($house->status === 'rented')
                                <button type="button" class="rent-btn" disabled>🔒 Unavailable (Rented)</button>
                            @else
                                <form action="{{ route('rental.requests.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="house_id" value="{{ $house->id }}">
                                    <button type="submit" class="rent-btn">Rent House →</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="no-results">
                        <p>No houses found in the system.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <script>
        function filterHouses() {
            let searchValue = document.getElementById("searchInput").value.toLowerCase();
            let priceValue = document.getElementById("priceFilter").value;
            let cards = document.querySelectorAll(".house-card");
            let count = 0;

            
            let selectedLocations = [];
            let locCheckboxes = document.querySelectorAll(".location-filter:checked");
            locCheckboxes.forEach(cb => selectedLocations.push(cb.value));

            
            let selectedTypes = [];
            let typeCheckboxes = document.querySelectorAll(".type-filter:checked");
            typeCheckboxes.forEach(cb => selectedTypes.push(cb.value));

            cards.forEach(function(card) {
                let location = card.getAttribute("data-location");
                let price = Number(card.getAttribute("data-price"));
                let type = card.getAttribute("data-type");

                
                let matchSearch = location.includes(searchValue);

                
                let matchPrice =
                    priceValue === "all" ||
                    (priceValue === "low" && price >= 300 && price <= 500) ||
                    (priceValue === "medium" && price > 500 && price <= 800) ||
                    (priceValue === "high" && price > 800);

                
                let matchLocation = selectedLocations.includes("all") || selectedLocations.includes(location);

                
                let matchType = selectedTypes.includes("all") || selectedTypes.includes(type);

                
                if (matchSearch && matchPrice && matchLocation && matchType) {
                    card.style.display = "block";
                    count++;
                } else {
                    card.style.display = "none";
                }
            });

            document.getElementById("resultCount").textContent = "Showing " + count + " results";
        }

        
        function toggleAllFilters(filterType) {
            let allCheckbox = document.getElementById(filterType === 'location' ? 'allLocations' : 'allTypes');
            let subCheckboxes = document.querySelectorAll(filterType === 'location' ? '.location-filter' : '.type-filter');

            if (allCheckbox.checked) {
                subCheckboxes.forEach(cb => {
                    if (cb !== allCheckbox) cb.checked = false;
                });
            }
            filterHouses();
        }

        
        function handleSubFilter(filterType) {
            let allCheckbox = document.getElementById(filterType === 'location' ? 'allLocations' : 'allTypes');
            let subCheckboxes = document.querySelectorAll(filterType === 'location' ? '.location-filter:not(#allLocations):checked' : '.type-filter:not(#allTypes):checked');

            if (subCheckboxes.length > 0) {
                allCheckbox.checked = false;
            } else {
                allCheckbox.checked = true;
            }
            filterHouses();
        }
    </script>
</x-app-layout>