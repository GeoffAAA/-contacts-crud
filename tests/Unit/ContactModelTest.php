<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_belongs_to_user()
    {
        $user = User::factory()->create();
        $contact = Contact::create([
            'name' => 'Test Contact',
            'email' => 'test@example.com',
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $contact->user);
        $this->assertEquals($user->id, $contact->user->id);
    }

    public function test_contact_fillable_attributes()
    {
        $contact = new Contact();
        $fillable = $contact->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('email', $fillable);
        $this->assertContains('phone', $fillable);
        $this->assertContains('user_id', $fillable);
    }

    public function test_contact_can_be_created_with_fillable_attributes()
    {
        $user = User::factory()->create();
        
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123-456-7890',
            'user_id' => $user->id
        ];

        $contact = Contact::create($contactData);

        $this->assertDatabaseHas('contacts', $contactData);
        $this->assertEquals('John Doe', $contact->name);
        $this->assertEquals('john@example.com', $contact->email);
        $this->assertEquals('123-456-7890', $contact->phone);
        $this->assertEquals($user->id, $contact->user_id);
    }

    public function test_contact_has_timestamps()
    {
        $user = User::factory()->create();
        $contact = Contact::create([
            'name' => 'Test Contact',
            'email' => 'test@example.com',
            'user_id' => $user->id
        ]);

        $this->assertNotNull($contact->created_at);
        $this->assertNotNull($contact->updated_at);
    }

    public function test_contact_phone_can_be_null()
    {
        $user = User::factory()->create();
        
        $contact = Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => null,
            'user_id' => $user->id
        ]);

        $this->assertNull($contact->phone);
    }

    public function test_contact_email_is_required()
    {
        $user = User::factory()->create();
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Contact::create([
            'name' => 'John Doe',
            'email' => null,
            'user_id' => $user->id
        ]);
    }

    public function test_contact_name_is_required()
    {
        $user = User::factory()->create();
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Contact::create([
            'name' => null,
            'email' => 'john@example.com',
            'user_id' => $user->id
        ]);
    }

    public function test_contact_user_id_is_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123-456-7890',
            'user_id' => null
        ]);
    }
}