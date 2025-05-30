<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'orange-primary': '#f97316',
                        'orange-dark': '#ea580c',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-1">Login Karyawan</h2>
        <p class="text-center text-sm text-gray-500 mb-6">Employee Panel</p>

        <form method="POST" action="{{ route('filament.employee.auth.login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" required autofocus
                    class="block w-full rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-800 bg-white shadow-sm focus:border-orange-primary focus:ring-2 focus:ring-orange-primary transition" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                    class="block w-full rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-800 bg-white shadow-sm focus:border-orange-primary focus:ring-2 focus:ring-orange-primary transition" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember"
                        class="h-4 w-4 text-orange-primary focus:ring-orange-primary border-gray-300 rounded" />
                    <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                </label>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-orange-primary hover:bg-orange-dark text-white font-semibold py-2 px-4 rounded-md shadow transition">
                    Masuk
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-orange-primary hover:underline transition">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>