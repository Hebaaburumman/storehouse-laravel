<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Hash; // Import the Hash facade for password handling
use Illuminate\Support\Facades\Session;



class UserController extends Controller
{
    public function create()
    {

        return view('Users.create');
    }

    public function list()
{
    
   
    $users =user::orderBy('created_at', 'desc')->get();
   

    return view('Users.index', ['users' => $users]);
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|regex:/^(\S+\s*){3,}$/|max:255', // At least 4 words
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|max:20',
    ], [
        'name.regex' => 'The name must contain at least 4 words.',
        'password.min' => 'The password must be at least 6 characters.',
        'password.max' => 'The password must not exceed 20 characters.',
    ]);

    // Validation passed, proceed to create the user
    $user = new User();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = bcrypt($request->input('password'));
    $user->save();

    return redirect()->route('users.list', $user->id)->with('success', 'User created successfully');
}



    
   
    
    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('user.list')->with('success', 'user deleted successfully');
    }

    
//     public function show($user)
// {
//     $user = User::find($user);

//     if (!$user) {
//         abort(404, 'User not found');
//     }

//     // Assuming you have a relationship defined in the User model for posts
//     $posts = $user->posts()->latest()->get();
//     $userFriends = $user->getExistingFriendNames();

//     return view('userprofile', compact('user', 'posts','userFriends'));
// }
// public function showProfile(User $user)
//     {
//         // Assuming you have a relationship defined in the User model for posts
//         $posts = $user->posts()->latest()->get();       
//         $userFriends = $user->getExistingFriendNames();
 
//         return view('profile', compact('user', 'posts','userFriends'));
//     }


public function edit($id)
{
    $user = User::findOrFail($id);

    return view('Users.edit', compact('user'));
}



public function update(Request $request, $userId)
{
    $request->validate([
        'name' => 'required|string|regex:/^(\S+\s*){3,}$/|max:255', // At least 4 words
        'email' => 'required|email',
        'password' => 'nullable|string|min:6|max:20',
    ], [
        'name.regex' => 'The name must contain at least 4 words.',
        'password.min' => 'The password must be at least 6 characters.',
        'password.max' => 'The password must not exceed 20 characters.',
    ]);

    // Fetch the user by the provided $userId
    $user = User::findOrFail($userId);

    // Update user fields
    $user->name = $request->input('name');
    $user->email = $request->input('email');

    // Update password if provided
    if ($request->filled('password')) {
        $user->password = bcrypt($request->input('password'));
    }

    $user->save();

    return redirect()->route('users.list', ['id' => $user->id])->with('success', 'User updated successfully.');
}


public function destroy($id)
{
    $user = User::find($id);

    // if (!$user) {
    //     abort(404, 'User not found');
    // }

    $user->delete();

    // Flash a success message to the session
    Session::flash('success', 'User deleted successfully.');

    return redirect()->route('users.list'); // Change this route to the appropriate route for your application
}
}