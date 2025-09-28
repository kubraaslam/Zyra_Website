<nav
    class="bg-gray-200 rounded-lg p-1 text-gray-600 text-sm font-semibold space-x-4 px-2 text-center justify-center inline-flex">
    <x-admin-nav-link href="{{ route('admin.dashboard') }}" route="admin.dashboard">Overview</x-admin-nav-link>
    <x-admin-nav-link href="{{ route('admin.products') }}" route="admin.products">Products</x-admin-nav-link>
    <x-admin-nav-link href="{{ route('admin.orders') }}" route="admin.orders">Orders</x-admin-nav-link>
    <x-admin-nav-link href="{{ route('admin.customers') }}" route="admin.customers">Customers</x-admin-nav-link>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="hover:bg-red-600 hover:text-white px-3 py-2 rounded">Logout</button>
    </form>
</nav>