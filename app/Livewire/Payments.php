<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;
use App\Models\Rental;

class Payments extends Component
{
     use WithPagination;

    public $rentals = [];

    public int $rental_id;
    public string $payment_date = '';
    public float $amount = 0;
    public string $payment_method = '';
    public string $reference = '';
    public string $notes = '';

    public bool $showForm = false;
    public ?int $editId = null;
    public string $btn = 'Add';
    public int $perPage = 4;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['callDelete' => 'delete'];

    protected function rules()
    {
        return [
            'rental_id' => 'required|integer|exists:rentals,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function mount()
    {
        $this->rentals = Rental::with(['house', 'renter'])->get();
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        if ($this->editId) {
            $payment = Payment::find($this->editId);
            if ($payment) {
                $payment->update([
                    'rental_id' => $this->rental_id,
                    'payment_date' => $this->payment_date,
                    'amount' => $this->amount,
                    'payment_method' => $this->payment_method,
                    'reference' => $this->reference,
                    'notes' => $this->notes,
                ]);
                session()->flash('success', 'Payment updated successfully.');
            }
        } else {
            Payment::create([
                'rental_id' => $this->rental_id,
                'payment_date' => $this->payment_date,
                'amount' => $this->amount,
                'payment_method' => $this->payment_method,
                'reference' => $this->reference,
                'notes' => $this->notes,
            ]);
            session()->flash('success', 'Payment added successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $payment = Payment::find($id);
        if ($payment) {
            $this->editId = $payment->id;
            $this->rental_id = $payment->rental_id;
            $this->payment_date = $payment->payment_date;
            $this->amount = $payment->amount;
            $this->payment_method = $payment->payment_method;
            $this->reference = $payment->reference;
            $this->notes = $payment->notes;
            $this->btn = 'Update';
            $this->showForm = true;
        }
    }

    public function delete($id)
    {
        Payment::destroy($id);
        session()->flash('success', 'Payment deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset([
            'rental_id',
            'payment_date',
            'amount',
            'payment_method',
            'reference',
            'notes',
            'editId',
        ]);
        $this->btn = 'Add';
    }

    public function render()
    {
        $payments = Payment::with('rental.house', 'rental.renter')
            ->orderBy('payment_date', 'desc')
            ->paginate($this->perPage);

        return view('livewire.payments', compact('payments'));
    }
}
