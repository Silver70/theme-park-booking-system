@props(['menuItems' => [], 'title' => 'Theme Park'])

<!-- Sidebar component -->
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-30 w-64 flex-shrink-0 transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0 flex flex-col">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0">
            <!-- Logo -->
            <div class="flex items-center">
                <span class="text-xl font-semibold text-white">{{ $title }}</span>
            </div>
        </div>

        <!-- Scrollable navigation area -->
        <div class="flex-1 relative">
            <div class="h-full overflow-y-auto scrollbar-hide" id="sidebar-nav">
                <nav class="px-3 mt-3 pb-6">
                    <!-- Navigation Links - Dynamically generated -->
                    @foreach($menuItems as $item)
                        @if(isset($item['children']))
                            <!-- Menu with children/dropdown -->
                            <div class="mb-2">
                                <div class="flex items-center justify-between w-full px-3 py-2 text-gray-300 transition-colors duration-200 rounded-md hover:bg-gray-800 hover:text-white">
                                    <div class="flex items-center">
                                        @if(isset($item['icon']))
                                            @include('components.icons.' . $item['icon'], ['class' => 'w-4 h-4 text-gray-400'])
                                        @endif
                                        <span class="ml-3 text-sm font-medium">{{ $item['name'] }}</span>
                                    </div>
                                </div>
                                <div class="mt-1 ml-6 space-y-1">
                                    @foreach($item['children'] as $child)
                                        <a href="{{ route($child['route']) }}" class="block px-3 py-1.5 text-xs text-gray-400 transition-colors duration-200 rounded-md hover:bg-gray-800 hover:text-white {{ request()->routeIs($child['route']) ? 'bg-gray-800 text-white' : '' }}">
                                            {{ $child['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Regular menu item -->
                            <a href="{{ route($item['route']) }}" class="flex items-center px-3 py-2 mb-1 text-gray-300 transition-colors duration-200 rounded-md hover:bg-gray-800 hover:text-white {{ request()->routeIs($item['route']) ? 'bg-gray-800 text-white' : '' }}">
                                @if(isset($item['icon']))
                                    @include('components.icons.' . $item['icon'], ['class' => 'w-4 h-4 text-gray-400'])
                                @endif
                                <span class="ml-3 text-sm font-medium">{{ $item['name'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>
            <!-- Scroll fade indicators -->
            <div class="scroll-fade-top opacity-0 transition-opacity duration-300" id="scroll-top-fade"></div>
            <div class="scroll-fade-bottom opacity-0 transition-opacity duration-300" id="scroll-bottom-fade"></div>
        </div>

        <!-- User Menu - Fixed at bottom -->
        @auth
        <div class="flex-shrink-0 border-t border-gray-700">
            <div class="px-6 py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="ml-3 min-w-0 flex-1">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-gray-400 hover:text-gray-300 transition-colors">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    </div>

    <!-- Scroll handling script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navContainer = document.getElementById('sidebar-nav');
            const topFade = document.getElementById('scroll-top-fade');
            const bottomFade = document.getElementById('scroll-bottom-fade');
            
            if (navContainer && topFade && bottomFade) {
                function updateScrollIndicators() {
                    const { scrollTop, scrollHeight, clientHeight } = navContainer;
                    const isScrollable = scrollHeight > clientHeight;
                    
                    if (!isScrollable) {
                        topFade.style.opacity = '0';
                        bottomFade.style.opacity = '0';
                        return;
                    }
                    
                    // Show top fade if scrolled down
                    topFade.style.opacity = scrollTop > 10 ? '1' : '0';
                    
                    // Show bottom fade if not at bottom
                    const isAtBottom = scrollTop + clientHeight >= scrollHeight - 10;
                    bottomFade.style.opacity = isAtBottom ? '0' : '1';
                }
                
                navContainer.addEventListener('scroll', updateScrollIndicators);
                
                // Initial check
                setTimeout(updateScrollIndicators, 100);
                
                // Check on resize
                window.addEventListener('resize', updateScrollIndicators);
            }
        });
    </script>

    <!-- Content area -->
    <div class="flex flex-col flex-1 w-full min-w-0">
        <!-- Mobile header -->
        <header class="z-10 py-4 bg-white shadow-md lg:hidden">
            <div class="flex items-center justify-between px-6">
                <span class="text-xl font-semibold">{{ $title }}</span>
            </div>
        </header>
        
        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-gray-100">
            <div class="container px-6 py-8 mx-auto">
                {{ $slot ?? '' }}
            </div>
        </main>
    </div>
</div>