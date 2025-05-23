<?php

namespace App\Http\Controllers;

use App\Models\ExpenseTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseTrackerController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'type' => 'required',
            'wallet' => 'required',
            'expense_category' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

        // Calculate current balance
        $myIncome = ExpenseTracker::where('user_id', $user->id)->where('type', 'income')->sum('amount');
        $myExpense = ExpenseTracker::where('user_id', $user->id)->where('type', 'expense')->sum('amount');
        $myBalance = ExpenseTracker::where('user_id', $user->id)->where('total_balance', 0)->sum('amount');

        $Income = ExpenseTracker::where('user_id', $user->id)
            ->where('income', 0)->sum('amount');
        $Expense = ExpenseTracker::where('user_id', $user->id)
            ->where('expense', 0)->sum('amount');

        $totalIncome = $request->income + $Income + $myIncome;
        $totalExpense = $request->expense + $Expense + $myExpense;

        $totalBalance = $request->total_balance + $myBalance + $totalIncome - $totalExpense;



        $expense = new ExpenseTracker;
        $expense->type = $request->type;
        $expense->wallet = $request->wallet;
        $expense->expense_category = $request->expense_category;
        $expense->date = $request->date;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->user_id = $user->id;
        $expense->total_balance = $totalBalance;
        $expense->income = $totalIncome;
        $expense->expense = $totalExpense;
        $expense->save();

        return response()->json([
            'data' => $expense,
            'message' => 'Expense Successfully Stored'
        ], 201);
    }

    public function getall()
    {
        $userId = Auth::id();
        $expense = ExpenseTracker::where('user_id', $userId)->get();

        $myIncome = ExpenseTracker::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $myExpense = ExpenseTracker::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $myBalance = ExpenseTracker::where('user_id', $userId)
            ->where('total_balance', 0)
            ->sum('total_balance');

        $Income = ExpenseTracker::where('user_id', $userId)
            ->where('income', 0)->sum('income');

        $Expense = ExpenseTracker::where('user_id', $userId)
            ->where('expense', 0)->sum('expense');

        $totalIncome = $Income + $myIncome;
        $totalExpense = $Expense + $myExpense;
        $totalBalance = $myBalance + $totalIncome - $totalExpense;



        return response()->json([
            'expense' => $expense,
            'total_balance' => $totalBalance,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'message' => 'success'
        ]);
    }
}
