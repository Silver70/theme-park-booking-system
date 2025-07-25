<x-app-layout>
  <x-sidebar :menuItems="$menuItems" title="Ferry Schedules">
        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <div class="p-6">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mb-6 flex justify-between items-center">
                    <div >
                        <h1 class="text-2xl font-bold text-gray-900">Ferry Schedules</h1>
                        <p class="text-gray-600 mt-1">Manage and view all ferry departure schedules</p>
                    </div>
                    <a href="{{ route('ferry.schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                          
                        Create Schedule
                    </a>
                </div>

                <!-- Schedules Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Current Schedules</h3>
                    </div>
                    
                    @if($schedules->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Departure Time
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ferry
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Route
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Available Seats
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($schedules as $schedule)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $schedule->departure_time->format('M j, Y - g:i A') }}
                                            </td>
                                                                                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                 <div class="font-medium text-gray-900">Ferry #{{ $schedule->id }}</div>
                                                 <div class="text-xs text-gray-500">ID: {{ $schedule->id }}</div>
                                             </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center">
                                                    <span>{{ $schedule->origin }}</span>
                                                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                    </svg>
                                                    <span>{{ $schedule->destination }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $schedule->seats_available }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($schedule->departure_time->isPast())
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Completed
                                                    </span>
                                                @elseif($schedule->seats_available > 30)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Available
                                                    </span>
                                                @elseif($schedule->seats_available > 10)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Limited
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Few Seats
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 py-8 text-center">
                            <p class="text-gray-500">No ferry schedules found.</p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if($schedules->hasPages())
                    <div class="mt-6 bg-white rounded-lg shadow border border-gray-200 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <!-- Pagination Info -->
                            <div class="flex items-center text-sm text-gray-500">
                                <span>Showing</span>
                                <span class="font-medium text-gray-900 mx-1">{{ $schedules->firstItem() }}</span>
                                <span>to</span>
                                <span class="font-medium text-gray-900 mx-1">{{ $schedules->lastItem() }}</span>
                                <span>of</span>
                                <span class="font-medium text-gray-900 mx-1">{{ $schedules->total() }}</span>
                                <span>results</span>
                            </div>

                            <!-- Pagination Links -->
                            <div class="flex items-center space-x-1">
                                {{-- Previous Page Link --}}
                                @if ($schedules->onFirstPage())
                                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-l-md">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-1">Previous</span>
                                    </span>
                                @else
                                    <a href="{{ $schedules->previousPageUrl() }}" 
                                       class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                             <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                         </svg>
                                         <span class="ml-1">Previous</span>
                                     </a>
                                 @endif

                                 {{-- Page Numbers --}}
                                 @php
                                     $start = max(1, $schedules->currentPage() - 2);
                                     $end = min($schedules->lastPage(), $schedules->currentPage() + 2);
                                 @endphp

                                 {{-- First page link if not in range --}}
                                 @if($start > 1)
                                     <a href="{{ $schedules->url(1) }}" 
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                         1
                                     </a>
                                     @if($start > 2)
                                         <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                                             ...
                                         </span>
                                     @endif
                                 @endif

                                 {{-- Page number links --}}
                                 @for ($page = $start; $page <= $end; $page++)
                                     @if ($page == $schedules->currentPage())
                                         <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600">
                                             {{ $page }}
                                         </span>
                                     @else
                                         <a href="{{ $schedules->url($page) }}" 
                                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                             {{ $page }}
                                         </a>
                                     @endif
                                 @endfor

                                 {{-- Last page link if not in range --}}
                                 @if($end < $schedules->lastPage())
                                     @if($end < $schedules->lastPage() - 1)
                                         <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                                             ...
                                         </span>
                                     @endif
                                     <a href="{{ $schedules->url($schedules->lastPage()) }}" 
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                         {{ $schedules->lastPage() }}
                                     </a>
                                 @endif

                                 {{-- Next Page Link --}}
                                 @if ($schedules->hasMorePages())
                                     <a href="{{ $schedules->nextPageUrl() }}" 
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                         <span class="mr-1">Next</span>
                                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                             <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                         </svg>
                                     </a>
                                 @else
                                     <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-r-md">
                                         <span class="mr-1">Next</span>
                                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                             <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                         </svg>
                                     </span>
                                 @endif
                             </div>
                         </div>

                         <!-- Mobile-friendly pagination (hidden on desktop) -->
                         <div class="flex items-center justify-between mt-4 sm:hidden">
                             @if ($schedules->onFirstPage())
                                 <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-md">
                                     Previous
                                 </span>
                             @else
                                 <a href="{{ $schedules->previousPageUrl() }}" 
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                     Previous
                                 </a>
                             @endif

                             <div class="flex items-center space-x-1">
                                 <span class="text-sm text-gray-500">
                                     Page {{ $schedules->currentPage() }} of {{ $schedules->lastPage() }}
                                 </span>
                             </div>

                             @if ($schedules->hasMorePages())
                                 <a href="{{ $schedules->nextPageUrl() }}" 
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                     Next
                                 </a>
                             @else
                                 <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-md">
                                     Next
                                 </span>
                             @endif
                         </div>
                     </div>
                 @endif
             </div>
         </div>
     </x-sidebar>
 </x-app-layout>



