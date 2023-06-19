<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;

class UserController extends Controller
{
    public function register()
    {
        $data['title'] = 'Register';
        return view('user/register', $data);
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration success. Please login!');
    }


    public function login()
    {
        $data['title'] = 'Login';
        return view('user/login', $data);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'password' => 'Wrong email or password',
        ]);
    }

    public function password()
    {
        $data['title'] = 'Change Password';
        return view('user/password', $data);
    }

    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return back()->with('success', 'Password changed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // TUGAS ADD USER
    public function index()
    {
        $title = "Data User";
        $user = User::orderBy('id', 'asc')->paginate();
        return view('users.index', compact(['user', 'title']));
    }

    public function create()
    {
        $title = "Tambah data user";
        return view('users.create', compact(['title']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'position' => 'required',
            'departement' => 'required',
        ]);

        User::create($request->post());

        return redirect()->route('user.index')->with('success', 'users has been created successfully.');
    }


    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }


    public function edit(User $user)
    {
        $title = "Edit Data User";
        return view('users.edit', compact(['user', 'title']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'position' => 'required',
            'departement' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->departement = $request->departement;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User has been deleted successfully');
    }

    public function exportPdf()
    {
        $title = "Laporan Data User";
        $user = User::orderBy('id', 'asc')->get();

        $pdf = PDF::loadview('users.pdf', compact(['user', 'title']));
        return $pdf->stream('laporan-user-pdf');
    }
}