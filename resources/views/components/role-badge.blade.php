@props(['user', 'size' => 'sm'])

@php
$role = $user ? ($user->getRoleNames()->first() ?? 'No Role') : 'N/A';
$sizeClasses = $size === 'lg' ? 'px-2.5 py-0.5 text-xs' : 'px-2 py-1 text-xs';

$colorClasses = match($role) {
    'admin' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
    'hotel_manager' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
    'hotel_staff' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400',
    'ferry_operator' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
    'visitor' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400',
    default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400'
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex font-semibold rounded-full {$sizeClasses} {$colorClasses}"]) }}>
    {{ $role }}
</span>
