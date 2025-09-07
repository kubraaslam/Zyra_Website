<div>
    <div class="relative">
        <a href="{{ route('cart') }}">
            <x-heroicon-o-shopping-bag class="w-6 h-6" />
            @if($cartCount > 0)
                <span
                    class="absolute -top-1 -right-3 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                    {{ $cartCount }}
                </span>
            @endif
        </a>
    </div>
</div>