
    
<?php include('../template/header.php   ') ?>
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex justify-end mb-4">
            <button 
                onclick="toggleDarkMode()" 
                class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition"
            >
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:inline"></i>
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden">
            <!-- Navigation Tabs -->
            <div class="flex border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <button 
                    id="profileTabBtn" 
                    onclick="switchTab('profile')" 
                    class="flex-1 py-4 px-6 text-center font-semibold transition hover:bg-blue-50 dark:hover:bg-gray-700"
                >
                    <i class="fas fa-user mr-2"></i> Profile
                </button>
                <button 
                    id="reservationsTabBtn" 
                    onclick="switchTab('reservations')" 
                    class="flex-1 py-4 px-6 text-center font-semibold transition hover:bg-blue-50 dark:hover:bg-gray-700"
                >
                    <i class="fas fa-car mr-2"></i> Reservations
                </button>
                <button 
                    id="securityTabBtn" 
                    onclick="switchTab('security')" 
                    class="flex-1 py-4 px-6 text-center font-semibold transition hover:bg-blue-50 dark:hover:bg-gray-700"
                >
                    <i class="fas fa-lock mr-2"></i> Security
                </button>
            </div>

            <!-- Profile Tab -->
            <div id="profileTab" class="p-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Profile Picture & Basic Info -->
                    <div class="md:col-span-1 flex flex-col items-center">
                        <div class="relative mb-4">
                            <img 
                                src="https://ui-avatars.com/api/?name=John+Doe&background=0D8AFC&color=fff" 
                                alt="Profile" 
                                class="w-32 h-32 rounded-full object-cover border-4 border-blue-500"
                            >
                            <button class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 shadow-lg">
                                <i class="fas fa-camera text-xs"></i>
                            </button>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">John Doe</h2>
                        <p class="text-gray-600 dark:text-gray-300">Client</p>
                    </div>

                    <!-- Detailed Information -->
                    <div class="md:col-span-2 grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                            <input 
                                type="text" 
                                value="John" 
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                                readonly
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name</label>
                            <input 
                                type="text" 
                                value="Doe" 
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                                readonly
                            >
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input 
                                type="email" 
                                value="john.doe@example.com" 
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                                readonly
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservations Tab -->
            <div id="reservationsTab" class="hidden p-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-300">
                                <th class="py-3 px-4 text-left">Reservation ID</th>
                                <th class="py-3 px-4 text-left">Vehicle</th>
                                <th class="py-3 px-4 text-left">Dates</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b dark:border-gray-700">
                                <td class="py-3 px-4">RES-001</td>
                                <td class="py-3 px-4">Toyota Camry</td>
                                <td class="py-3 px-4">July 15-22, 2024</td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                        bg-green-100 text-green-800">Approved</span>
                                </td>
                                <td class="py-3 px-4">
                                    <button class="text-blue-500 hover:text-blue-700 flex items-center">
                                        <i class="fas fa-eye mr-2"></i> Details
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="securityTab" class="hidden p-8">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Change Password</h3>
                        <div class="space-y-4">
                            <input 
                                type="password" 
                                placeholder="Current Password" 
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            >
                            <input 
                                type="password" 
                                placeholder="New Password" 
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            >
                            <input 
                                type="password" 
                                placeholder="Confirm New Password" 
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            >
                            <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                                Update Password
                            </button>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Account Security</h3>
                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <span>Two-Factor Authentication</span>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input 
                                        type="checkbox" 
                                        name="toggle" 
                                        id="toggle-example" 
                                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                                    >
                                    <label 
                                        for="toggle-example" 
                                        class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"
                                    ></label>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                Add an extra layer of security to your account by enabling two-factor authentication.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom toggle switch styling */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #3B82F6;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #3B82F6;
        }
    </style>
</body>
</html>
