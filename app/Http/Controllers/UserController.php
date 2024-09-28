<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return Inertia::render('User/Index',[
            'users' => $users,
            'flash' => session('message') ? ['message' => session('message')] : [],
        ]);
    }

    public function get_all_users()
    {
        $users = User::with('roles')->get();

        return response()->json([
            'users' => $users,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles =Role::all();
       
      
        return Inertia::render('User/Create',[
            'roles' => $roles
        ]);
       
      
        // return response()->json([
        //     'roles' => $roles,
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make("password"),
        ]);

        $user->assignRole($request->role);

        event(new Registered($user));

        return redirect()->route('user.index')->with('message', 'User Created Successfully');

        //return response()->json(['message' => 'User created successfully', 'user' => $user]);
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
    public function edit(User $user)
    {
        $roles =Role::all();

        //$user = User::with('roles')->find($user->id);

        //$roles = User::with('roles')->get();
        return Inertia::render('User/Edit',[
            'user' =>$user->load('roles'),
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,

        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
    public function search(Request $request)
    {
        $search = $request->get('s');
        if ($search != null )
        {
            $users = User::where('name', 'LIKE', "%$search%")
            ->get();
        }
        else {
            $users = User::all();
        }
        return response()->json([
            'users' => $users
        ]);
    }

    public function get_all_roles()
    {
        $roles = Role::with('permissions')->get();

        return response()->json([
            'roles' => $roles,
        ]);
    }
}
