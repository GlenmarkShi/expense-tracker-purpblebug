<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch expenses data for chart
        $expenses = Expense::selectRaw('expense_category_id, SUM(amount) as total')
        ->groupBy('expense_category_id')
        ->with('category') // Ensure to load category relationship
        ->get();

    // Prepare the data for the chart
    $chartData = [
        'labels' => $expenses->pluck('category.name'), // Assuming 'name' is the category name
        'totals' => $expenses->pluck('total'),
    ];

    return Inertia::render('Dashboard', [
        'chartData' => $chartData,
    ]);
    }
}
