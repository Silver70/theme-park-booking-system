@props(['menuItems' => [], 'title' => 'Theme Park'])

<!-- Sidebar component -->
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-30 w-64 flex-shrink-0 transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
        <div class="flex items-center justify-between px-6 py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <span class="text-xl font-semibold text-white">{{ $title }}</span>
            </div>
        </div>

        <nav class="px-3 mt-6">
            <!-- Navigation Links - Dynamically generated -->
            @foreach($menuItems as $item)
                @if(isset($item['children']))
                    <!-- Menu with children/dropdown -->
                    <div class="mt-3">
                        <div class="flex items-center justify-between w-full px-3 py-2 text-gray-300 transition-colors duration-200 rounded-md hover:bg-gray-800 hover:text-white">
                            <div class="flex items-center">
                                @if(isset($item['icon']))
                                    @include('components.icons.' . $item['icon'], ['class' => 'w-5 h-5 text-gray-400'])
                                @endif
                                <span class="mx-3">{{ $item['name'] }}</span>
                            </div>
                        </div>
                        <div class="mt-2 space-y-1 px-3">
                            @foreach($item['children'] as $child)
                                <a href="{{ route($child['route']) }}" class="block px-3 py-2 text-sm text-gray-400 transition-colors duration-200 rounded-md hover:bg-gray-800 hover:text-white {{ request()->routeIs($child['route']) ? 'bg-gray-800 text-white' : '' }}">
                                    {{ $child['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Regular menu item -->
                    <a href="{{ route($item['route']) }}" class="flex items-center px-3 py-2 {{ !$loop->first ? 'mt-3' : '' }} text-gray-300 transition-colors duration-200 rounded-md hover:bg-gray-800 hover:text-white {{ request()->routeIs($item['route']) ? 'bg-gray-800 text-white' : '' }}">
                        @if(isset($item['icon']))
                            @include('components.icons.' . $item['icon'], ['class' => 'w-5 h-5 text-gray-400'])
                        @endif
                        <span class="mx-3">{{ $item['name'] }}</span>
                    </a>
                @endif
            @endforeach
        </nav>

        <!-- User Menu -->
        @auth
        <div class="absolute bottom-0 w-full">
            <div class="px-6 py-4 border-t border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-gray-400 hover:text-gray-300">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    </div>

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