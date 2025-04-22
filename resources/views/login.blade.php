{{-- resources/views/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Heading --}}
            <h1 class="text-2xl font-semibold text-center mb-6">Masuk ke Akun</h1>

            {{-- Flash message sukses (mis. setelah registrasi) --}}
            @if (session('success'))
                <div class="mb-4 text-sm text-green-600 bg-green-100 p-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error summary --}}
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded-lg">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Login form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-200"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-200"
                    >
                </div>

                {{-- Remember me + submit --}}
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="rounded text-indigo-600">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Login
                    </button>
                </div>
            </form>

            {{-- Link ke register --}}
            <p class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
