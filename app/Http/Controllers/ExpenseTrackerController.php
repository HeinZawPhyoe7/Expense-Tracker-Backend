<?php

namespace App\Http\Controllers;

use App\Models\ExpenseTracker;
use Illuminate\Http\Request;

class ExpenseTrackerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'wallet' => 'required',
            'expense_category' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

        $expense = new ExpenseTracker;
        $expense->type = $request->type;
        $expense->wallet = $request->wallet;
        $expense->expense_category = $request->expense_category;
        $expense->date = $request->date;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->save();

        return response()->json([
            'expense' => $expense,
            'message' => 'Expense Successfully Stored'
        ], 201);
    }
}
