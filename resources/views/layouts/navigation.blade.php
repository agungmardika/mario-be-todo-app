<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Navigation</title>

    <style>
        /* General Styles */
        nav {
            background-color: #1e293b; /* Dark background */
            color: #fff; /* White text */
            border-bottom: 2px solid #475569; /* Slight border at the bottom */
        }

        /* Flex container and spacing */
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
            height: 64px;
        }

        /* Logo Styling */
        .nav-logo a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #fff;
        }

        .nav-logo svg {
            height: 36px;
            width: auto;
        }

        /* Navigation Links */
        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #38bdf8; /* Highlight color */
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-trigger {
            background: none;
            border: none;
            color: #fff;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .user-trigger:hover {
            color: #38bdf8;
        }

        .user-dropdown-menu {
            display: none;
            position: absolute;
            top: 48px;
            right: 0;
            background-color: #334155;
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 200px;
        }

        .user-dropdown-menu.active {
            display: block;
        }

        .user-dropdown-menu a {
            display: block;
            padding: 10px 16px;
            text-decoration: none;
            color: #fff;
            transition: background 0.3s;
        }

        .user-dropdown-menu a:hover {
            background: #475569;
        }

        .user-dropdown-menu form {
            margin: 0;
        }

        .user-dropdown-menu button {
            width: 100%;
            padding: 10px 16px;
            border: none;
            background: none;
            text-align: left;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .user-dropdown-menu button:hover {
            background: #475569;
        }

        /* Mobile Menu */
        .hamburger {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .mobile-nav {
            display: none;
        }

        .mobile-nav.active {
            display: block;
            background-color: #1e293b;
            padding: 1rem;
        }

        .mobile-nav a {
            display: block;
            margin-bottom: 0.5rem;
            color: #fff;
            text-decoration: none;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hamburger {
                display: block;
            }
        }
    </style>
</head>

<body>
    <nav>
        <div class="nav-container">
            <!-- Logo -->
            <div class="nav-logo">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="user-dropdown">
                <button class="user-trigger" onclick="toggleDropdown()">
                    <span>{{ Auth::user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="user-dropdown-menu" id="dropdownMenu">
                    <a href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Log Out</button>
                    </form>
                </div>
            </div>

            <!-- Hamburger Menu -->
            <button class="hamburger" onclick="toggleMobileMenu()">☰</button>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-nav" id="mobileNav">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('profile.edit') }}">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Log Out</button>
            </form>
        </div>
    </nav>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('active');
        }

        function toggleMobileMenu() {
            const mobileNav = document.getElementById('mobileNav');
            mobileNav.classList.toggle('active');
        }
    </script>
</body>

</html>
