<?php
// about.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- About Us Content -->
<section id="about-us">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-20 text-center">
        <h1 class="text-5xl font-bold mb-4">About Our Company</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8">We are committed to delivering the best services and solutions to help our clients achieve their goals with innovation and dedication.</p>
        <a href="#team" class="bg-white text-blue-600 font-semibold py-3 px-6 rounded-lg shadow hover:bg-gray-100 transition">Meet Our Team</a>
    </div>

    <!-- Our Story Section -->
    <div class="container mx-auto px-6 md:flex md:items-center md:space-x-12 py-20">
        <div class="md:w-1/2 mb-8 md:mb-0">
            <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=800&q=80" alt="Company Story" class="rounded-lg shadow-lg">
        </div>
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold mb-4">Our Story</h2>
            <p class="mb-4">Founded in 2010, our company has grown from a small startup into a leading provider of innovative solutions. Our journey has been fueled by passion, creativity, and a commitment to excellence.</p>
            <p>We believe in empowering our clients and building long-term partnerships that drive success and growth for everyone involved.</p>
        </div>
    </div>

    <!-- Values Section -->
    <div class="bg-gray-100 py-20 text-center">
        <h2 class="text-3xl font-bold mb-12">Our Core Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-white rounded-lg p-6 shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2">Innovation</h3>
                <p>We continuously explore new ideas and technologies to deliver creative solutions.</p>
            </div>
            <div class="bg-white rounded-lg p-6 shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2">Integrity</h3>
                <p>Honesty, transparency, and ethical practices guide every decision we make.</p>
            </div>
            <div class="bg-white rounded-lg p-6 shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2">Collaboration</h3>
                <p>We believe in teamwork and building strong partnerships to achieve shared success.</p>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div id="team" class="py-20 text-center">
        <h2 class="text-3xl font-bold mb-12">Meet Our Team</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Team Member" class="w-32 h-32 mx-auto rounded-full mb-4">
                <h3 class="font-bold text-xl mb-1">Alice Brown</h3>
                <p class="text-gray-600">CEO</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Team Member" class="w-32 h-32 mx-auto rounded-full mb-4">
                <h3 class="font-bold text-xl mb-1">John Smith</h3>
                <p class="text-gray-600">CTO</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="Team Member" class="w-32 h-32 mx-auto rounded-full mb-4">
                <h3 class="font-bold text-xl mb-1">Emma Lee</h3>
                <p class="text-gray-600">COO</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Team Member" class="w-32 h-32 mx-auto rounded-full mb-4">
                <h3 class="font-bold text-xl mb-1">Michael Chen</h3>
                <p class="text-gray-600">Lead Designer</p>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-blue-600 text-white py-20 text-center">
        <h2 class="text-3xl font-bold mb-4">Join Us on Our Journey</h2>
        <p class="mb-8">Whether you're a client, partner, or aspiring team member, let's create something amazing together.</p>
        <a href="contact.php" class="bg-white text-blue-600 font-semibold py-3 px-6 rounded-lg shadow hover:bg-gray-100 transition">Contact Us</a>
    </div>

    <footer class="bg-gray-800 text-gray-300 py-6 text-center">
        &copy; 2025 Company Name. All rights reserved.
    </footer>
</section>

</body>
</html>
