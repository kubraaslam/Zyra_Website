<div class="p-4 sm:p-6 bg-white rounded-lg border shadow">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
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
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative overflow-auto">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex flex-col">
                        <h2 class="text-2xl font-semibold">{{ $productId ? 'Edit Product' : 'Add New Product' }}</h2>
                        <p class="text-gray-500">A jewelry product for your store.</p>
                    </div>
                    <button wire:click="closeModal" class="absolute top-3 right-3">
                        <x-heroicon-o-x-mark class="w-5 h-5 text-gray-500" />
                    </button>
                </div>

                <form wire:submit.prevent="saveProduct">
                    <label for="name" class="font-semibold">Product Name</label>
                    <input wire:model.defer="name" placeholder="Twisted Ring"
                        class="border p-2 w-full rounded-lg text-sm focus:ring-black" required>

                    <label for="category" class="font-semibold">Category</label>
                    <input wire:model.defer="category" placeholder="Category"
                        class="border p-2 w-full rounded-lg text-sm focus:ring-black" required>

                    <label for="price" class="font-semibold">Price</label>
                    <input wire:model.defer="price" type="number" step="0.01" placeholder="975"
                        class="border p-2 w-full rounded-lg text-sm focus:ring-black" required>

                    <label for="stock" class="font-semibold">Stock</label>
                    <input wire:model.defer="stock" type="number" placeholder="15"
                        class="border p-2 w-full rounded-lg text-sm focus:ring-black">

                    <label for="status" class="font-semibold">Status</label>
                    <select wire:model.defer="status" class="border p-2 w-full rounded-lg text-sm focus:ring-black">
                        <option value="active">Active</option>
                        <option value="out_of_stock">Out of Stock</option>
                        <option value="discontinued">Discontinued</option>
                    </select>

                    <label for="image" class="font-semibold">Product Image</label>
                    <input type="file" wire:model="image" class="border p-2 w-full rounded-lg text-sm focus:ring-black">

                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <button class="bg-black text-white font-semibold px-4 py-2 mt-4 rounded-lg hover:bg-gray-700 w-full">
                        {{ $productId ? 'Update Product' : 'Add Product' }}
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-3 text-green-600">{{ session('success') }}</div> @endif
    @if(session('error'))
    <div class="mb-3 text-red-600">{{ session('error') }}</div> @endif

    <!-- Products Table -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full text-left text-sm min-w-[600px]">
            <thead>
                <tr class="border-b text-gray-500">
                    <th class="p-3">Image</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Stock</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">
                            @if($product->image_url)
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                                    class="w-16 h-16 object-cover rounded">
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="p-3 font-semibold">{{ $product->name }}</td>
                        <td class="p-3">{{ ucfirst($product->category) }}</td>
                        <td class="p-3">LKR {{ number_format($product->price, 2) }}</td>
                        <td class="p-3">{{ $product->stock ?? '-' }}</td>
                        <td class="p-3">
                            @if($product->status === 'discontinued')
                                <span class="bg-gray-500 text-white px-2 py-1 rounded-full text-xs">Discontinued</span>
                            @elseif($product->stock > 0)
                                <span class="bg-black text-white px-2 py-1 rounded-full text-xs">Active</span>
                            @else
                                <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">Out of Stock</span>
                            @endif
                        </td>
                        <td class="flex flex-wrap items-center gap-2 p-3 mt-5">
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
    </div>

    <!-- Delete Modal (responsive) -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative overflow-auto">
                <button wire:click="$set('showDeleteModal', false)" class="absolute top-3 right-3">
                    <x-heroicon-o-x-mark class="w-5 h-5 text-red-600" />
                </button>

                <h2 class="text-2xl font-semibold mb-2">Confirm Deletion</h2>
                <p class="text-gray-500 mb-4">Are you sure you want to delete this product?</p>

                @if($productToDelete)
                    <div class="flex items-center mb-4 gap-4">
                        @if($productToDelete->image_url)
                            <img src="{{ asset('storage/' . $productToDelete->image_url) }}" alt="{{ $productToDelete->name }}"
                                class="w-16 h-16 object-cover rounded">
                        @endif
                        <div>
                            <p class="font-semibold">{{ $productToDelete->name }}</p>
                            <p class="text-gray-500">{{ $productToDelete->category }}</p>
                        </div>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row justify-end gap-2">
                    <button wire:click="$set('showDeleteModal', false)"
                        class="px-4 py-2 rounded-lg border hover:bg-gray-100 w-full sm:w-auto">
                        Cancel
                    </button>
                    <button wire:click="deleteConfirmed"
                        class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 w-full sm:w-auto">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-4">{{ $products->links() }}</div>
</div>