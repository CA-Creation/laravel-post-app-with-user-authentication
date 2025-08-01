<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $posts = auth()->user()->posts()->latest()->get();
    return view('dashboard', compact('posts'));
}
    
}
