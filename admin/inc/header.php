<!-- Header Section -->
<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
    <h3 class="mb-0">ADMIN</h3>
    <a href="logout.php" class="btn btn-light btn-sm">LOG OUT</a>
</div>

<!-- Sidebar Section -->
<div id="dashboard-menu" class="bg-dark text-light">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid flex-lg-column align-items-stretch">
            
            <!-- Navbar Toggler for Mobile -->
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Sidebar Navigation Menu -->
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_bookings.php">Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="settings.php">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

