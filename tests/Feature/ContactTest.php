<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_contact()
    {
        $user = User::factory()->create();
        
        // Create contact directly since we use Livewire
        $contact = Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123-456-7890',
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'user_id' => $user->id
        ]);
    }

    public function test_user_can_only_see_own_contacts()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create contacts for both users
        Contact::create([
            'name' => 'User 1 Contact',
            'email' => 'user1@example.com',
            'user_id' => $user1->id
        ]);

        Contact::create([
            'name' => 'User 2 Contact',
            'email' => 'user2@example.com',
            'user_id' => $user2->id
        ]);

        // User 1 should only see their own contact
        $this->actingAs($user1)
            ->get('/dashboard')
            ->assertSee('User 1 Contact')
            ->assertDontSee('User 2 Contact');
    }

    public function test_user_can_update_own_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'user_id' => $user->id
        ]);

        // Update contact directly since we use Livewire
        $contact->update([
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '987-654-3210'
        ]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'user_id' => $user->id
        ]);
    }

    public function test_user_can_delete_own_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::create([
            'name' => 'Test Contact',
            'email' => 'test@example.com',
            'user_id' => $user->id
        ]);

        $contact->delete();

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }

    public function test_contact_validation_rules()
    {
        $user = User::factory()->create();

        // Test that we can't create contact without required fields
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Contact::create([
            'name' => null,
            'email' => null,
            'user_id' => $user->id
        ]);
    }

    public function test_different_users_can_have_same_email()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // User 1 creates contact
        Contact::create([
            'name' => 'User 1 Contact',
            'email' => 'shared@example.com',
            'user_id' => $user1->id
        ]);

        // User 2 should be able to create contact with same email
        $contact2 = Contact::create([
            'name' => 'User 2 Contact',
            'email' => 'shared@example.com',
            'user_id' => $user2->id
        ]);

        $this->assertDatabaseHas('contacts', [
            'email' => 'shared@example.com',
            'user_id' => $user2->id
        ]);
    }

    public function test_contact_belongs_to_user()
    {
        $user = User::factory()->create();
        $contact = Contact::create([
            'name' => 'Test Contact',
            'email' => 'test@example.com',
            'user_id' => $user->id
        ]);

        $this->assertEquals($user->id, $contact->user->id);
        $this->assertEquals($user->email, $contact->user->email);
    }
}