<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Edit User">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">User Information</h1>
                        <p class="text-gray-600 dark:text-gray-400">View user details (read-only mode).</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View User Details
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Back to Users
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Information (Read Only) -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                        </div>
                    </div>
                    
                    <!-- Role and Status -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                            <x-role-badge :user="$user" size="lg" />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Verification</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if($user->email_verified_at)
                                    <span class="text-green-600 dark:text-green-400">✓ Verified on {{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Unknown date' }}</span>
                                @else
                                    <span class="text-red-600 dark:text-red-400">✗ Not verified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Joined</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $user->created_at ? $user->created_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $user->updated_at ? $user->updated_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Note -->
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                <strong>Note:</strong> User information is displayed in read-only mode. For security reasons, admins cannot modify user emails, passwords, or personal information. Users must manage their own account details through their profile settings.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout>
