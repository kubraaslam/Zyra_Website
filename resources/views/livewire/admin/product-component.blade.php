<div>
    <div class="p-6 bg-white rounded-lg border shadow">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Products</h1>
                <p class="text-gray-500 text-sm">Manage your jewelry inventory</p>
            </div>
            <button wire:click="openModal"
                class="flex items-center gap-2 bg-black hover:bg-gray-800 text-white font-semibold px-5 py-2 rounded-lg transition">
                <x-heroicon-o-plus class="w-5 h-5" />
                Add Product
            </button>
        </div>

        <!-- Modal -->
        @if($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
                    <div class="flex justify-between items-center">
                        <div class="flex flex-col">
                            <h2 class="text-2xl font-semibold">{{ $productId ? 'Edit Product' : 'Add New Product' }}</h2>
                            <p class="text-gray-500 mb-4">A jewelry product for your store.</p>
                        </div>
                        <button wire:click="closeModal"><x-heroicon-o-x-mark
                                class="w-5 h-5 text-gray-500 absolute top-3 right-3" /></button>
                    </div>

                    <form wire:submit.prevent="saveProduct">
                        <label for="name" class="font-semibold">Product Name</label>
                        <input wire:model.defer="name" placeholder="Twisted Ring"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black" required>

                        <label for="category" class="font-semibold">Category</label>
                        <input wire:model.defer="category" placeholder="Category"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black" required>

                        <label for="price" class="font-semibold">Price</label>
                        <input wire:model.defer="price" type="number" step="0.01" placeholder="975"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black" required>

                        <label for="stock" class="font-semibold">Stock</label>
                        <input wire:model.defer="stock" type="number" placeholder="15"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black">

                        <label for="image" class="font-semibold">Product Image</label>
                        <input type="file" wire:model="image"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black">

                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <button class="bg-black text-white text-semibold px-4 py-2 rounded-lg hover:bg-gray-700">
                            {{ $productId ? 'Update Product' : 'Add Product' }}
                        </button>
                    </form>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-3 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="table-auto w-full text-left text-sm">
            <thead>
                <tr class="border-b text-gray-500 hover:bg-gray-200">
                    <th class="p-6">Product Image</th>
                    <th class="p-6">Name</th>
                    <th class="p-6">Category</th>
                    <th class="p-6">Price</th>
                    <th class="p-6">Stock</th>
                    <th class="p-6">Status</th>
                    <th class="p-6">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-6">
                            @if($product->image_url)
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                                    class="w-16 h-16 object-cover rounded">
                            @else
                                N/A
                            @endif
                        </td>

                        <td class="p-6 font-semibold">{{ $product->name }}</td>
                        <td class="p-6">{{ $product->category }}</td>
                        <td class="p-6">Rs. {{ number_format($product->price, 2) }}</td>
                        <td class="p-6">{{ $product->stock }}</td>
                        <td class="p-6">
                            @if($product->stock > 0)
                                <span class="bg-black text-white font-semibold px-2 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-red-500 text-white font-semibold px-2 py-1 rounded-full">Out of Stock</span>
                            @endif
                        </td>
                        <td class="flex items-center space-x-6 p-6 mt-5">
                            <button wire:click="openModal({{ $product->id }})">
                                <x-heroicon-o-pencil-square class="w-5 h-5 text-black" />
                            </button>
                            <button wire:click="confirmDelete({{ $product->id }})">
                                <x-heroicon-o-trash class="w-5 h-5 text-red-600" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Delete Modal -->
        @if($showDeleteModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
                    <button wire:click="$set('showDeleteModal', false)" class="absolute top-3 right-3">
                        <x-heroicon-o-x-mark class="w-5 h-5 text-red-600" />
                    </button>

                    <h2 class="text-2xl font-semibold mb-2">Confirm Deletion</h2>
                    <p class="text-gray-500 mb-4">Are you sure you want to delete this product?</p>

                    @if($productToDelete)
                        <div class="flex items-center mb-4">
                            @if($productToDelete->image_url)
                                <img src="{{ asset('storage/' . $productToDelete->image_url) }}" alt="{{ $productToDelete->name }}"
                                    class="w-16 h-16 object-cover rounded mr-4">
                            @endif
                            <div>
                                <p class="font-semibold">{{ $productToDelete->name }}</p>
                                <p class="text-gray-500">{{ $productToDelete->category }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-end space-x-4">
                        <button wire:click="$set('showDeleteModal', false)"
                            class="px-4 py-2 rounded-lg border hover:bg-gray-100">
                            Cancel
                        </button>
                        <button wire:click="deleteConfirmed"
                            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</div>