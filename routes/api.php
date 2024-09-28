<?php

use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Expense;
use App\Models\ExpenseCategory;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_all_users', [UserController::class, 'get_all_users']);
Route::get('/search_user', [UserController::class, 'search'])->name('user.search');

Route::get('/get_all_roles', [UserController::class, 'get_all_roles']);

Route::get('/get_all_expense_categories', [ExpenseCategoryController::class, 'get_all_expense_categories']);

//Route::middleware('auth:sanctum')->group(function () {
Route::get('/get_all_expenses', [ExpenseController::class, 'get_all_expenses']);

Route::get('/get_all_permissions', [RoleController::class, 'get_all_permissions']);
//});





