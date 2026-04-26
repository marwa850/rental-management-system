<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rental;
use App\Models\House;
use App\Models\Renter;

class Rentals extends Component
{
    use WithPagination;

    public $houses = [];
    public $renters = [];

    public int $house_id;
    public int $renter_id;
    public string $start_date = '';
    public string $end_date = '';
    public float $price_per_month = 0;
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
            'house_id' => 'required|integer|exists:houses,id',
            'renter_id' => 'required|integer|exists:renters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price_per_month' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function mount()
    {
        $this->houses = House::all(['id', 'address']);
        $this->renters = Renter::all(['id', 'name']);
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
            $rental = Rental::find($this->editId);
            if ($rental) {
                $rental->update([
                    'house_id' => $this->house_id,
                    'renter_id' => $this->renter_id,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'price_per_month' => $this->price_per_month,
                    'notes' => $this->notes,
                ]);
                session()->flash('success', 'Rental updated successfully.');
            }
        } else {
            Rental::create([
                'house_id' => $this->house_id,
                'renter_id' => $this->renter_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'price_per_month' => $this->price_per_month,
                'notes' => $this->notes,
            ]);
            session()->flash('success', 'Rental added successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $rental = Rental::find($id);
        if ($rental) {
            $this->editId = $rental->id;
            $this->house_id = $rental->house_id;
            $this->renter_id = $rental->renter_id;
            $this->start_date = $rental->start_date;
            $this->end_date = $rental->end_date;
            $this->price_per_month = $rental->price_per_month;
            $this->notes = $rental->notes;
            $this->btn = 'Update';
            $this->showForm = true;
        }
    }

    public function delete($id)
    {
        Rental::destroy($id);
        session()->flash('success', 'Rental deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset([
            'house_id',
            'renter_id',
            'start_date',
            'end_date',
            'price_per_month',
            'notes',
            'editId',
        ]);
        $this->btn = 'Add';
    }

    public function render()
    {
        $rentals = Rental::with(['house', 'renter'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.rentals', compact('rentals'));
    }
}
