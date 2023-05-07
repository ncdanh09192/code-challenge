<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if user get user's loan after authenticated.
     */
    public function testStoreShouldReturnUserLoansWhenUserAuthenticatedAndCallApiGetListLoans(){
        $this->get('api/loans')->assertStatus(self::HTTP_OK);
    }

    /**
     * Test if amount is missing when create loan.
     */
    public function testStoreShouldThrowAnErrorIfAmountIsMissingWhenCreateLoan(){
        $this->json('POST','api/loans')
            ->assertStatus(self::HTTP_UNPROCESSABLE_CONTENT)
            ->assertJsonStructure(['errors' => ['amount']]);
    }

    /**
     * Test if term is missing when create loan.
     */
    public function testStoreShouldThrowAnErrorIfTermIsMissingWhenCreateLoan(){
        $this->json('POST','api/loans')
            ->assertStatus(self::HTTP_UNPROCESSABLE_CONTENT)
            ->assertJsonStructure(['errors' => ['term']]);
    }

    /**
     * Test if create loan success.
     */
    public function testStoreShouldReturnSuccessIfUserCreateLoan(){
        $testAmount = fake()->randomNumber(5);
        $testTerm = fake()->randomDigitNot(0);
        $this->json('POST','api/loans',[
            'amount' => $testAmount,
            'term' => $testTerm
        ])->assertStatus(self::HTTP_CREATED)
        ->assertJson([
            'amount' => $testAmount,
            'term' => $testTerm
        ]);
        $this->assertDatabaseHas('loans',[
            'amount' => $testAmount,
            'term' => $testTerm
        ]);
    }

    /**
     * Test if approve user loan.
     */
    public function testStoreShouldReturnStateApprovedIfUserApproveLoan(){
        $testAmount = fake()->randomNumber(5);
        $testTerm = fake()->randomDigitNot(0);
        $content = json_decode($this->json('POST','api/loans',[
            'amount' => $testAmount,
            'term' => $testTerm
        ])->getContent());

        $this->json('POST','api/loans/approve-loan/'.$content->id)
            ->assertStatus(self::HTTP_OK)
            ->assertJson(['state' => 'APPROVED']);
    }
}
