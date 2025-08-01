<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('search');

    $posts = Auth::user()
        ->posts()
        ->when($query, function ($q) use ($query) {
            $q->where('title', 'like', '%' . $query . '%');
        })
        ->latest()
        ->paginate(10); 

    return view('dashboard', compact('posts'));
}
    
}
