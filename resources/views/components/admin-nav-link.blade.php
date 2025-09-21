<a href="{{ $href }}"
    class="{{ $isActive() ? 'bg-white text-gray-800 px-6 py-2 rounded-lg shadow w-full inline-flex text-center justify-center' : 'px-4 py-2 rounded-lg hover:bg-white hover:text-gray-800' }}">
    {{ $slot }}
</a>