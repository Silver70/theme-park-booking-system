<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="User Details">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">User Details</h1>
                        <p class="text-gray-600 dark:text-gray-400">View detailed information about this user.</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Back to Users
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- User Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">User Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-medium text-gray-700 dark:text-gray-300">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                                <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                <x-role-badge :user="$user" size="lg" />
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Joined</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $user->created_at ? $user->created_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $user->updated_at ? $user->updated_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Verification</label>
                            <div class="mt-1 flex items-center space-x-3">
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    @if($user->email_verified_at)
                                        <span class="text-green-600 dark:text-green-400">✓ Verified on {{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Unknown date' }}</span>
                                    @else
                                        <span class="text-red-600 dark:text-red-400">✗ Not verified</span>
                                    @endif
                                </p>
                                <form method="POST" action="{{ route('admin.users.toggle-verification', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md transition ease-in-out duration-150
                                        {{ $user->email_verified_at 
                                            ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400 hover:bg-yellow-200 dark:hover:bg-yellow-900/30' 
                                            : 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-900/30' 
                                        }}">
                                        @if($user->email_verified_at)
                                            Remove Verification
                                        @else
                                            Verify Email
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Status</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                @if($user->email_verified_at)
                                    <span class="text-green-600 dark:text-green-400">Active</span>
                                @else
                                    <span class="text-yellow-600 dark:text-yellow-400">Pending Verification</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Activity -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">User Activity</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $user->bookings()->count() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Bookings</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $user->ferryTickets()->count() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Ferry Tickets</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $user->created_at->diffForHumans() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Member Since</div>
                    </div>
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout>
