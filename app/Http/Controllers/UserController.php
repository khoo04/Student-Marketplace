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
                'phone_num' => ['required','unique:users,phone_num'],
                'password' => ['required', 'confirmed', 'min:8'],
                'types' => ['required'],
            ]
        );

        //If buyer the approve status is true
        if ($formFields['types'] == 'buyer'){
            $formFields['approve_status'] = true;
        }

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        if($user->types == 'buyer'){
            auth()->login($user);
            return redirect('/')->with([
                'message' => 'Account created successfully!',
                'type' => 'success',
            ]);
        }
        //Seller
        else{
            return redirect('/')->with([
                'message' => 'Account created and pending approval',
                'type' => 'success',
            ]);
        }
        
    }

    public function logout(Request $request){
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

        if (auth()->attempt($formFields)){
            if (auth()->user()->approve_status == 'approved'){
                $request->session()->regenerate();
                return redirect('/')->with(['message' => 'Login successfully!', 'type' => 'success']);
            }
            else if (auth()->user()->approve_status == 'pending'){
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with(['message' => 'Your account is pending approval','type'=>'alert']);
            }
            else{
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with(['message' => 'Your account registration is rejected','type'=>'alert']);
            }
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
