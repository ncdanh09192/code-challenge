<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ScheduledRepayments;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
