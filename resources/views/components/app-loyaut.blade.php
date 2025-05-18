<!-- resources/views/components/app-loyaut.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 11</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#22495C] text-white">
    <header></header>
    <main class="flex flex-col items-center justify-start min-h-screen py-10 px-4">
        {{ $slot }}
    </main>
    <footer></footer>
</body>
</html>
