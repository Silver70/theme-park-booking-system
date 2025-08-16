<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Ticket Requests">
        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <div class="p-6">
                <!-- Error Message -->
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm8.707-8.707a1 1 0 00-1.414-1.414L11 9.586 9.707 8.293a1 1 0 00-1.414 1.414L10.586 11l-1.293 1.293a1 1 0 101.414 1.414L12 12.414l1.293 1.293a1 1 0 001.414-1.414L13.414 11l1.293-1.293a1 1 0 00-1.414-1.414L12 9.586l-1.293-1.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="list-disc list-inside text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Ferry Ticket Requests</h1>
                    <p class="text-gray-600 mt-1">Review and validate ferry ticket requests from visitors</p>
                </div>

                <!-- Requests Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pending Requests</h3>
                    </div>
                    
                    @if($requests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Request ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ferry Schedule
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tickets
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Hotel Booking
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($requests as $request)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $request->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm">
                                                    <div class="font-medium text-gray-900">{{ $request->user->name }}</div>
                                                    <div class="text-gray-500">{{ $request->user->email }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $request->ferrySchedule->departure_time->format('M d, Y g:i A') }}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{ $request->ferrySchedule->origin }} → {{ $request->ferrySchedule->destination }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="text-center">
                                                    <div class="font-medium">{{ $request->quantity }}</div>
                                                    <div class="text-gray-500">${{ number_format($request->total_price, 2) }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm">
                                                    <div class="font-medium text-gray-900">
                                                        Room: {{ $request->booking->room->name }}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{ $request->booking->check_in_date->format('M d') }} - {{ $request->booking->check_out_date->format('M d, Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-400">
                                                        Booking #{{ $request->booking->id }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $request->status_badge_color }}">
                                                    {{ $request->status_text }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($request->isPending())
                                                    <div class="flex items-center space-x-2">
                                                        <form action="{{ route('ferry.requests.approve', $request->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                                Approve
                                                            </button>
                                                        </form>
                                                        
                                                        <button type="button" 
                                                                onclick="openDenyModal({{ $request->id }})"
                                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                            Deny
                                                        </button>
                                                    </div>
                                                @elseif($request->isApproved())
                                                    <div class="text-green-600 text-xs">
                                                        Approved by {{ $request->approver->name ?? 'Staff' }}<br>
                                                        {{ $request->approved_at->format('M d, g:i A') }}
                                                    </div>
                                                @elseif($request->isDenied())
                                                    <div class="text-red-600 text-xs">
                                                        Denied on {{ $request->denied_at->format('M d, g:i A') }}<br>
                                                        @if($request->denial_reason)
                                                            Reason: {{ Str::limit($request->denial_reason, 30) }}
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 py-8 text-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Ticket Requests</h3>
                            <p class="text-gray-500">There are no ferry ticket requests to review at the moment.</p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if($requests->hasPages())
                    <div class="mt-6 bg-white rounded-lg shadow border border-gray-200 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <!-- Pagination Info -->
                            <div class="flex items-center text-sm text-gray-500">
                                <span>Showing</span>
                                <span class="font-medium text-gray-900 mx-1">{{ $requests->firstItem() }}</span>
                                <span>to</span>
                                <span class="font-medium text-gray-900 mx-1">{{ $requests->lastItem() }}</span>
                                <span>of</span>
                                <span class="font-medium text-gray-900 mx-1">{{ $requests->total() }}</span>
                                <span>results</span>
                            </div>

                            <!-- Pagination Links -->
                            <div class="flex items-center space-x-1">
                                {{-- Previous Page Link --}}
                                @if ($requests->onFirstPage())
                                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-l-md">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-1">Previous</span>
                                    </span>
                                @else
                                    <a href="{{ $requests->previousPageUrl() }}" 
                                       class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                             <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                         </svg>
                                         <span class="ml-1">Previous</span>
                                     </a>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($requests->hasMorePages())
                                    <a href="{{ $requests->nextPageUrl() }}" 
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
                    </div>
                @endif
            </div>
        </div>
    </x-sidebar>

    <!-- Deny Request Modal -->
    <div id="denyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Deny Ticket Request</h3>
                <form id="denyForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="denial_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for Denial *
                        </label>
                        <textarea name="denial_reason" id="denial_reason" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Please provide a reason for denying this request..."></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeDenyModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Deny Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDenyModal(requestId) {
            const modal = document.getElementById('denyModal');
            const form = document.getElementById('denyForm');
            form.action = `/ferry/requests/${requestId}/deny`;
            modal.classList.remove('hidden');
        }

        function closeDenyModal() {
            const modal = document.getElementById('denyModal');
            modal.classList.add('hidden');
            document.getElementById('denial_reason').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('denyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDenyModal();
            }
        });
    </script>
</x-app-layout>
