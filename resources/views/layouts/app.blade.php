<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sewa Mobil')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        
        .sidebar-expanded {
            width: 260px;
        }
        
        .sidebar-collapsed {
            width: 70px;
        }
        
        .content-expanded {
            margin-left: 260px;
        }
        
        .content-collapsed {
            margin-left: 70px;
        }
        
        @media (max-width: 1024px) {
            .sidebar-expanded {
                width: 70px;
            }
            
            .content-expanded {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar-mobile-hidden {
                transform: translateX(-100%);
            }
            
            .sidebar-mobile-visible {
                transform: translateX(0);
            }
            
            .content-expanded, .content-collapsed {
                margin-left: 0;
            }
            
            .sidebar-expanded, .sidebar-collapsed {
                width: 260px;
            }
        }
        
        /* Toast animation */
        .toast-enter-active {
            transition: all 0.3s ease;
        }
        
        .toast-leave-active {
            transition: all 0.3s ease;
        }
        
        .toast-enter-from {
            opacity: 0;
            transform: translateY(-20px);
        }
        
        .toast-leave-to {
            opacity: 0;
            transform: translateY(-20px);
        }
    </style>
</head>
<body class="bg-gray-100" x-data="{ 
    sidebarOpen: false, 
    sidebarCollapsed: false,
    activeMenu: window.location.pathname.split('/')[1] || (window.location.pathname === '/dashboard' ? 'dashboard' : ''),
    toasts: [],
    addToast(message, type = 'success') {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        setTimeout(() => {
            this.removeToast(id);
        }, 5000);
    },
    removeToast(id) {
        this.toasts = this.toasts.filter(toast => toast.id !== id);
    }
}" x-init="
    @if(session('success'))
        addToast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        addToast('{{ session('error') }}', 'error');
    @endif
