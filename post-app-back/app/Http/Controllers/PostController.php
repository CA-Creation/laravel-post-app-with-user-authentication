<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
        {
            $posts = Post::with('user')->latest()->get();
            return view('posts.index', compact('posts'));
        }

    public function create()
        {
            return view('posts.create');
        }

    public function store(Request $request)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required',
                'image' => 'nullable|image|max:2048',
            ]);

            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');
                $post->image = $path;
            }

            $post->user_id = auth()->id();
            $post->save();

            return redirect()->route('dashboard')->with('success', 'Post created successfully!');
        }


    public function show(Post $post)
        {
            return view('posts.show', compact('post'));
        }

    public function edit(Post $post)
        {
            return view('posts.edit', compact('post'));
        }

    public function update(Request $request, Post $post)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required',
                'image' => 'nullable|image|max:2048',
            ]);

            $post->title = $request->title;
            $post->content = $request->content;

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }

                $path = $request->file('image')->store('images', 'public');
                $post->image = $path;
            }

            $post->save();

            return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
        }


    public function destroy(Post $post)
        {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $post->delete();

            return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
        }

}
