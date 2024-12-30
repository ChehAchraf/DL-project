<?php include('template/header.php') ?>
<div class="min-h-screen flex">
    <!-- Left Side: Login Form -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-10 md:px-20 lg:px-32 bg-white dark:bg-gray-900">
        <div class="max-w-md w-full mx-auto">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Welcome Back
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Login to access your account
                </p>
            </div>

            <form class="mt-8 space-y-6" action="#" method="POST">
                <!-- Email Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email address
                    </label>
                    <input 
                        type="email" 
                        required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm 
                        text-gray-900 dark:text-white 
                        bg-white dark:bg-gray-800 
                        focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    >
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <input 
                        type="password" 
                        required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm 
                        text-gray-900 dark:text-white 
                        bg-white dark:bg-gray-800 
                        focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    >
                </div>

                <!-- Remember & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                        >
                        <label class="ml-2 block text-sm text-gray-900 dark:text-white">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary-600 hover:text-primary-500">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm 
                    text-sm font-medium text-white 
                    bg-primary-600 hover:bg-primary-700 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                    Sign in
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400">
                            Or continue with
                        </span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-3 gap-3">
                    <button class="w-full inline-flex justify-center py-2 px-4 
                        border border-gray-300 dark:border-gray-700 rounded-md shadow-sm 
                        bg-white dark:bg-gray-800 
                        text-sm font-medium text-gray-500 dark:text-gray-300 
                        hover:bg-gray-50 dark:hover:bg-gray-700">
                        Google
                    </button>
                    <button class="w-full inline-flex justify-center py-2 px-4 
                        border border-gray-300 dark:border-gray-700 rounded-md shadow-sm 
                        bg-white dark:bg-gray-800 
                        text-sm font-medium text-gray-500 dark:text-gray-300 
                        hover:bg-gray-50 dark:hover:bg-gray-700">
                        GitHub
                    </button>
                    <button class="w-full inline-flex justify-center py-2 px-4 
                        border border-gray-300 dark:border-gray-700 rounded-md shadow-sm 
                        bg-white dark:bg-gray-800 
                        text-sm font-medium text-gray-500 dark:text-gray-300 
                        hover:bg-gray-50 dark:hover:bg-gray-700">
                        Twitter
                    </button>
                </div>

                <!-- Sign Up Link -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account? 
                        <a href="#" class="font-medium text-primary-600 hover:text-primary-500">
                            Sign up
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Side: Illustration -->
    <div class="hidden lg:block lg:w-1/2 bg-cover bg-center bg-no-repeat" 
         style="background-image: url('https://source.unsplash.com/random/800x600?login,illustration')">
    </div>
</div>

</body>
</html>
