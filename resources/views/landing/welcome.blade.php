<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                        orange: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #ffffff 0%, #fef3c7 25%, #f59e0b 75%, #f97316 100%);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        .pulse-glow {
            animation: pulseGlow 2s infinite;
        }
        
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(251, 146, 60, 0.4); }
            50% { box-shadow: 0 0 30px rgba(251, 146, 60, 0.8); }
        }
    </style>
</head>
<body class="min-h-screen gradient-bg">
    <!-- Navigation -->
    <nav class="bg-white/20 backdrop-blur-md border-b border-orange-200/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-project-diagram text-orange-500 text-xl"></i>
                    </div>
                    <h1 class="text-gray-800 text-xl font-bold">Project Management System</h1>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="#features" class="text-gray-700 hover:text-orange-600 transition-colors font-medium">Features</a>
                    <a href="#about" class="text-gray-700 hover:text-orange-600 transition-colors font-medium">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-orange-600 transition-colors font-medium">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center px-4">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="floating absolute top-20 left-10 w-20 h-20 bg-white/30 rounded-full shadow-lg"></div>
            <div class="floating absolute top-40 right-20 w-16 h-16 bg-orange-200/40 rounded-full shadow-lg" style="animation-delay: 1s;"></div>
            <div class="floating absolute bottom-40 left-20 w-12 h-12 bg-yellow-200/40 rounded-full shadow-lg" style="animation-delay: 2s;"></div>
            <div class="floating absolute bottom-20 right-10 w-24 h-24 bg-white/20 rounded-full shadow-lg" style="animation-delay: 0.5s;"></div>
        </div>

        <div class="max-w-6xl mx-auto text-center fade-in">
            <!-- Main Title -->
            <div class="mb-8">
                <h1 class="text-5xl md:text-7xl font-bold text-gray-800 mb-6">
                    Project Management
                    <span class="block text-orange-600">System</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
                    Kelola data client consultant dan kontrol sistem manajemen dengan mudah dan efisien
                </p>
            </div>

            <!-- Features Icons -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white/60 backdrop-blur-md rounded-xl p-6 hover-scale shadow-lg border border-orange-100">
                    <i class="fas fa-users text-4xl text-orange-600 mb-4"></i>
                    <h3 class="text-gray-800 text-lg font-semibold mb-2">Client Management</h3>
                    <p class="text-gray-600">Kelola data client dengan sistem yang terorganisir</p>
                </div>
                <div class="bg-white/60 backdrop-blur-md rounded-xl p-6 hover-scale shadow-lg border border-orange-100">
                    <i class="fas fa-chart-line text-4xl text-orange-600 mb-4"></i>
                    <h3 class="text-gray-800 text-lg font-semibold mb-2">Analytics</h3>
                    <p class="text-gray-600">Monitor progress dan performa proyek secara real-time</p>
                </div>
                <div class="bg-white/60 backdrop-blur-md rounded-xl p-6 hover-scale shadow-lg border border-orange-100">
                    <i class="fas fa-shield-alt text-4xl text-orange-600 mb-4"></i>
                    <h3 class="text-gray-800 text-lg font-semibold mb-2">Secure System</h3>
                    <p class="text-gray-600">Sistem keamanan tingkat tinggi untuk data Anda</p>
                </div>
            </div>

            <!-- Login Buttons -->
            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                <!-- Employee Login (Primary) -->
                <a href="http://127.0.0.1:8000/employee" 
                   class="group relative bg-white text-orange-600 px-12 py-6 rounded-2xl font-bold text-xl hover-scale pulse-glow transition-all duration-300 shadow-2xl border-2 border-orange-200">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-user-tie text-2xl"></i>
                        <div class="text-left">
                            <div class="text-2xl font-bold">Employee Login</div>
                            <div class="text-sm text-orange-500 font-normal">Portal Utama Karyawan</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                </a>

                <!-- Admin Login (Secondary) -->
                <a href="http://127.0.0.1:8000/admin" 
                   class="group relative bg-white/70 backdrop-blur-md border-2 border-orange-300 text-gray-700 px-8 py-4 rounded-xl font-semibold text-lg hover-scale transition-all duration-300 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-shield text-xl text-orange-600"></i>
                        <div class="text-left">
                            <div class="text-lg font-semibold">Admin Login</div>
                            <div class="text-xs text-gray-500 font-normal">Panel Administrator</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-orange-100 rounded-xl opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                </a>
            </div>

            <!-- Additional Info -->
            <div class="mt-12 text-gray-600">
                <p class="text-sm">
                    <i class="fas fa-info-circle mr-2 text-orange-500"></i>
                    Pilih portal sesuai dengan role akses Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white/40 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan</h2>
                <p class="text-gray-600 text-lg">Solusi lengkap untuk manajemen proyek dan client</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/80 backdrop-blur-md rounded-xl p-6 text-center hover-scale shadow-lg border border-orange-100">
                    <i class="fas fa-database text-3xl text-orange-600 mb-4"></i>
                    <h3 class="text-gray-800 font-semibold mb-2">Data Management</h3>
                    <p class="text-gray-600 text-sm">Kelola database client dan proyek</p>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-xl p-6 text-center hover-scale shadow-lg border border-orange-100">
                    <i class="fas fa-tasks text-3xl text-orange-600 mb-4"></i>
                    <h3 class="text-gray-800 font-semibold mb-2">Task Tracking</h3>
                    <p class="text-gray-600 text-sm">Monitor progress setiap task</p>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-xl p-6 text-center hover-scale shadow-lg border border-orange-100">
                    <i class="fas fa-file-alt text-3xl text-orange-600 mb-4"></i>
                    <h3 class="text-gray-800 font-semibold mb-2">Reporting</h3>
                    <p class="text-gray-600 text-sm">Laporan komprehensif</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white/60">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Tentang Sistem Kami</h2>
                    <p class="text-gray-600 text-lg mb-6">
                        Project Management System dirancang khusus untuk membantu perusahaan consultant 
                        dalam mengelola client, proyek, dan tim dengan lebih efisien.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-orange-500"></i>
                            <span class="text-gray-700">Interface yang user-friendly</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-orange-500"></i>
                            <span class="text-gray-700">Sistem keamanan berlapis</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-orange-500"></i>
                            <span class="text-gray-700">Real-time monitoring</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-orange-500"></i>
                            <span class="text-gray-700">Laporan detail dan analytics</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-xl border border-orange-100">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-orange-600">500+</div>
                                <div class="text-gray-600">Projects</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-orange-600">100+</div>
                                <div class="text-gray-600">Clients</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-orange-600">50+</div>
                                <div class="text-gray-600">Consultants</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-orange-600">99%</div>
                                <div class="text-gray-600">Uptime</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-project-diagram text-orange-500"></i>
                        </div>
                        <h3 class="text-white font-bold">Project Management System</h3>
                    </div>
                    <p class="text-gray-300">
                        Solusi terpercaya untuk manajemen proyek dan client consultant.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <div class="space-y-2">
                        <a href="#features" class="block text-gray-300 hover:text-orange-400 transition-colors">Features</a>
                        <a href="#about" class="block text-gray-300 hover:text-orange-400 transition-colors">About</a>
                        <a href="http://127.0.0.1:8000/employee" class="block text-gray-300 hover:text-orange-400 transition-colors">Employee Portal</a>
                        <a href="http://127.0.0.1:8000/admin" class="block text-gray-300 hover:text-orange-400 transition-colors">Admin Portal</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact Info</h4>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2 text-gray-300">
                            <i class="fas fa-envelope text-orange-400"></i>
                            <span>info@projectmanagement.com</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-300">
                            <i class="fas fa-phone text-orange-400"></i>
                            <span>+62 123 456 7890</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-300">
                            <i class="fas fa-map-marker-alt text-orange-400"></i>
                            <span>Jakarta, Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; 2024 Project Management System. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Interactivity -->
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navigation
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('bg-white/40');
                nav.classList.remove('bg-white/20');
            } else {
                nav.classList.add('bg-white/20');
                nav.classList.remove('bg-white/40');
            }
        });

        // Add entrance animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        // Observe all sections
        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });

        // Add click effect to buttons
        document.querySelectorAll('a[href*="127.0.0.1"]').forEach(button => {
            button.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('div');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(251,146,60,0.3)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.left = '50%';
                ripple.style.top = '50%';
                ripple.style.width = '20px';
                ripple.style.height = '20px';
                ripple.style.marginLeft = '-10px';
                ripple.style.marginTop = '-10px';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>