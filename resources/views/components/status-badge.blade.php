@props(['status', 'size' => 'sm'])

@php
$sizeClasses = $size === 'lg' ? 'px-2.5 py-0.5 text-xs' : 'px-2 py-1 text-xs';

$colorClasses = match(strtolower($status)) {
    'active' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
    'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100',
    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
    'verified' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
    'unverified' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
    default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400'
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex font-semibold rounded-full {$sizeClasses} {$colorClasses}"]) }}>
    {{ ucfirst($status) }}
</span>
