<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->posts()->latest()->get(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = Auth::user()->posts()->create($request->only('title', 'content'));
        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Auth::user()->posts()->find($id);
        return $post ? response()->json($post, 200)
                     : response()->json(['message' => 'Post not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $post = Auth::user()->posts()->find($id);
        if (!$post) return response()->json(['message' => 'Post not found'], 404);

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'content' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post->update($request->only('title', 'content'));
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $post = Auth::user()->posts()->find($id);
        if (!$post) return response()->json(['message' => 'Post not found'], 404);

        $post->delete();
        return response()->json(['message' => 'Post deleted'], 204);
    }

    // Bonus: Search
    public function search($title)
    {
        $posts = Auth::user()->posts()->where('title', 'like', "%$title%")->get();
        return response()->json($posts, 200);
    }
}

