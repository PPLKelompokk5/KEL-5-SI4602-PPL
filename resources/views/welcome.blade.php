<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex flex-col justify-center items-center">
        <h1 class="text-4xl font-bold mb-6">Selamat Datang di Aplikasi</h1>
        <div class="space-x-4">
            <a href="{{ route('admin.login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow">Login Admin</a>
            <a href="{{ route('employee.login') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow">Login Employee</a>
        </div>
    </div>
</body>
</html>