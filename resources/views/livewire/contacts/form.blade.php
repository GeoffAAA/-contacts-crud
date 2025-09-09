<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40" wire:click="$dispatch('contactSaved')"></div>
    <div class="relative z-10 w-full max-w-lg mx-auto bg-white rounded-lg shadow-lg max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-4 sm:px-5 py-4 border-b">
            <h3 class="text-lg font-semibold">{{ $contactId ? 'Edit Contact' : 'Add Contact' }}</h3>
            <button type="button" wire:click="$dispatch('contactSaved')" class="text-gray-500 hover:text-gray-700 text-xl">✕</button>
        </div>
        <div class="p-4 sm:p-5">
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" wire:model="name" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" wire:model="email" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="text" wire:model="phone" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end space-y-2 sm:space-y-0 sm:space-x-2 pt-2">
                    <button type="button" wire:click="$dispatch('contactSaved')" class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50 order-2 sm:order-1">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 order-1 sm:order-2">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
