@php
    use App\Models\Payment;
    use Illuminate\Support\Carbon;

    $months = [];
    $totals = [];

    for ($i = 1; $i <= 12; $i++) {
        $months[] = Carbon::create()->month($i)->translatedFormat('F');
        $totals[] = Payment::whereYear('payment_date', now()->year)->whereMonth('payment_date', $i)->sum('amount');
    }

@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 p-4">
        <!-- cards -->
        <div class="grid gap-6 md:grid-cols-3">
            <!-- Renters -->
            <div onclick="window.location='{{ route('renters.index') }}'"
                class="flex flex-col items-center justify-center bg-white shadow rounded-xl p-6 border border-gray-200">
                <svg class="w-10 h-10 mb-2" style="color: rgb(16, 137, 211)" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a9 9 0 00-9 9h18a9 9 0 00-9-9z" />
                </svg>

                <p class="font-semibold" style="font-size:17px; color: rgb(112, 112, 112)">Total Renters</p>
                <p class=" font-bold text-gray-900" style="font-size:22px">{{ \App\Models\Renter::count() }}</p>
            </div>
            <!-- Houses -->
            <div onclick="window.location='{{ route('houses.index') }}'"
                class="flex flex-col items-center justify-center bg-white shadow rounded-xl p-6 border border-gray-200">
                <svg class="w-10 h-10 mb-2" style="color: rgb(107, 105, 105)" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 12l8-8 8 8M4 12v8h16v-8" />
                </svg>

                <p class="font-semibold" style="font-size:17px; color: rgb(112, 112, 112)">Total Houses</p>
                <p class="text-2xl font-bold text-gray-900" style="font-size:22px">{{ \App\Models\House::count() }}</p>
            </div>
            <!-- Houses with renters this month -->
            <div onclick="window.location='{{ route('rentals.index') }}'"
                class="flex flex-col items-center justify-center bg-white shadow rounded-xl p-6 border border-gray-200">
                <svg class="w-10 h-10 mb-2" style="color: rgb(3, 74, 165)" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                <p class="font-semibold" style="font-size:17px; color: rgb(112, 112, 112)">Current Month Rentals</p>
                <p class="font-bold text-gray-900 " style="font-size:22px">
                    {{ \App\Models\House::whereHas('rentals', function ($query) {
                        $start = now()->startOfMonth();
                        $end = now()->endOfMonth();
                        $query->where(function ($q) use ($start, $end) {
                            $q->where('start_date', '<=', $end)->where('end_date', '>=', $start);
                        });
                    })->count() }}
                </p>
            </div>
        </div>
        <!-- paymentsChart -->
        <div class="bg-white p-6 rounded-xl shadow mt-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Monthly Payments - {{ now()->year }}</h2>
            <canvas id="paymentsChart" class="w-full h-64"></canvas>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('paymentsChart').getContext('2d');
                const loading = document.getElementById('loadingMessage');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($months),
                        datasets: [{
                            label: 'Montant Total',
                            data: @json($totals),
                            backgroundColor: 'rgba(43, 186, 226, 0.6)',
                            borderColor: 'rgba(43, 186, 226, 1)',
                            borderWidth: 1,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        animation: {
                            onComplete: () => {
                                if (loading) loading.style.display = 'none';
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-layouts.app>
