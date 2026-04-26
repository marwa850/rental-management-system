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

                {{-- Formulaire --}}
                @if ($showForm)
                    <div class="fixed inset-0 z-50 flex items-center justify-center px-4 pb-37">
                        <form wire:submit.prevent="store"
                            class="w-full max-w-lg p-6 border border-black rounded-lg shadow-lg bg-white">
                            <h2 class="text-lg font-semibold mb-4 text-gray-700">
                                {{ $editId ? 'Edit renter' : 'Add renter' }}
                            </h2>

                            <div class="space-y-4">
                                <input type="text" wire:model.defer="name" placeholder="Full name"
                                    class="border rounded p-2 w-full text-gray-700">
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="text" wire:model.defer="Tel" placeholder="Phone"
                                    class="border rounded p-2 w-full text-gray-700">
                                @error('Tel')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="text" wire:model.defer="cin" placeholder="CIN"
                                    class="border rounded p-2 w-full text-gray-700">
                                @error('cin')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-6 flex justify-end space-x-2">
                                <button type="button" wire:click="$set('showForm', false)"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                                <button type="submit" class="px-4 py-2 rounded" id="actionBtn" style="background-color: rgb(16, 136, 211);color:white">
                                    {{ $btn }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Recherche --}}
                <div class="relative w-full max-w-sm mb-5">
                    <input type="text" id="searchInput" placeholder="Search by name or cin..."
                        class="mb-4 border p-2 rounded w-full text-gray-700">
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3">Full name</th>
                                <th class="px-4 py-3">Phone</th>
                                <th class="px-4 py-3">CIN</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="renterTable">
                            @forelse ($renters as $renter)
                                <tr class="border-b">
                                    <td class="px-4 py-2 name">{{ $renter->name }}</td>
                                    <td class="px-4 py-2">{{ $renter->Tel }}</td>
                                    <td class="px-4 py-2 cin">{{ $renter->cin }}</td>
                                    <td class="px-4 py-2 text-right flex justify-end space-x-3">
                                        <button wire:click="edit({{ $renter->id }})"
                                            class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                            <!-- Simple Pencil Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                                            </svg>
                                        </button>


                                        <button onclick="confirmDelete({{ $renter->id }})"
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
                                    <td colspan="4" class="text-center text-gray-500 py-4">No renters found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $renters->links() }}
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('actionBtn');
        const btnText = btn.textContent.trim();

        btn.classList.remove('bg-green-600', 'hover:bg-green-700', 'bg-yellow-500', 'hover:bg-yellow-600');

        if (btnText === 'Ajouter') {
            btn.classList.add('bg-green-600', 'hover:bg-green-700');
        } else if (btnText === 'Modifier') {
            btn.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchInput');
        const rows = document.querySelectorAll('#renterTable tr');

        input.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            rows.forEach(row => {
                const nameCell = row.querySelector('.name');
                const cinCell = row.querySelector('.cin');

                const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                const cinText = cinCell ? cinCell.textContent.toLowerCase() : '';

                const match = nameText.includes(searchText) || cinText.includes(searchText);
                row.style.display = match ? '' : 'none';
            });
        });
    });

    function confirmDelete(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce locataire ?')) {
            Livewire.dispatch('callDelete', {
                id: id
            });
        }
    }
</script>
