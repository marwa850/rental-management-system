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
                    <div class="fixed inset-0 z-50 flex items-center justify-center px-4 pb-5">
                        <form wire:submit.prevent="store"
                            class="w-full max-w-lg p-6 border border-black rounded-lg shadow-lg"
                            style="background-color: rgb(255, 255, 255); ">
                            <h2 class="text-lg font-semibold mb-4" style="color:rgb(63, 63, 63)">
                                @if ($editId)
                                    Update Payment
                                @else
                                    Add Payment
                                @endif
                            </h2>
                            <div class="space-y-4">

                                <select wire:model.defer="rental_id" class="border rounded p-2 w-full text-gray-700">
                                    <option value="">-- Select a rental --</option>
                                    @foreach ($rentals as $rental)
                                        <option value="{{ $rental->id }}">
                                            House: {{ $rental->house->address ?? '-' }} | Renter:
                                            {{ $rental->renter->name ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rental_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="date" wire:model.defer="payment_date" placeholder="Payment Date"
                                    class="border rounded p-2 w-full text-gray-700" />
                                @error('payment_date')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="number" wire:model.defer="amount" placeholder="Amount"
                                    class="border rounded p-2 w-full text-gray-700" step="0.01" />
                                @error('amount')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="text" wire:model.defer="payment_method" placeholder="Payment Method"
                                    class="border rounded p-2 w-full text-gray-700" />
                                @error('payment_method')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <input type="text" wire:model.defer="reference" placeholder="Reference (optional)"
                                    class="border rounded p-2 w-full text-gray-700" />
                                @error('reference')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                <textarea wire:model.defer="notes" placeholder="Notes (optional)" rows="3"
                                    class="border rounded p-2 w-full text-gray-700"></textarea>
                                @error('notes')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="mt-6 flex justify-end space-x-2">
                                <button type="button" wire:click="$set('showForm', false)"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                                <button type="submit" class="px-4 py-2 rounded text-white"
                                    style="background-color: rgb(16, 136, 211); color:white;">
                                    {{ $btn }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Search --}}
                <div class="relative w-full max-w-sm mb-5">
                    <input type="text" id="searchInput" placeholder="Search by house, renter or method"
                        class="mb-4 border p-2 rounded w-full max-w-md text-gray-700" />
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3">House / Renter</th>
                                <th class="px-4 py-3">Payment Date</th>
                                <th class="px-4 py-3">Amount</th>
                                <th class="px-4 py-3">Payment Method</th>
                                <th class="px-4 py-3">Reference</th>
                                <th class="px-4 py-3">Notes</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="paymentsTable">
                            @forelse ($payments as $payment)
                                <tr class="border-b">
                                    <td class="px-4 py-2 rental_info">
                                        <strong>House:</strong> {{ $payment->rental->house->address ?? '-' }}
                                        <strong>Renter:</strong> {{ $payment->rental->renter->name ?? '-' }}
                                    </td>


                                    <td class="px-4 py-2 payment_date">{{ $payment->payment_date }}</td>
                                    <td class="px-4 py-2 amount">{{ number_format($payment->amount, 2) }} DH</td>
                                    <td class="px-4 py-2 payment_method">{{ $payment->payment_method }}</td>
                                    <td class="px-4 py-2 reference">{{ $payment->reference ?? '-' }}</td>
                                    <td class="px-4 py-2 notes">{{ $payment->notes ?? '-' }}</td>
                                    <td class="px-4 py-2 text-right flex justify-end space-x-3">
                                        <button wire:click="edit({{ $payment->id }})"
                                            class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                            <!-- Pencil Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                                            </svg>
                                        </button>
                                        <button onclick="confirmDelete({{ $payment->id }})"
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
                                    <td colspan="8" class="text-center text-gray-500 py-4">No payments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#paymentsTable tr');

            input.addEventListener('input', function() {
                const searchText = this.value.toLowerCase();

                rows.forEach(row => {
                    const rentalCell = row.querySelector('.rental_info');
                    const methodCell = row.querySelector('.payment_method');

                    const rentalText = rentalCell ? rentalCell.textContent.toLowerCase() : '';
                    const methodText = methodCell ? methodCell.textContent.toLowerCase() : '';

                    const match = rentalText.includes(searchText) || methodText.includes(
                        searchText);
                    row.style.display = match ? '' : 'none';
                });
            });
        });



        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this payment?')) {
                Livewire.dispatch('callDelete', {
                    id: id
                });
            }
        }
    </script>
</div>
