<div>
    <div class="p-6 bg-white rounded-lg border shadow">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Customer Management</h1>
                <p class="text-gray-500 text-sm">Manage customer accounts</p>
            </div>
            <button wire:click="openModal"
                class="flex items-center gap-2 bg-black hover:bg-gray-800 text-white font-semibold px-5 py-2 rounded-lg transition">
                <x-heroicon-o-plus class="w-5 h-5" />
                Add User
            </button>
        </div>

        <!-- Modal -->
        @if($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
                    <div class="flex justify-between items-center">
                        <div class="flex flex-col">
                            <h2 class="text-2xl font-semibold">{{ $userId ? 'Edit User' : 'Add New User' }}</h2>
                        </div>
                        <button wire:click="closeModal"><x-heroicon-o-x-mark
                                class="w-5 h-5 text-gray-500 absolute top-3 right-3" /></button>
                    </div>

                    <form wire:submit.prevent="saveUser">
                        <label for="username" class="font-semibold">Username</label>
                        <input wire:model.defer="username" type="text" placeholder="stella"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black" required>

                        <label for="email" class="font-semibold">Email</label>
                        <input wire:model.defer="email" type="email" placeholder="stelllaalonso@gmail.com"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black" required>

                        <label for="password" class="font-semibold">Password</label>
                        <input wire:model.defer="password" type="password"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black" required>

                        <label for="membership_plan" class="font-semibold">Membership Plan</label>
                        <select wire:model.defer="membership_plan"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black">
                            <option value="">-- No Membership --</option>
                            <option value="standard">Standard Membership</option>
                            <option value="premium">Premium Membership</option>
                        </select>

                        <label for="status" class="font-semibold">Status</label>
                        <select wire:model.defer="status"
                            class="border p-2 w-full mb-3 rounded-lg text-sm focus:ring-black">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <button class="bg-black text-white text-semibold px-4 py-2 rounded-lg hover:bg-gray-700">
                            {{ $userId ? 'Update User' : 'Add User' }}
                        </button>
                    </form>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-3 text-green-600">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-3 text-red-600">{{ session('error') }}</div>
        @endif

        <table class="table-auto w-full text-left text-sm">
            <thead>
                <tr class="border-b text-gray-500 hover:bg-gray-200">
                    <th class="p-6">Username</th>
                    <th class="p-6">Email</th>
                    <th class="p-6">Membership Plan</th>
                    <th class="p-6">Join Date</th>
                    <th class="p-6">Status</th>
                    <th class="p-6">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-6 font-semibold">{{ $user->username }}</td>
                        <td class="p-6">{{ $user->email }}</td>
                        <td class="p-6">{{ ucfirst($user->membership_plan) }}</td>

                        <td class="p-6">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="p-6">
                            @if($user->status === 'inactive')
                                <span class="bg-gray-500 text-white font-semibold px-2 py-1 rounded-full">Inactive</span>
                            @else
                                <span class="bg-black text-white font-semibold px-2 py-1 rounded-full">Active</span>
                            @endif
                        </td>

                        <td class="flex items-center space-x-6 p-6">
                            <button wire:click="openModal({{ $user->id }})">
                                <x-heroicon-o-pencil-square class="w-5 h-5 text-black" />
                            </button>
                            <button wire:click="confirmDelete({{ $user->id }})">
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
                    <p class="text-gray-500 mb-4">Are you sure you want to delete this user?</p>

                    @if($userToDelete)
                        <div class="flex items-center mb-4">
                            <div>
                                <p class="font-semibold">{{ $userToDelete->username }}</p>
                                <p class="text-gray-500">{{ $userToDelete->email }}</p>
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

        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</div>