<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="shadow-md sm:rounded-lg overflow-hidden p-6 bg-white">

                @if (session()->has('success'))
                    <div class="mb-4 text-green-600 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4 text-right">
                    <button wire:click="openForm" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                        <span class="text-2xl">+</span>
                    </button>
                </div>

                @if ($showForm)
                    <div class="fixed inset-0 z-50 flex items-center justify-center px-4 pb-10">
                        <form wire:submit.prevent="store"
                            class="w-full max-w-lg p-6 border border-black rounded-lg shadow-lg bg-white">
                            <h2 class="text-lg font-semibold mb-4 text-gray-700">
                                {{ $editId ? 'Update User' : 'Add User' }}
                            </h2>

                            <div class="space-y-4">
                                <input type="text" wire:model.defer="name" placeholder="Name"
                                    class="border rounded p-2 w-full text-gray-700" />
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="email" wire:model.defer="email" placeholder="Email"
                                    class="border rounded p-2 w-full text-gray-700" />
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="password" wire:model.defer="password" placeholder="Password"
                                    class="border rounded p-2 w-full text-gray-700" />
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-6 flex justify-end space-x-2">
                                <button type="button" wire:click="$set('showForm', false)"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                                <button type="submit" class="px-4 py-2 rounded"
                                    style="background-color: rgb(16, 136, 211);color:white">
                                    {{ $btn }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="relative w-full max-w-sm mb-5">
                    <input type="text" id="searchInput" placeholder="Search by name or email"
                        class="mb-4 border p-2 rounded w-full text-gray-700" />
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTable">
                            @forelse ($users as $user)
                                <tr class="border-b">
                                    <td class="px-4 py-2 name">{{ $user->name }}</td>
                                    <td class="px-4 py-2 email">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-right flex justify-end space-x-3">
                                        <button wire:click="edit({{ $user->id }})"
                                            class="text-yellow-500 hover:text-yellow-700" title="Edit"> <svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                                            </svg></button>
                                        <button onclick="confirmDelete({{ $user->id }})"
                                            class="text-red-500 hover:text-red-700" title="Delete"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7L5 7M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                            </svg></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 py-4">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#usersTable tr');

            input.addEventListener('input', function() {
                const searchText = this.value.toLowerCase();

                rows.forEach(row => {
                    const nameCell = row.querySelector('.name');
                    const emailCell = row.querySelector('.email');

                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                    const emailText = emailCell ? emailCell.textContent.toLowerCase() : '';

                    const match = nameText.includes(searchText) || emailText.includes(searchText);
                    row.style.display = match ? '' : 'none';
                });
            });
        });

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                Livewire.dispatch('callDelete', {
                    id: id
                });
            }
        }
    </script>
</div>