">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside 
            class="bg-gray-800 text-white fixed h-full z-30 sidebar-transition"
            :class="{
                'sidebar-expanded': !sidebarCollapsed,
                'sidebar-collapsed': sidebarCollapsed,
                'sidebar-mobile-hidden': !sidebarOpen,
                'sidebar-mobile-visible': sidebarOpen
            }"
        >
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <div x-show="!sidebarCollapsed" class="flex items-center space-x-2">
                    <i class="fas fa-car text-blue-400 text-xl"></i>
                    <span class="font-bold text-lg">Sewa Mobil</span>
                </div>
                <div x-show="sidebarCollapsed" class="flex justify-center">
                    <i class="fas fa-car text-blue-400 text-xl"></i>
                </div>
                <button 
                    @click="sidebarCollapsed = !sidebarCollapsed" 
                    class="text-gray-400 hover:text-white focus:outline-none lg:hidden"
                    x-show="!sidebarCollapsed"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="mt-5">
                <!-- Menu untuk semua user (admin dan user) -->
                @auth
                <a 
                    href="{{ route('dashboard') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium transition-colors duration-200"
                    :class="activeMenu === 'dashboard' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
                >
                    <i class="fas fa-home mr-3"></i>
                    <span x-show="!sidebarCollapsed">Dashboard</span>
                </a>
                @endauth
                
                <!-- Menu khusus admin -->
                @auth
                @if(Auth::user()->isAdmin())
                <a 
                    href="{{ route('mobils.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium transition-colors duration-200"
                    :class="activeMenu === 'mobils' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
                >
                    <i class="fas fa-car mr-3"></i>
                    <span x-show="!sidebarCollapsed">Mobil</span>
                </a>
                
                <a 
                    href="{{ route('stoks.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium transition-colors duration-200"
                    :class="activeMenu === 'stoks' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
                >
                    <i class="fas fa-warehouse mr-3"></i>
                    <span x-show="!sidebarCollapsed">Stok</span>
                </a>
                
                <a 
                    href="{{ route('transaksis.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium transition-colors duration-200"
                    :class="activeMenu === 'transaksis' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
                >
                    <i class="fas fa-exchange-alt mr-3"></i>
                    <span x-show="!sidebarCollapsed">Transaksi</span>
                </a>
                
                <a 
                    href="{{ route('customers.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium transition-colors duration-200"
                    :class="activeMenu === 'customers' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
                >
                    <i class="fas fa-users mr-3"></i>
                    <span x-show="!sidebarCollapsed">Customer</span>
                </a>
                @endif
                @endauth
                
                <!-- Menu khusus user (kasir) -->
                @auth
                @if(Auth::user()->isKasir())
                <a 
                    href="{{ route('mobils.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium transition-colors duration-200"
                    :class="activeMenu === 'mobils' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
                >
                    <i class="fas fa-car mr-3"></i>
                    <span x-show="!sidebarCollapsed">Mobil</span>
                </a>
                
                <a 
                    href="{{ route('stoks.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium transition-colors duration-200"
                    :class="activeMenu === 'stoks' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
                >
                    <i class="fas fa-warehouse mr-3"></i>
                    <span x-show="!sidebarCollapsed">Stok</span>
                </a>
                
                <a 
                    href="{{ route('transaksis.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium transition-colors duration-200"
                    :class="activeMenu === 'transaksis' ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
                >
                    <i class="fas fa-exchange-alt mr-3"></i>
                    <span x-show="!sidebarCollapsed">Transaksi</span>
                </a>
                @endif
                @endauth
            </nav>
        </aside>

        <!-- Main Content -->
        <div 
            class="flex-1 flex flex-col sidebar-transition"
            :class="{
                'content-expanded': !sidebarCollapsed,
                'content-collapsed': sidebarCollapsed
            }"
        >
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button 
                            @click="sidebarOpen = !sidebarOpen" 
                            class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden mr-4"
                        >
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <button 
                            @click="sidebarCollapsed = !sidebarCollapsed" 
                            class="text-gray-500 hover:text-gray-700 focus:outline-none hidden lg:block mr-4"
                        >
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <a href="{{ route('dashboard') }}" class="flex items-center text-gray-800 hover:text-blue-600">
                            <i class="fas fa-home text-xl mr-2"></i>
                            <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
                            </button>
                        </div>
                        
                        @auth
                        <div class="relative" x-data="{ dropdownOpen: false }">
                            <button 
                                @click="dropdownOpen = !dropdownOpen" 
                                class="flex items-center space-x-2 focus:outline-none"
                            >
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                    <span class="text-white font-semibold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="hidden md:inline text-gray-700">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                            
                            <div 
                                x-show="dropdownOpen" 
                                @click.away="dropdownOpen = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                            >
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-home mr-2"></i> Dashboard
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <div class="px-4 py-2 text-xs text-gray-500">
                                    <i class="fas fa-user-tag mr-2"></i> {{ Auth::user()->role_label }}
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Toast Notifications -->
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 space-y-2 w-full max-w-md px-4">
        <template x-for="toast in toasts" :key="toast.id">
            <div 
                x-show="toasts.includes(toast)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                :class="{
                    'bg-green-500 text-white': toast.type === 'success',
                    'bg-red-500 text-white': toast.type === 'error'
                }"
                class="rounded-lg shadow-lg p-4 flex items-center justify-between"
            >
                <div class="flex items-center">
                    <i 
                        :class="{
                            'fas fa-check-circle': toast.type === 'success',
                            'fas fa-exclamation-circle': toast.type === 'error'
                        }"
                        class="text-xl mr-2"
                    ></i>
                    <span x-text="toast.message"></span>
                </div>
                <button @click="removeToast(toast.id)" class="text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </template>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Perbarui activeMenu saat halaman dimuat
            const path = window.location.pathname;
            const segments = path.split('/').filter(segment => segment.length > 0);
            
            if (segments.length > 0) {
                // Temukan elemen sidebar dengan Alpine.js dan perbarui activeMenu
                const sidebarElement = document.querySelector('[x-data]');
                if (sidebarElement && sidebarElement.__x) {
                    sidebarElement.__x.$data.activeMenu = segments[0];
                }
            } else if (path === '/dashboard') {
                const sidebarElement = document.querySelector('[x-data]');
                if (sidebarElement && sidebarElement.__x) {
                    sidebarElement.__x.$data.activeMenu = 'dashboard';
                }
            }
        });
        
        // Perbarui activeMenu saat link di sidebar diklik
        document.addEventListener('click', function(e) {
            const sidebarLinks = document.querySelectorAll('a.flex.items-center.px-4.py-3');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const href = this.getAttribute('href');
                    const segments = href.split('/').filter(segment => segment.length > 0);
                    
                    if (segments.length > 0) {
                        const sidebarElement = document.querySelector('[x-data]');
                        if (sidebarElement && sidebarElement.__x) {
                            sidebarElement.__x.$data.activeMenu = segments[0];
                        }
                    } else if (href === '/dashboard') {
                        const sidebarElement = document.querySelector('[x-data]');
                        if (sidebarElement && sidebarElement.__x) {
                            sidebarElement.__x.$data.activeMenu = 'dashboard';
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
