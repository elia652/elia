<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Example</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Header Section -->
    <header class="bg-blue-600 text-white py-4">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-3xl font-bold">My Tailwind Website</h1>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Left Column -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Left Column</h2>
                <p>This is the left column. You can add any content here.</p>
            </div>

            <!-- Middle Column -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Middle Column</h2>
                <p>This is the middle column. Tailwind CSS makes it easy to style the content.</p>
            </div>

            <!-- Right Column -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Right Column</h2>
                <p>This is the right column. You can modify the layout based on your requirements.</p>
            </div>

        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p>&copy; 2025 My Website | All Rights Reserved</p>
        </div>
    </footer>

</body>
</html>
