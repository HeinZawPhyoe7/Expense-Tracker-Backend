<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseTracker extends Model
{
    protected $fillable = [
        'type',
        'wallet',
        'expense_category',
        'date',
        'amount',
        'description',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
