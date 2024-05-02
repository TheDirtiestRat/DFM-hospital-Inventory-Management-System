<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.type:RECEPTIONIST,PHARMACIST,ADMIN'], ['only' => ['show']]);
        $this->middleware(['auth', 'user.type:ADMIN'], ['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get list of users
        $users = User::query()->whereNot('type', 'ADMIN')->latest()->paginate(10);
        // get type of users
        $user_types = User::query()->groupBy('type')->get('type');

        return view('user.index', compact('users', 'user_types'));
    }

    public function search_users(Request $request)
    {
        // get the data
        $key = $request->key;

        if ($request->ajax()) {
            $users = User::query()->where('name', 'like', '%' . $key . '%')->latest('created_at')->limit(10)->get();
            return view('components.usersCardList', compact('users'));
            // dd($patient);
        } else {
            $users = User::query()->where('type', '=', $key)->latest('created_at')->paginate(10);
            $user_types = User::query()->groupBy('type')->get('type');
        }

        return view('user.index', compact('users', 'user_types'));
        // return view('components.copyright');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // get the input data required
        $request->validate([
            'username' => 'required|unique:users,name',
            'password' => 'required|confirmed',
            'email' => 'required|unique:users,email',
            'type' => 'required',
        ]);

        // check if the user already exist
        // if (!empty(User::query()->where('name', $request->name)->where('email', $request->email)->first())) {
        //     return redirect()->back()->with('warning', 'User Already Exist.');
        // }

        $data = $request->all();
        // dd($data);

        // store the data in the database user table
        User::query()->create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'type' => $data['type'],
        ]);

        // redirect back
        return redirect()->route('user.index')->with('success', 'New User Added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get data
        $user = User::query()->where('id', $id)->first();

        // dd($user);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // get the input data required
        $request->validate([
            'username' => 'required',
            'password' => 'required|confirmed',
            // 'password' => 'required',
            'email' => 'required',
            'type' => 'required',
        ]);

        $data = $request->all();
        // dd($data);

        // store the data in the database user table
        $user = User::query()->where('id', $id)->update([
            'name' => $data['username'],
            'email' => $data['email'],
            // 'password' => $data['password'],
            'type' => $data['type'],
        ]);

        // redirect back
        return redirect()->route('user.index')->with('success', 'User Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //deletes the record in the database
        $user = User::query()->where('id', $id)->delete();

        // redirect to the index
        return redirect()->route('user.index')->with('success', 'User Remove.');
    }
}
