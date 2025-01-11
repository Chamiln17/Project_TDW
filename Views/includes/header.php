<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userRole = $_SESSION['role'] ?? 'public';
$current_page = $_SERVER['REQUEST_URI'];
// Remove query strings
$current_page = strtok($current_page, '?');
// Remove trailing slash if exists
$current_page = rtrim($current_page, '/');
if ($current_page === '/Project_TDW' || $current_page === '/Project_TDW/') {
    $current_page = '/Project_TDW';
}

function afficherNavbar($userRole) {
    // Define navigation items for each user role
    $nav_items = [
        'admin' => [
            '/Project_TDW' => 'A Propos',
            '/Project_TDW/evenements' => 'Evenements',
            '/Project_TDW/news' => 'News',
            '/Project_TDW/catalogue' => 'Partenaires',
            '/Project_TDW/contact' => 'Contactez nous',
            '/admin/dashboard' => 'Dashboard',
            '/admin/members' => 'Members'
        ],
        'member' => [
            '/Project_TDW' => 'A Propos',
            '/Project_TDW/evenements' => 'Evenements',
            '/Project_TDW/news' => 'News',
            '/Project_TDW/catalogue' => 'Partenaires',
            '/Project_TDW/contact' => 'Contactez nous'
        ],
        'public' => [
            '/Project_TDW' => 'A Propos',
            '/Project_TDW/evenements' => 'Evenements',
            '/Project_TDW/news' => 'News',
            '/Project_TDW/catalogue' => 'Partenaires',
            '/Project_TDW/contact' => 'Contactez nous'
        ]
    ];

    // Get current page URL
    $current_page = $_SERVER['REQUEST_URI'];
    $current_page = strtok($current_page, '?');
    $current_page = rtrim($current_page, '/');

    if ($current_page === '/Project_TDW' || $current_page === '/Project_TDW/') {
        $current_page = '/Project_TDW';
    }

    // Select appropriate navigation items based on user role
    $current_nav_items = $nav_items[$userRole] ?? $nav_items['public'];

    // Generate the navbar with consistent styling
    echo '<nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex space-x-8">';

    foreach ($current_nav_items as $path => $label) {
        $is_active = $current_page === $path;

        if (!$is_active && $path !== '/Project_TDW') {
            $is_active = strpos($current_page, $path) === 0;
        }

        $class = $is_active
            ? "inline-flex items-center px-1 pt-1 border-b-2 border-red-500 text-gray-900"
            : "inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-900 hover:border-b-2 hover:border-gray-300";

        echo '<a href="' . $path . '" class="' . $class . '">' . $label . '</a>';
    }

    echo '</div>
          <div class="flex items-center">';

    // Different buttons based on user role
    if ($userRole === 'member') {
        echo '<a href="/member/profile" class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">My Profile</a>
              <a href="/logout" class="bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Logout</a>';
    } elseif ($userRole === 'admin') {
        echo '<a href="/admin/dashboard" class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Dashboard</a>
              <a href="/logout" class="bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Logout</a>';
    } else {
        echo '<a href="/Project_TDW/login" class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Login</a>
              <a href="/Project_TDW/register" class="bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Rejoignez Nous</a>';
    }

    echo '</div>
        </div>
      </div>
    </nav>';
}

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Header</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'nav-gray': '#2D3339',
                            'brand-red': '#FF0000',
                        }
                    }
                }
            }
        </script>
        <link rel="stylesheet" href="/assets/">
        <style>
            .slide {
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
                display: none;
            }
            .slide.active {
                opacity: 1;
                display: block;
            }
            .benefits-table tr:nth-child(even) {
                background-color: rgba(0, 0, 0, 0.02);
            }
        </style>
    </head>
<body>
    <header class="bg-gray-800 text-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <span class="text-red-500 text-3xl">❤</span>
                    <span class="ml-2 text-xl font-semibold">Coeur <span class="text-red-500">espoir</span></span>
                </div>

                <!-- Social Media Links -->
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </header>
<?php afficherNavbar($userRole); ?>