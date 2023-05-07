<?php

namespace Tests\Feature;

use App\Models\ScheduledRepayments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepaymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if amount is missing when add repayment.
     */
    public function testStoreShouldThrowAnErrorIfAmountIsMissingWhenAddRepayment(){
        $testAmount = fake()->randomNumber(5);
        $testTerm = fake()->randomDigitNot(0);
        $loanContent = json_decode($this->json('POST','api/loans',[
            'amount' => $testAmount,
            'term' => $testTerm
        ])->getContent());

        $repayment = ScheduledRepayments::where('loan_id',$loanContent->id)
            ->where('state','PENDING')
            ->first();
        $this->json('POST','api/repayments/add/'.$repayment->id)
            ->assertStatus(self::HTTP_UNPROCESSABLE_CONTENT)
            ->assertJsonStructure(['errors' => ['amount']]);
    }

    /**
     * Test if add loan's repayment with amount smaller than repayment amount.
     */
    public function testStoreShouldThrowAnErrorIfUserAddRepaymentWithSmallerAmount(){
        $testAmount = fake()->randomNumber(5);
        $testTerm = fake()->randomDigitNot(0);
        $loanContent = json_decode($this->json('POST','api/loans',[
            'amount' => $testAmount,
            'term' => $testTerm
        ])->getContent());

        $repayment = ScheduledRepayments::where('loan_id',$loanContent->id)
            ->where('state','PENDING')
            ->first();
        $this->json('POST','api/repayments/add/'.$repayment->id,['amount' => ($repayment->amount - 1)])
            ->assertStatus(self::HTTP_UNPROCESSABLE_CONTENT)
            ->assertJson(['message' => "Add amount must greater than or equal to Repayment amount"]);
    }

    /**
     * Test if add loan's repayment.
     */
    public function testStoreShouldReturnStatePaidIfUserAddRepayment(){
        $testAmount = fake()->randomNumber(5);
        $testTerm = fake()->randomDigitNot(0);
        $loanContent = json_decode($this->json('POST','api/loans',[
            'amount' => $testAmount,
            'term' => $testTerm
        ])->getContent());

        $repayment = ScheduledRepayments::where('loan_id',$loanContent->id)
            ->where('state','PENDING')
            ->first();
        $this->json('POST','api/repayments/add/'.$repayment->id,['amount' => $repayment->amount])
            ->assertStatus(self::HTTP_OK)
            ->assertJson(['state' => 'PAID']);
    }
}
