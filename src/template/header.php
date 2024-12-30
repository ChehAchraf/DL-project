<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('dark-mode', document.documentElement.classList.contains('dark'));
        }

        // Initialize dark mode
        function initDarkMode() {
            if (localStorage.getItem('dark-mode') === 'true') {
                document.documentElement.classList.add('dark');
            }
        }

        // Tab switching
        function switchTab(tabName) {
            // Hide all tabs
            ['profile', 'reservations', 'security'].forEach(tab => {
                document.getElementById(tab + 'Tab').classList.add('hidden');
                document.getElementById(tab + 'TabBtn').classList.remove('bg-blue-600', 'text-white');
            });

            // Show selected tab
            document.getElementById(tabName + 'Tab').classList.remove('hidden');
            document.getElementById(tabName + 'TabBtn').classList.add('bg-blue-600', 'text-white');
        }

        // Initialize on page load
        window.onload = function() {
            initDarkMode();
            switchTab('profile'); // Default to profile tab
        }
    </script>
    <script>
        // Theme toggle logic
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        // Check initial theme on page load
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            
            if (savedTheme === 'dark' || 
                (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        });
    </script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
<nav class="bg-black dark:bg-gray-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="#" class="flex-shrink-0">
                    <img class="h-8 w-8" src="your-logo.png" alt="Logo">
                </a>
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="index.php" class="text-white dark:text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="#" class="text-white dark:text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">About</a>
                    <a href="#" class="text-white dark:text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Services</a>
                    <a href="#" class="text-white dark:text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                </div>
            </div>
            <div class="ml-4 flex items-center md:ml-6">
                <!-- Theme Toggle Button -->
                <button 
                    onclick="toggleTheme()" 
                    class="bg-gray-800 dark:bg-gray-600 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white mr-4"
                >
                    <span class="sr-only">Toggle theme</span>
                    <svg 
                        class="h-6 w-6 text-white dark:text-yellow-400" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24" 
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m3.343-5.657L5.929 5.929m12.728 12.728L18.071 18.07M12 7a5 5 0 110 10 5 5 0 010-10z" 
                        ></path>
                    </svg>
                </button>

                <!-- Conditional Login/User Menu -->
                <?php if (!isset($_SESSION['role'])): ?>
                    <!-- Get Started Button -->
                    <a href="login.php" class="text-white bg-primary-600 hover:bg-primary-700 px-3 py-2 rounded-md text-sm font-medium">
                        Get Started
                    </a>
                <?php elseif ($_SESSION['role'] == 'client'): ?>
                    <!-- Client Dropdown -->
                    <div class="relative">
                        <button type="button" class="flex items-center text-white bg-gray-700 hover:bg-gray-600 px-3 py-2 rounded-md text-sm font-medium">
                            <?= htmlspecialchars($_SESSION['name'] ?? 'Client') ?>
                            <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-50 hidden">
                            <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Profile
                            </a>
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Logout
                            </a>
                        </div>
                    </div>
                <?php elseif ($_SESSION['role'] == 'admin'): ?>
                    <!-- Admin Dropdown -->
                    <div class="relative">
                        <button type="button" class="flex items-center text-white bg-gray-700 hover:bg-gray-600 px-3 py-2 rounded-md text-sm font-medium">
                            <?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?>
                            <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-50 hidden">
                            <a href="dashboard.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Dashboard
                            </a>
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Logout
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- JavaScript for Dropdown Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButtons = document.querySelectorAll('.relative');
        
        dropdownButtons.forEach(dropdown => {
            const button = dropdown.querySelector('button');
            const menu = dropdown.querySelector('div[class*="absolute"]');
            
            button.addEventListener('click', function() {
                menu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    });
</script>
