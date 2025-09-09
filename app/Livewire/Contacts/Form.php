<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $name;
    public $email;
    public $phone;
    public $contactId;

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:contacts,email,' . $this->contactId . ',id,user_id,' . Auth::id(),
            'phone' => 'nullable',
        ];
    }

    public function mount($contactId = null)
    {
        if ($contactId) {
            $contact = Contact::where('user_id', Auth::id())->findOrFail($contactId);
            $this->contactId = $contact->id;
            $this->name = $contact->name;
            $this->email = $contact->email;
            $this->phone = $contact->phone;
        }
    }

    public function save()
    {
        $this->validate();

        Contact::updateOrCreate(
            ['id' => $this->contactId, 'user_id' => Auth::id()],
            [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'user_id' => Auth::id(),
            ]
        );

        $this->reset(['name', 'email', 'phone', 'contactId']);
        $this->dispatch('contactSaved');
    }

    public function render()
    {
        return view('livewire.contacts.form');
    }
}
