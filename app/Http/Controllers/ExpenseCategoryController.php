<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expenseCategories = ExpenseCategory::all();
        return Inertia::render('ExpenseCategory/Index',[
            'expenseCategories' =>  $expenseCategories,
        ]);
    }

    public function get_all_expense_categories()
    {
        $expenseCategories = ExpenseCategory::all();
        return response()->json([
            'expenseCategories' => $expenseCategories,
        ]);
    }

    public function create()
    {
        return Inertia::render('ExpenseCategory/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        ExpenseCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
        return redirect()->route('expense_category.index')->with('message', 'Expense Category Created Successfuly');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return Inertia::render('ExpenseCategory/Edit',[
            'expenseCategory' => $expenseCategory,
        ]);
    }

    public function update(Request $request, string $id) 
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string' ,

        ]);

        $expenseCategory->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('expense_category.index')->with('success', 'Expense Category updated successfully');
    }

    public function delete(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return redirect()->route('expense_category.index')->with('success', 'Expense Category deleted successfully.');
    }
}
