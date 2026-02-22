@props(['action'])

@php
$actionColors = [
    // CRUD Operations
    'CREATE' => 'bg-green-100 text-green-800 border-green-200',
    'UPDATE' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
    'DELETE' => 'bg-red-100 text-red-800 border-red-200',
    'DELETE_PERMANENT' => 'bg-red-200 text-red-900 border-red-300',
    
    // Authentication
    'LOGIN' => 'bg-blue-100 text-blue-800 border-blue-200',
    'REGISTER' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
    'LOGOUT' => 'bg-gray-100 text-gray-800 border-gray-200',
    'LOGIN_FAILED' => 'bg-orange-100 text-orange-800 border-orange-200',
    
    // Data Operations
    'EXPORT' => 'bg-purple-100 text-purple-800 border-purple-200',
    
    // Archive Operations
    'ARCHIVE' => 'bg-amber-100 text-amber-800 border-amber-200',
    'RESTORE' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
    
    // Announcements
    'ANNOUNCEMENT_CREATE' => 'bg-teal-100 text-teal-800 border-teal-200',
    'ANNOUNCEMENT_UPDATE' => 'bg-lime-100 text-lime-800 border-lime-200',
    'ANNOUNCEMENT_DELETE' => 'bg-rose-100 text-rose-800 border-rose-200',
    
    // View/Access
    'VIEW' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
];

$colorClass = $actionColors[$action] ?? 'bg-gray-100 text-gray-800 border-gray-200';
@endphp

<span class="px-2 py-1 text-xs font-medium rounded-full border {{ $colorClass }}">
    {{ $action }}
</span>