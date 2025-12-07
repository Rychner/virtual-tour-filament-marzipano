<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Tour</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen w-screen">

    <!-- Background -->
    <div class="relative h-full w-full bg-cover bg-center"
        style="background-image: url('{{ asset('storage/images/unnamed.webp') }}');">

        <!-- Top Menu -->
        <nav class="absolute top-0 right-0 m-8">
            <ul class="flex space-x-8 text-white font-semibold text-lg drop-shadow-lg">
                <li><a href="/" class="hover:text-gray-300">Virtual Tour</a></li>
                <li><a href="/about" class="hover:text-gray-300">About</a></li>
                <li><a href="/contact" class="hover:text-gray-300">Contact</a></li>
            </ul>
        </nav>

        <!-- Center Button -->
        <div class="absolute inset-0 flex items-center justify-center">
            <a href="{{ route('virtualtour.start') }}"
                class="px-10 py-4 bg-white/90 text-gray-900 text-2xl font-bold rounded-xl shadow-lg hover:bg-white transition">
                Start Virtual Tour
            </a>
        </div>

    </div>

</body>
</html>