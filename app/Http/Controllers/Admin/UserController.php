<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }
    
    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        return back()->with('success', 'Statut utilisateur modifié.');
    }
}