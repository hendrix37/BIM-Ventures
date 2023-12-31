<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint = '/api/transactions';

    protected string $tableName = 'transactions';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateTransaction(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        $payload = Transaction::factory()->make([])->toArray();

        $this->json('POST', $this->endpoint, $payload)
            ->assertStatus(201)
            ->assertSee($payload['name']);

        $this->assertDatabaseHas($this->tableName, ['id' => 1]);
    }

    public function testViewAllDummiesSuccessfully(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        Transaction::factory(5)->create();

        $this->json('GET', $this->endpoint)
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertSee(Transaction::first(rand(1, 5))->name);
    }

    public function testViewAllDummiesByFooFilter(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        Transaction::factory(5)->create();

        $this->json('GET', $this->endpoint.'?foo=1')
            ->assertStatus(200)
            ->assertSee('foo')
            ->assertDontSee('foo');
    }

    public function testsCreateTransactionValidation(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        $data = [
        ];

        $this->json('post', $this->endpoint, $data)
            ->assertStatus(422);
    }

    public function testViewTransactionData(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        Transaction::factory()->create();

        $this->json('GET', $this->endpoint.'/1')
            ->assertSee(Transaction::first()->name)
            ->assertStatus(200);
    }

    public function testUpdateTransaction(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        Transaction::factory()->create();

        $payload = [
            'name' => 'Random',
        ];

        $this->json('PUT', $this->endpoint.'/1', $payload)
            ->assertStatus(200)
            ->assertSee($payload['name']);
    }

    public function testDeleteTransaction(): void
    {
        $this->markTestIncomplete('This test case needs review.');

        $this->actingAs(User::factory()->create());

        Transaction::factory()->create();

        $this->json('DELETE', $this->endpoint.'/1')
            ->assertStatus(204);

        $this->assertEquals(0, Transaction::count());
    }
}
