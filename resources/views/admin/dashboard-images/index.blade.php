<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Dashboard Images Management">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            Dashboard Images Management
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            Manage images displayed on the visitor dashboard
                        </p>
                    </div>
                    <a href="{{ route('admin.dashboard-images.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Upload New Image
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-800/30 border border-green-200 dark:border-green-700 rounded-lg p-4">
                    <p class="text-green-700 dark:text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Images by Position -->
            @foreach(['top', 'middle', 'bottom'] as $position)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 capitalize">
                        {{ $position }} Position Images
                    </h2>
                    
                    @if(isset($images[$position]) && $images[$position]->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($images[$position] as $image)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                    <div class="relative">
                                        <img src="{{ Storage::url($image->image_path) }}" 
                                             alt="{{ $image->title }}" 
                                             class="w-full h-48 object-cover">
                                        
                                        <!-- Status Badge -->
                                        <div class="absolute top-2 right-2">
                                            @if($image->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                            {{ $image->title }}
                                        </h3>
                                        @if($image->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                {{ $image->description }}
                                            </p>
                                        @endif
                                        
                                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-3">
                                            <span>Order: {{ $image->display_order }}</span>
                                            <span>Position: {{ ucfirst($image->display_position) }}</span>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.dashboard-images.edit', $image) }}" 
                                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Edit
                                            </a>
                                            
                                            <form method="POST" action="{{ route('admin.dashboard-images.toggle-status', $image) }}" class="flex-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="w-full inline-flex justify-center items-center px-3 py-2 {{ $image->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    {{ $image->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            
                                            <form method="POST" action="{{ route('admin.dashboard-images.destroy', $image) }}" class="flex-1" 
                                                  onsubmit="return confirm('Are you sure you want to delete this image?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-full inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No images</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Get started by uploading a new image for the {{ $position }} position.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('admin.dashboard-images.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Upload Image
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </x-sidebar>
</x-app-layout>
