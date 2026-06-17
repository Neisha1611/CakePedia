<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'member')
            ->latest()
            ->paginate(15);

        return view('profile.listprofilemember', compact('members'));
    }
}