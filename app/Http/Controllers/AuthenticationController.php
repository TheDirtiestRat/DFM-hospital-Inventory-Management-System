<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login () {
        return view('authentication.login');
    }

    public function login_user (Request $request) {
        // validate the request
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        // check if the user is registered
        $user = User::query()->where('name', $credentials['name'])->first();
        // dd($credentials);
        if ($user == null) {
            return back()->with('error', 'Unidentified User');
        }

        // authenticate user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // check user types to log in to its proper homepage
            $url = "/dashboard";
            if (Auth::user()->type == "PHARMACIST") {
                $url = "/dashboardPharmacist";
            } else if (Auth::user()->type == "RECEPTIONIST") {
                $url = "/dashboardReceptionist";
            }

            // page to go to when successfully login
            return redirect($url);
        }

        // else failed
        return back()->with('error', 'Failed to login. (username or password is incorrect)');
    }

    public function logout_user (Request $request) {
        // log out the user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('info', 'user has logout.');
    }

    public function my_birthday(Request $request) {
        // if they guess my birthday go here
        $data = $request->all();

        if ($data['code'] == '03192001') {
            return view('pages.image-srp');
        }

        if ($data['code'] == 'whenlealisboard') {
            return view('pages.brick-gm');
        }

        return back();
    }
}
