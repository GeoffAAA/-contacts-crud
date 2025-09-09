<?php

namespace Tests\Feature;

use App\Livewire\Contacts\Index;
use App\Livewire\Contacts\Form;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_contacts_index()
    {
        $user = User::factory()->create();
        
        Livewire::actingAs($user)
            ->test(Index::class)
            ->assertStatus(200);
    }

    public function test_can_search_contacts()
    {
        $user = User::factory()->create();
        
        Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'user_id' => $user->id
        ]);

        Contact::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->set('search', 'John')
            ->assertSee('John Doe')
            ->assertDontSee('Jane Smith');
    }

    public function test_can_create_contact_via_livewire()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Form::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('phone', '123-456-7890')
            ->call('save')
            ->assertDispatched('contactSaved');

        $this->assertDatabaseHas('contacts', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'user_id' => $user->id
        ]);
    }

    public function test_can_edit_contact_via_livewire()
    {
        $user = User::factory()->create();
        $contact = Contact::create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Form::class, ['contactId' => $contact->id])
            ->assertSet('name', 'Original Name')
            ->assertSet('email', 'original@example.com')
            ->set('name', 'Updated Name')
            ->set('email', 'updated@example.com')
            ->call('save')
            ->assertDispatched('contactSaved');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'user_id' => $user->id
        ]);
    }

    public function test_can_delete_contact_via_livewire()
    {
        $user = User::factory()->create();
        $contact = Contact::create([
            'name' => 'Test Contact',
            'email' => 'test@example.com',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('delete', $contact->id);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }

    public function test_form_validation_works()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Form::class)
            ->set('name', '') // Empty name
            ->set('email', 'invalid-email') // Invalid email
            ->call('save')
            ->assertHasErrors(['name', 'email']);
    }

    public function test_search_resets_pagination()
    {
        $user = User::factory()->create();
        
        // Create more than 10 contacts to test pagination
        for ($i = 1; $i <= 15; $i++) {
            Contact::create([
                'name' => "Test Contact $i",
                'email' => "test$i@example.com",
                'user_id' => $user->id
            ]);
        }

        // Create a contact that won't match the search
        Contact::create([
            'name' => 'Different Contact',
            'email' => 'different@example.com',
            'user_id' => $user->id
        ]);

        $component = Livewire::actingAs($user)
            ->test(Index::class)
            ->set('search', 'test');

        // Verify that search results are shown and pagination is reset to page 1
        $component->assertSee('Test Contact 1')
                  ->assertSee('Test Contact 2')
                  ->assertDontSee('Different Contact'); // Should not see non-matching contacts
    }

    public function test_can_clear_search()
    {
        $user = User::factory()->create();
        
        Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'user_id' => $user->id
        ]);

        Contact::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'user_id' => $user->id
        ]);

        $component = Livewire::actingAs($user)
            ->test(Index::class)
            ->set('search', 'John')
            ->assertSee('John Doe')
            ->assertDontSee('Jane Smith')
            ->call('clearSearch')
            ->assertSet('search', '')
            ->assertSee('John Doe')
            ->assertSee('Jane Smith'); // Both should be visible after clearing search
    }

    public function test_user_cannot_edit_other_users_contact()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $contact = Contact::create([
            'name' => 'User 2 Contact',
            'email' => 'user2@example.com',
            'user_id' => $user2->id
        ]);

        // This should fail because user1 can't access user2's contact
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        
        Livewire::actingAs($user1)
            ->test(Form::class, ['contactId' => $contact->id]);
    }

    public function test_user_cannot_delete_other_users_contact()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $contact = Contact::create([
            'name' => 'User 2 Contact',
            'email' => 'user2@example.com',
            'user_id' => $user2->id
        ]);

        // This should fail because user1 can't delete user2's contact
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        
        Livewire::actingAs($user1)
            ->test(Index::class)
            ->call('delete', $contact->id);
    }

    public function test_contacts_are_paginated()
    {
        $user = User::factory()->create();
        
        // Create 15 contacts
        for ($i = 1; $i <= 15; $i++) {
            Contact::create([
                'name' => "Contact $i",
                'email' => "contact$i@example.com",
                'user_id' => $user->id
            ]);
        }

        $component = Livewire::actingAs($user)
            ->test(Index::class);

        // Should show pagination links
        $component->assertSee('Next');
    }
}