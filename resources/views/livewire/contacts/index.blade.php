<div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Contacts</h1>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" wire:model.live.debounce.150ms="search" placeholder="Search contacts..." class="w-56 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3 pr-9 py-2 text-sm">
                @if($search)
                    <button wire:click="clearSearch" class="absolute right-2 top-2.5 h-4 w-4 text-gray-400 hover:text-gray-600" title="Clear search">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @else
                    <svg class="pointer-events-none absolute right-2 top-2.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.65 13.65z" />
                    </svg>
                @endif
            </div>
            <button wire:click="create" class="inline-flex items-center px-4 py-2 rounded-md bg-pink-600 text-white shadow-lg ring-1 ring-pink-500 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
            <span class="mr-2">+</span> Add Contact
            </button>
        </div>
    </div>

    @if($search)
        <div class="mb-4 text-sm text-gray-600">
            @if($contacts->count() > 0)
                Found {{ $contacts->total() }} contact(s) matching "{{ $search }}"
            @else
                No contacts found matching "{{ $search }}"
            @endif
        </div>
    @endif

    <div class="bg-white/90 backdrop-blur shadow-lg rounded-xl p-4 ring-1 ring-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Phone</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($contacts as $contact)
                    <tr>
                        <td class="px-4 py-2">{{ $contact->name }}</td>
                        <td class="px-4 py-2">{{ $contact->email }}</td>
                        <td class="px-4 py-2">{{ $contact->phone }}</td>
                        <td class="px-4 py-2 text-right">
                            <button wire:click="edit({{ $contact->id }})" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                            <button wire:click="delete({{ $contact->id }})" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 ml-2" onclick="return confirm('Delete this contact?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            No contacts yet — <span class="text-blue-600 cursor-pointer hover:underline" wire:click="create">add your first one</span>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($showForm)
        @livewire('contacts.form', ['contactId' => $editingContactId])
    @endif

    <div class="mt-4">
        {{ $contacts->links() }}
    </div>
</div>
