<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App School | @yield('title')</title>
    <link rel="icon" href="img/icons8-book-16.png" type="image/x-icon">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100 font-sans">
    <!-- Include Navigation Component -->
    @include('components.navbar')
    @include('components.alerts')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Include Footer Component -->
    @include('components.footer')

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
</body>

</html>