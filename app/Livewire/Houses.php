<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Houses extends Component
{
    use WithPagination, WithFileUploads;

    public string $address = '';
    public string $description = '';
    public $image;
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
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => $this->editId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];

        $this->validate($rules);

         $imagePath = $this->image ? $this->image->store('houses', 'public') : null;

        if ($this->editId) {
            $house = House::find($this->editId);
            if ($house) {
                $house->update([
                    'address' => $this->address,
                    'description' => $this->description,
                    'image' => $imagePath ?? $house->image,
                ]);
                session()->flash('success', 'House updated successfully.');
            }
        } else {
            House::create([
                'address' => $this->address,
                'description' => $this->description,
                'image' => $imagePath,
            ]);
            session()->flash('success', 'House added successfully');
        }

        $this->resetForm();
        $this->editId = null;
        $this->showForm = false;


    }

    public function edit($id)
    {
        $house = House::find($id);
        if ($house) {
            $this->editId = $house->id;
            $this->address = $house->address;
            $this->description = $house->description;
            $this->btn = 'Update';
            $this->showForm = true;
        }
    }

    public function delete($id)
    {
        House::destroy($id);
        session()->flash('success', 'House deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['address', 'description', 'image']);
        $this->btn = 'Add';
    }

   public function render()
    {
        $houses = House::orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.houses', [
            'houses' => $houses,
        ]);
    }
}
