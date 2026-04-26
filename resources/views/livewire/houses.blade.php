<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="shadow-md sm:rounded-lg overflow-hidden p-6" style="background-color: rgba(255, 255, 255, 0.911)">

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
                {{-- form --}}
                @if ($showForm)
                    <div class="fixed inset-0 z-50 flex items-center justify-center px-4 pb-37">
                        <form wire:submit.prevent="store"
                            class="w-full max-w-lg p-6 border border-black rounded-lg shadow-lg"
                            style="background-color: rgb(255, 255, 255); ">
                            <h2 class="text-lg font-semibold mb-4" style="color:rgb(63, 63, 63)">
                                @if ($editId)
                                    Update the house
                                @else
                                    Add a house
                                @endif
                            </h2>
                            <div class="space-y-4">
                                <input type="text" wire:model.defer="address" placeholder="Address"
                                    class="border rounded p-2 w-full text-gray-700">
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="text" wire:model.defer="description" placeholder="Description"
                                    class="border rounded p-2 w-full text-gray-700">
                                @error('description')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <label for="image" class="block mb-1 text-red-500">Add an image</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3l4 4m0 0l-4 4m4-4H8" />
                                        </svg>
                                    </div>
                                    <input type="file" id="image" wire:model="image"
                                        class="border border-gray-300 rounded pl-10 pr-2 py-2 w-full text-gray-700"
                                        accept="image/*" />
                                </div>
                                @error('image')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-1">
                                    Download in progress...
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-2">
                                <button type="button" wire:click="$set('showForm', false)"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                                <button type="submit" class="px-4 py-2 rounded" id="actionBtn"
                                    style="background-color: rgb(16, 136, 211);color:white">
                                    {{ $btn }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
                {{-- Rechercher --}}
                <div class="relative w-full max-w-sm mb-5">
                    <input type="text" id="searchInput" placeholder="Search by address or description"
                        class="mb-4 border p-2 rounded w-full max-w-md text-gray-700">

                </div>


                {{-- table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th scope="col" class="px-4 py-3">Address</th>
                                <th scope="col" class="px-4 py-3">Description</th>
                                <th scope="col" class="px-4 py-3">Image</th>
                                <th scope="col" class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="housesTable">
                            @forelse ($houses as $house)
                                <tr class="border-b">
                                    <td class="px-4 py-2 address">{{ $house->address }}</td>
                                    <td class="px-4 py-2 description">{{ $house->description }}</td>
                                    <td>
                                        @if ($house->image)
                                            <img src="{{ url('storage/' . $house->image) }}"
                                                class="w-12 h-12 object-cover rounded" />
                                        @else
                                            <span class="text-gray-400">Image not available</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-right flex justify-end space-x-3">
                                        <button wire:click="edit({{ $house->id }})"
                                            class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                            <!-- Simple Pencil Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                                            </svg>
                                        </button>


                                        <button onclick="confirmDelete({{ $house->id }})"
                                            class="text-red-500 hover:text-red-700" title="Delete">
                                            <!-- Trash Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7L5 7M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                            </svg>
                                        </button>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 py-4">No houses found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- pagination --}}
                <div class="mt-4">
                    {{ $houses->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchInput');
        const rows = document.querySelectorAll('#housesTable tr');

        input.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();

            rows.forEach(row => {
                const addressCell = row.querySelector('.address');
                const descriptionCell = row.querySelector('.description');

                const addressText = addressCell ? addressCell.textContent.toLowerCase() : '';
                const descriptionText = descriptionCell ? descriptionCell.textContent
                    .toLowerCase() : '';

                const match = addressText.includes(searchText) || descriptionText.includes(
                    searchText);
                row.style.display = match ? '' : 'none';
            });
        });
    });

    function confirmDelete(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette maison ?')) {
            Livewire.dispatch('callDelete', {
                id: id
            });
        }
    }
</script>
