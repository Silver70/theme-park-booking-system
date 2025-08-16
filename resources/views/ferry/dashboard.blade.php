<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Operator Dashboard">
        <h1>hello {{ Auth::user()->name }}</h1>
        
        <!-- Debug Information -->
        <div class="mt-4 p-4 bg-gray-100 rounded-lg">
            <h3 class="font-semibold mb-2">Debug: Menu Items</h3>
            <pre class="text-sm">{{ print_r($menuItems, true) }}</pre>
        </div>
    </x-sidebar>
</x-app-layout>