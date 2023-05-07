<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledRepayments;
use App\Http\Requests\AddRepaymentRequest;
use App\Models\Loans;

class ScheduledRepaymentsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Add a user repayment.
     */
    public function addRepayment(AddRepaymentRequest $request, string $id){
        $repayment = ScheduledRepayments::find($id);
        if(empty($repayment)){
            return response([
                'message' => 'Repayment is not exist'
            ],500);
        }
        if($request->amount < $repayment->amount){
            return response([
                'message' => 'Add amount must greater than or equal to Repayment amount'
            ],422);
        }
        // Update repayment state to PAID
        $repayment->state = ScheduledRepayments::PAID_STATE;
        $repayment->save();
        // Check if all repayments are PAID then update loan
        $isAllRepaymentPaid = $this->isAllRepaymentPaid($repayment->loan_id);
        if($isAllRepaymentPaid){
            // Update loan state to PAID
            $loan = Loans::find($repayment->loan_id);
            $loan->state = Loans::PAID_STATE;
            $loan->save();
        }
        return response($repayment);
    }

    /**
     * Check if all repayment are PAID or not.
     */
    private function isAllRepaymentPaid($loanId) : bool {
        $isAllRepaymentPaid = true;
        $loanRepayments = ScheduledRepayments::where('loan_id',$loanId)->get();
        foreach ($loanRepayments as $repayment) {
            if($repayment->state == ScheduledRepayments::PENDING_STATE){
                $isAllRepaymentPaid = false;
                break;
            }
        }
        return $isAllRepaymentPaid;
    }
}
