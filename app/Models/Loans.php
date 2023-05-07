<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ScheduledRepayments;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Loans extends Model
{
    use HasFactory;

    const PENDING_STATE = 'PENDING';
    const APPROVED_STATE = 'APPROVED';
    const PAID_STATE = 'PAID';

    protected $fillable = [
        'amount',
        'term',
        'user_id'
    ];

    /**
     * Get the repayments from the loan.
     */
    public function repayments(): HasMany
    {
        return $this->hasMany(ScheduledRepayments::class,'loan_id');
    }

    /**
     * Create Scheduled Repayments record from Loan's term.
     */
    public function createScheduledRepaymentsFromLoan(){
        $listDataRepayment = $this->prepareListRepaymentToCreate();
        foreach ($listDataRepayment as $repaymentData) {
            ScheduledRepayments::create([
                'loan_id' => $this->id,
                'amount' => $repaymentData["amount"],
                'repayment_date' => $repaymentData["repayment_date"]
            ]);
        }
    }

    public function prepareListRepaymentToCreate(){
        $totalAllScheduleRepaymentAmount = 0;
        $listDataRepayment = [];
        // Loop through the loan's term
        for ($i=0; $i < $this->term; $i++) {
            // Each term will create one scheduled repayment
            $scheduleRepaymentAmount = number_format((float)$this->amount/$this->term, 2, '.', '');
            $totalAllScheduleRepaymentAmount += $scheduleRepaymentAmount;
            if($i == ($this->term - 1)){
                // round the last amount record
                $scheduleRepaymentAmount += $this->amount - $totalAllScheduleRepaymentAmount;
            }
            $listDataRepayment[] = [
                'loan_id' => $this->id,
                'amount' => $scheduleRepaymentAmount,
                'repayment_date' => Carbon::now()->addWeeks(($i+1))
            ];
        }
        return $listDataRepayment;
    }
}
