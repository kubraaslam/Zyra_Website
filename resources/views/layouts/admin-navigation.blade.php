<nav class="bg-gray-200 rounded-lg p-1 text-gray-600 text-sm font-semibold space-x-4 text-center justify-center inline-flex">
    <x-admin-nav-link href="{{ route('admin.dashboard') }}" route="admin.dashboard">Overview</x-admin-nav-link>
    <x-admin-nav-link href="{{ route('admin.dashboard') }}" route="admin.dashboard">Products</x-admin-nav-link>
    <x-admin-nav-link href="{{ route('admin.dashboard') }}" route="admin.dashboard">Orders</x-admin-nav-link>
    <x-admin-nav-link href="{{ route('admin.dashboard') }}" route="admin.dashboard">Customers</x-admin-nav-link>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="hover:bg-red-600 px-3 py-2 rounded">Logout</button>
    </form>
</nav>