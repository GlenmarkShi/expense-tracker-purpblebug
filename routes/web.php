<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// users
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{user}/', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/edit/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.delete');

Route::get('/role', [RoleController::class, 'index'])->name('roles.index');
Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/role/create', [RoleController::class, 'store'])->name('roles.store');
Route::get('/role/{role}', [RoleController::class, 'edit'])->name('roles.edit');
Route::post('/role/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/role/{role}', [RoleController::class, 'delete'])->name('roles.delete');

});

// 

// expense category
Route::get('/expense-category', [ExpenseCategoryController::class, 'index'])->name('expense_category.index');
Route::get('/expense-category/create', [ExpenseCategoryController::class, 'create'])->name('expense_category.create');
Route::post('/expense-category/create', [ExpenseCategoryController::class, 'store'])->name('expense_category.store');
Route::get('/expense-category/edit/{category}', [ExpenseCategoryController::class, 'edit'])->name('expense_category.edit');
Route::post('/expense-category/edit/{category}', [ExpenseCategoryController::class, 'update'])->name('expense_category.update');
Route::delete('/expense-category/{expenseCategory}', [ExpenseCategoryController::class, 'delete'])->name('expense_category.delete');

//
Route::middleware('auth')->group(function () {

Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
Route::get('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
Route::post('/expense/create', [ExpenseController::class, 'store'])->name('expense.store');
Route::get('/expense/{expense}', [ExpenseController::class, 'edit'])->name('expense.edit');
Route::post('/expense/{expense}', [ExpenseController::class, 'update'])->name('expense.update');
Route::delete('/expense{expense}', [ExpenseController::class, 'delete'])->name('expense.delete');
});

//roles






require __DIR__.'/auth.php';
