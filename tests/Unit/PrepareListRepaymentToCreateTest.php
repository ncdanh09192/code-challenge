<?php

namespace Tests\Unit;

use App\Models\Loans;
use PHPUnit\Framework\TestCase;

class PrepareListRepaymentToCreateTest extends TestCase
{
    /**
     * Test function create list repayment from loan data with three terms.
     */
    public function test_prepare_list_repayment_to_create_with_three_terms(): void
    {
        $loan = new Loans([
            'amount' => 10000,
            'term' => 3
        ]);

        $listRepaymentData = $loan->prepareListRepaymentToCreate();
        $this->assertEquals(3, count($listRepaymentData));
    }

    /**
     * Test function create list repayment from loan data with zero term.
     */
    public function test_prepare_list_repayment_to_create_with_zero_term(): void
    {
        $loan = new Loans([
            'amount' => 10000,
            'term' => 0
        ]);

        $listRepaymentData = $loan->prepareListRepaymentToCreate();
        $this->assertEquals(0, count($listRepaymentData));
    }

    /**
     * Test function create list repayment from loan data with amount is not divisible by term.
     */
    public function test_prepare_list_repayment_to_create_with_amount_not_divisible_by_term(): void
    {
        $loan = new Loans([
            'amount' => 10000,
            'term' => 3
        ]);

        $listRepaymentData = $loan->prepareListRepaymentToCreate();
        $totalAmount = 0;
        foreach ($listRepaymentData as $repayment) {
            $totalAmount += $repayment['amount'];
        }
        $this->assertEquals(10000,$totalAmount);
    }

    /**
     * Test function create list repayment from loan data with amount is divisible by term.
     */
    public function test_prepare_list_repayment_to_create_with_amount_divisible_by_term(): void
    {
        $loan = new Loans([
            'amount' => 12000,
            'term' => 3
        ]);

        $listRepaymentData = $loan->prepareListRepaymentToCreate();
        $totalAmount = 0;
        foreach ($listRepaymentData as $repayment) {
            $totalAmount += $repayment['amount'];
        }
        $this->assertEquals(12000,$totalAmount);
    }
}
