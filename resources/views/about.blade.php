@extends('components.layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 to-purple-200">
    <div class="bg-white rounded-2xl shadow-xl p-10 max-w-lg w-full text-center">
        <img src="https://ui-avatars.com/api/?name=Ghinan+Hakim&background=4f46e5&color=fff&size=128" alt="Ghinan Hakim" class="mx-auto mb-6 rounded-full shadow-lg border-4 border-indigo-200">
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-2">Ghinan Hakim</h1>
        <p class="text-lg text-gray-600 mb-1">Mahasiswa</p>
        <p class="text-md text-gray-500 mb-4">Telkom University</p>
        <div class="mb-6">
            <span class="inline-block bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full text-xs font-semibold">About This Project</span>
        </div>
        <p class="text-gray-700 mb-4">
            Selamat datang di halaman About yang modern! Halaman ini dibuat menggunakan Laravel, Filament, dan Tailwind CSS.
        </p>
        <div class="flex justify-center gap-4 mt-6">
            <a href="https://telkomuniversity.ac.id/" target="_blank" class="transition hover:scale-105 bg-indigo-600 text-white px-5 py-2 rounded-lg font-semibold shadow hover:bg-indigo-700">Telkom University</a>
            <a href="/" class="transition hover:scale-105 bg-gray-200 text-gray-700 px-5 py-2 rounded-lg font-semibold shadow hover:bg-gray-300">Home</a>
            <a href="/about" class="transition hover:scale-105 bg-green-600 text-white px-5 py-2 rounded-lg font-semibold shadow hover:bg-green-700">About</a>
        </div>
    </div>
</div>
@endsection