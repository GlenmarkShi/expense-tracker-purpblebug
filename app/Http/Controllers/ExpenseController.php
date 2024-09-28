<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $user = Auth::user();
        $expenses = Expense::with(['category', 'user'])
        ->where('user_id', $user->id) 
        ->get();
        return Inertia::render('Expense/Index', [
            'expenses' => $expenses,
        ]);
    }
    
    private function getAuthenticatedUser()
{
    return auth()->user(); // Return the authenticated user
}

    public function get_all_expenses()
    {
        // $user = Auth::user();
        $user = $this->getAuthenticatedUser();

        $expenses = Expense::with(['category', 'user'])
        ->where('user_id',  $user->id) 
        ->get();
        return response()->json([
            'expenses' => $expenses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ExpenseCategory::all();
        return Inertia::render('Expense/Create',[
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required',
            'entry_date' => 'required',
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'expense_category_id' => $request->expense_category_id,
            'amount' => $request->amount,
            'entry_date' => $request->entry_date,
        ]);
        
        return redirect()->route('expense.index')->with('message', 'Expense Created Successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $expenseCategories = ExpenseCategory::all();

        return Inertia::render('User/Edit',[
            'expense' =>$expense->load('category'),
            'expenseCategories' => $expenseCategories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::findOrFail($id);

        $request->validate([
            'expense_category_id' => 'exists:expense_categories,id',
            'amount' => 'required|',
            'entry_date' => 'required'

        ]);

        $expense->update([
            'expense_category_id' => $request->expense_category_id,
            'amount' => $request->amount,
            'entry_date' => $request->entry_date,
        ]);

      
        return redirect()->route('expense.index')->with('success', 'Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Expense deleted successfully.');
        
    }
}
