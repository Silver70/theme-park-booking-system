<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Operator Dashboard">
        <h1>hello {{ Auth::user()->name }}</h1>
    </x-sidebar>
</x-app-layout>