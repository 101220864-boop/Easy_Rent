<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EasyRent</title>
    <style>
        /* General Setup */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f4f7f6; display: flex; color: #333; }

        /* Sidebar Structure */
        .sidebar {
            width: 200px;
            height: 100vh;
            background: #333;
            color: white;
            padding: 20px;
            position: fixed;
        }
        .sidebar h2 { font-size: 1.2rem; margin-bottom: 30px; color: #28a745; }
        .sidebar a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
        .sidebar a:hover, .sidebar .active { background: #28a745; color: white; }

        /* Main Content Frame */
        .main-content { margin-left: 200px; width: calc(100% - 200px); padding: 30px; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Status Styling Alerts */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Tables & Panels */
        .panel {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        .panel h2 { font-size: 1.1rem; margin-bottom: 15px; border-left: 4px solid #28a745; padding-left: 10px; }

        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th { background: #f8f9fa; text-align: left; padding: 12px; border-bottom: 2px solid #eee; }
        td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: middle; }

        /* Form Buttons inline */
        .inline-form { display: inline; margin: 0; padding: 0; }

        /* Buttons */
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 0.8rem; text-decoration: none; display: inline-block; }
        .btn-add { background: #28a745; color: white; }
        .btn-delete { background: #dc3545; color: white; margin-left: 5px; }
        .btn-accept { background: #28a745; color: white; margin-right: 5px; }
        .btn-reject { background: #6c757d; color: white; }
        
        .status-badge { font-weight: bold; text-transform: capitalize; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <h2>EasyRent Admin</h2>
        <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
        {{-- Links directly to your upcoming creation page form --}}
        <a href="{{ route('houses.create') }}">Add New House</a>
        <a href="{{ route('houses.index') }}">View Site</a>
        
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 50px;">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ff6b6b; padding: 12px;">
                Logout
            </a>
        </form>
    </aside>

    <main class="main-content">
        <div class="header">
            <h1>Control Panel</h1>
        </div>

        {{-- Global Notification Banner --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="panel">
            <h2>Manage Houses</h2>
            <table>
                <thead>
                    <tr>
                        <th>House Name</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($houses as $house)
                        <tr>
                            <td>{{ $house->name }}</td>
                            <td>{{ $house->location }}</td>
                            <td>${{ number_format($house->price) }}</td>
                            <td>
                                <form action="{{ route('houses.destroy', $house->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #777;">No houses found in the database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="panel">
            <h2>Rental Requests</h2>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>House</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rentalRequests as $request)
                        <tr>
                            {{-- Accessing related user models connected through your database schemas --}}
                            <td>{{ $request->user->name ?? 'Unknown User' }}</td>
                            <td>{{ $request->house->name ?? 'Property Removed' }}</td>
                           <td>
                        @if($request->status == 'pending')
                            <span class="status-badge" style="color: orange; font-weight: bold;">Pending</span>
                        @elseif($request->status == 'accepted' || $request->status == 'approved')
                            <span class="status-badge" style="color: green; font-weight: bold;">Accepted</span>
                        @elseif($request->status == 'rejected')
                            <span class="status-badge" style="color: red; font-weight: bold;">Rejected</span>
                        @else
                            <span class="status-badge" style="text-transform: capitalize;">{{ $request->status }}</span>
                        @endif
                    </td>
                            <td>
                        @if($request->status == 'pending')
                            <div style="display: flex; gap: 8px;">
                                
            <form action="{{ route('rental.requests.approve', $request->id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-accept" style="background-color: #28a745; color: white;">
                    Accept
                </button>
            </form>

            <form action="{{ route('rental.requests.reject', $request->id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-reject" style="background-color: #dc3545; color: white;">
                    Reject
                </button>
            </form>

        </div>
    @else
        <span style="color: #999; font-style: italic; text-transform: capitalize;">
            {{ $request->status }}
        </span>
    @endif
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #777;">No rental requests submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>