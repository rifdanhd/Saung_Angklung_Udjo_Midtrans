<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        $stats = [
            'total' => User::count(),
            'google' => User::whereNotNull('google_id')->count(),
            'whatsapp' => User::whereNotNull('phone')->count(),
            'email' => User::whereNull('google_id')->whereNull('phone')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }
}
