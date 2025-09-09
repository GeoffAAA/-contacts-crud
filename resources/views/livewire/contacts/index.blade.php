<div class="max-w-5xl mx-auto p-3 sm:p-6">
    <!-- Mobile-first responsive header -->
    <div class="mb-4 sm:mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 mb-4 sm:mb-0">Contacts</h1>
        
        <!-- Mobile: Stacked layout -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <!-- Search bar -->
            <div class="relative flex-1 sm:flex-none">
                <input type="text" wire:model.live.debounce.150ms="search" placeholder="Search contacts..." class="w-full sm:w-56 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3 pr-9 py-2 text-sm">
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
            
            <!-- Add Contact button -->
            <button wire:click="create" class="inline-flex items-center justify-center px-4 py-2 rounded-md bg-pink-600 text-white shadow-lg ring-1 ring-pink-500 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 w-full sm:w-auto">
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

    <div class="bg-white/90 backdrop-blur shadow-lg rounded-xl p-2 sm:p-4 ring-1 ring-gray-200">
        <!-- Desktop table view -->
        <div class="hidden sm:block overflow-x-auto">
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
                                <button wire:click="edit({{ $contact->id }})" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Edit</button>
                                <button wire:click="delete({{ $contact->id }})" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 ml-2 text-sm" onclick="return confirm('Delete this contact?')">Delete</button>
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

        <!-- Mobile card view -->
        <div class="sm:hidden space-y-3">
            @forelse ($contacts as $contact)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-900 text-lg">{{ $contact->name }}</h3>
                        <div class="flex space-x-2">
                            <button wire:click="edit({{ $contact->id }})" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</button>
                            <button wire:click="delete({{ $contact->id }})" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600" onclick="return confirm('Delete this contact?')">Delete</button>
                        </div>
                    </div>
                    <div class="space-y-1 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $contact->email }}
                        </div>
                        @if($contact->phone)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $contact->phone }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    No contacts yet — <span class="text-blue-600 cursor-pointer hover:underline" wire:click="create">add your first one</span>.
                </div>
            @endforelse
        </div>
    </div>

    @if($showForm)
        @livewire('contacts.form', ['contactId' => $editingContactId])
    @endif

    @if($contacts->hasPages())
        <div class="mt-4 flex justify-center">
            <div class="w-full sm:w-auto">
                {{ $contacts->links() }}
            </div>
        </div>
    @endif
</div>
