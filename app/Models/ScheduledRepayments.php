<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledRepayments extends Model
{
    use HasFactory;

    const PENDING_STATE = 'PENDING';
    const PAID_STATE = 'PAID';

    protected $fillable = [
        'loan_id',
        'amount',
        'repayment_date',
        'state'
    ];
}
