<?php

namespace App\Http\Controllers;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginView(Request $request)
    {
        // Check if the user is already authenticated
        if ($request->user()) {
            return redirect()->route('home'); // Redirect to home if authenticated
        }
        return view('login'); // Show the login view if not authenticated
    }



    public function login(Request $request)
    {
        // Update validation to accept 'identifier' instead of 'email'
        $request->validate([
            'identifier' => 'required',  // Accept either username or email
            'password' => 'required',
        ]);

        // Get the identifier input
        $identifier = $request->input('identifier');

        // Determine if the identifier is an email or a username
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt to authenticate using the determined field
        if (auth()->attempt([$field => $identifier, 'password' => $request->password])) {
            $request->session()->regenerate();
            return response()->json(['success' => true, 'message' => 'You are logged in successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'The provided credentials do not match our records.'], 422);
    }


    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect to the login page after logging out
        return redirect()->route('login.view')->with('success', 'You have been logged out successfully.');
    }
    

    public function registerView()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new \App\Models\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Registration successful! You can now log in.']);
    }
}
