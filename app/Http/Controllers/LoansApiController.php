<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loans;
use App\Models\ScheduledRepayments;
use App\Http\Requests\CreateLoanRequest;

class LoansApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Loans::where('user_id',auth()->user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLoanRequest $request)
    {
        $createdLoan = Loans::create([
            'amount' => $request->amount,
            'term' => $request->term,
            'user_id' => auth()->user()->id
        ]);
        if(!empty($createdLoan)){
            $createdLoan->createScheduledRepaymentsFromLoan();
        }
        return $createdLoan;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Loans::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $loan = Loans::find($id);
        $loan->update($request);
        return $loan;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Loans::destroy($id);
    }

    /**
     * Approve a loan
     */
    public function approve(string $id){
        $loan = Loans::find($id);
        if(empty($loan)){
            return response([
                'message' => 'Loan is not exist'
            ],500);
        }

        $loan->state = Loans::APPROVED_STATE;
        $loan->save();

        return response($loan);
    }
}
