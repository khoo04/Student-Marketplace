<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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
            if (auth()->user()->types == 'admin') {
                return redirect()->route('admin');
            }
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
        if (!Hash::check($request->old_password, $user->password)) {
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

    public function updateAccountStatus(Request $request)
    {
        $userID = $request->input('userID');
        $status = $request->input('status');

        $user = User::find($userID);

        $user->update(['approve_status' => $status]);

        return response()->json(['success' => true]);
    }

    public function getSellerDetails(Request $request)
    {
        $userID = $request->input('userID');
        $user = User::find($userID);

        return response()->json([
            'sellerName' => $user->first_name . ' ' . $user->last_name,
            'phoneNum' => $user->phone_num,
            'email' => $user->email,
            'bank_name' => $user->bank_name,
            'bank_acc_name' => $user->bank_acc_name,
            'bank_acc_num' => $user->bank_acc_num,
        ]);
    }

    public function createBankDetails()
    {
        $user = auth()->user();
        if ($user->bank_name == null || $user->bank_acc_name == null || $user->bank_acc_num == null){
            return view('profiles.update_bank');
        }
        return redirect()->route('main');
    }

    public function updateBankDetails(Request $request)
    {
        $formFields = $request->validate(
            [
                'issue_bank' => ['required'],
                'bankAccHolderName' => ['required', 'string', 'max:255'],
                'bankAccNum' => ['required', function ($attribute, $value, $fail) {
                    if (!preg_match('/^[0-9\-]+$/', $value)) {
                        return $fail('The bank account number can only contain numbers and hyphens.');
                    }
                }],
            ]
        );

        //Current User
        $user = auth()->user();

        $user->update([
            'bank_name' => $formFields['issue_bank'],
            'bank_acc_name' => $formFields['bankAccHolderName'],
            'bank_acc_num' => $formFields['bankAccNum'],
        ]);

        return redirect()->route('profile')->with(['message' => 'Bank details updated successfully.', 'type' => 'success']);
    }
}
