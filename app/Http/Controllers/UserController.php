<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    //Show Register Form
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'phone_num' => ['required', 'unique:users,phone_num'],
                'password' => ['required', 'confirmed', 'min:8'],
                'types' => ['required'],
            ]
        );

        //If buyer the approve status is true
        if ($formFields['types'] == 'buyer') {
            $formFields['approve_status'] = true;
        }

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        if ($user->types == 'buyer') {
            auth()->login($user);
            return redirect('/')->with([
                'message' => 'Account created successfully!',
                'type' => 'success',
            ]);
        }
        //Seller
        else {
            return redirect('/')->with([
                'message' => 'Account created and pending approval',
                'type' => 'success',
            ]);
        }

    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with(['message' => 'You have been logged out!', 'type' => 'success']);
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]
        );

        if (auth()->attempt($formFields)) {
            if (auth()->user()->approve_status == 'approved') {
                $request->session()->regenerate();
                return redirect('/')->with(['message' => 'Login successfully!', 'type' => 'success']);
            } else if (auth()->user()->approve_status == 'pending') {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with(['message' => 'Your account is pending approval', 'type' => 'alert']);
            } else {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with(['message' => 'Your account registration is rejected', 'type' => 'alert']);
            }
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function updateDetails(Request $request)
    {
        $user = auth()->user();
        $formFields = $request->validate(
            [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            ]
        );

        $user->update($formFields);

        return redirect()->back()->with([
            'message' => 'Account updated successfully!',
            'type' => 'success',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        // Check if the old password is correct
        if (!\Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        }

        // Update the password
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->with([
            'message' => 'Password updated successfully!',
            'type' => 'success',
        ]);
    }

}