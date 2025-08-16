@props(['room'])



<div class="max-w-xl bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <a href="#">
        @if($room->image)
            @if(str_starts_with($room->image, 'http'))
                {{-- External URL image --}}
                <img class="rounded-t-lg h-48 w-full object-cover" src="{{ $room->image }}" alt="{{ $room->name }}" />
            @else
                {{-- Uploaded file image --}}
                <img class="rounded-t-lg h-48 w-full object-cover" src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" />
            @endif
        @else
            {{-- Default placeholder when no image --}}
            <div class="rounded-t-lg h-48 w-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                <span class="text-white text-lg font-semibold">{{ $room->name }}</span>
            </div>
        @endif
    </a>
    <div class="p-5">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $room->name }}</h5>
        </a>
        <p class="mb-3 font-bold text-gray-700 ">${{ $room->price }}</p>
        <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Book Now
             <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
        </a>
    </div>
</div>

