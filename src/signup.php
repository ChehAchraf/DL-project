<?php include('template/header.php') ?>
    <!-- Hero Section -->
    <div class="relative h-[600px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1502877338535-766e1452684a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80')">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative z-10 container mx-auto px-32 flex flex-col justify-center h-full">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold text-white mb-6 leading-tight">
                    Create Your Account
                </h1>
                <p class="text-xl text-gray-200 mb-8">
                    Join our community and start your journey with easy car rentals.
                </p>
            </div>
        </div>
    </div>

    <!-- Signup Section -->
    <div class="container mx-auto px-32 py-16 grid md:grid-cols-2 gap-12">
        <!-- Signup Illustration -->
        <div class="hidden md:flex items-center justify-center px-32">
            <div class="w-full max-w-md">
                <img 
                    src="https://source.unsplash.com/600x400/?signup,illustration" 
                    alt="Signup Illustration" 
                    class="w-full h-auto transform transition-all hover:scale-105"
                >
            </div>
        </div>

        <!-- Signup Form -->
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-8">
            <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white text-center">
                Sign Up
            </h2>
            
            <form id="signupForm" class="space-y-6" method="POST" action="helpers/signup_handling.php">
                <!-- Name Fields -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-600 dark:text-gray-300">First Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-user"></i>
                            </span>
                            <input 
                                type="text" 
                                name="first_name"
                                required 
                                class="w-full px-4 py-3 pl-10 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                                placeholder="John"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-600 dark:text-gray-300">Last Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-user"></i>
                            </span>
                            <input 
                                type="text" 
                                name="last_name"
                                required 
                                class="w-full px-4 py-3 pl-10 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                                placeholder="Doe"
                            >
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-2 text-gray-600 dark:text-gray-300">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input 
                            type="email" 
                            name="email"
                            required 
                            class="w-full px-4 py-3 pl-10 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            placeholder="john.doe@example.com"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-2 text-gray-600 dark:text-gray-300">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input 
                            type="password" 
                            name="password"
                            required 
                            class="w-full px-4 py-3 pl-10 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            placeholder="Enter your password"
                        >
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 cursor-pointer" onclick="togglePasswordVisibility(this)">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block mb-2 text-gray-600 dark:text-gray-300">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input 
                            type="password" 
                            name="confirm_password"
                            required 
                            class="w-full px-4 py-3 pl-10 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            placeholder="Confirm your password"
                        >
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        required 
                        class="mr-2 rounded text-blue-600 focus:ring-blue-500"
                    >
                    <label for="terms" class="text-gray-600 dark:text-gray-300">
                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-4 rounded-lg hover:bg-blue-700 transition text-lg font-semibold"
                >
                    Create Account
                </button>

                <!-- Login Link -->
                <div class="text-center mt-4">
                    <p class="text-gray-600 dark:text-gray-300">
                        Already have an account? 
                        <a href="login.php" class="text-blue-600 hover:underline">
                            Log In
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password visibility toggle
        function togglePasswordVisibility(element) {
            const passwordInput = element.previousElementSibling;
            const icon = element.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        // Client-side password validation
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    title: "Password not much!",
                    text: "Please verify the password entry!",
                    icon: "warning"
                });
            }
        });
    </script>
</body>
</html>
