<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('Admin.users.index', compact('users'));
    }
 
    public function create ()
    {
        return view('Admin.users.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['required', 'integer' ],
        ]);
 
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        return redirect('/admin/users')->with('message','User Created Successfully');
    }

    public function edit( $userId)
    {
        $user = User::findOrFail($userId);
        return view('Admin.users.edit', compact('user'));
    }

    public function update(Request $request, $userId)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['required', 'integer' ],
        ]);

        User::findOrFail($userId)->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        return redirect('/admin/users')->with('message','User updated Successfully');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect ('/admin/users')->with('message','User Successfully Deleted');
    }
}
