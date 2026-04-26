<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Renter;
use Livewire\WithPagination;

class Renters extends Component
{
    use WithPagination;

    public string $name = '';
    public string $Tel = '';
    public string $cin = '';
    public int $perPage = 4;
    public bool $showForm = false;
    public ?int $editId = null;
    public string $btn = 'Ajouter';
    protected $paginationTheme = 'tailwind';
    protected $listeners = ['callDelete' => 'delete'];

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function store()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'Tel' => 'required|string|max:20',
            'cin' => 'required|string|max:20',
        ];

        $this->validate($rules);

        if ($this->editId) {
            $renter = Renter::find($this->editId);
            if ($renter) {
                $renter->update([
                    'name' => $this->name,
                    'Tel' => $this->Tel,
                    'cin' => $this->cin,
                ]);
                session()->flash('success', 'Renter updated successfully.');
            }
        } else {
            Renter::create([
                'name' => $this->name,
                'Tel' => $this->Tel,
                'cin' => $this->cin,
            ]);
            session()->flash('success', 'Renter added successfully.');
        }

        $this->resetForm();
        $this->editId = null;
        $this->showForm = false;
    }

    public function edit($id)
    {
        $renter = Renter::find($id);
        if ($renter) {
            $this->editId = $renter->id;
            $this->name = $renter->name;
            $this->Tel = $renter->Tel;
            $this->cin = $renter->cin;
            $this->btn = 'Update';
            $this->showForm = true;
        }
    }

    public function delete($id)
    {
        Renter::destroy($id);
        session()->flash('success', 'Renter deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'Tel', 'cin']);
        $this->btn = 'Add';
    }

    public function render()
    {
        $renters = Renter::latest()->paginate($this->perPage);

        return view('livewire.renters', [
            'renters' => $renters,
        ]);
    }
}
