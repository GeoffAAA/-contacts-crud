<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $showForm = false;
    public $editingContactId = null;
    public $search = '';

    #[On('contactSaved')]
    public function refreshList()
    {
        $this->showForm = false;
        $this->resetPage();
    }

    public function mount()
    {
        // no-op
    }

    public function create()
    {
        $this->editingContactId = null;
        $this->showForm = true;
    }

    public function edit($id)
    {
        $this->editingContactId = $id;
        $this->showForm = true;
    }

    public function delete($id)
    {
        Contact::where('user_id', Auth::id())->findOrFail($id)->delete();
        $this->refreshList();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
        // Debug: Log search updates
        Log::info('Search updated: ' . $this->search);
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $contacts = Contact::query()
            ->where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%')
                      ->orWhere('phone', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.contacts.index', [
            'contacts' => $contacts,
        ]);
    }
}
