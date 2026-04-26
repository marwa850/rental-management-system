<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $btn = 'Add';

    public bool $showForm = false;
    public ?int $editId = null;
    public int $perPage = 4;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['callDelete' => 'delete'];

    protected function rules()
    {
        $uniqueEmail = 'unique:users,email';
        if ($this->editId) {
            $uniqueEmail .= ',' . $this->editId;
        }

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', $uniqueEmail],
            'password' => $this->editId ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editId) {
            User::where('id', $this->editId)->update($data);
            session()->flash('success', 'User updated successfully.');
        } else {
            User::create($data);
            session()->flash('success', 'User added successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->editId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->btn = 'Update';
        $this->showForm = true;
    }

    public function delete($id)
    {
        User::destroy($id);
        session()->flash('success', 'User deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'editId']);
        $this->btn = 'Add';
    }

    public function render()
    {
        $users = User::orderBy('created_at', 'desc')->paginate($this->perPage);
        return view('livewire.users', compact('users'));
    }
}
