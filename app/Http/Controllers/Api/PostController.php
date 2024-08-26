<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\postItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->select('posts.id', 'posts.title', 'posts.description', 'posts.image', 'posts.created_at', 'posts.updated_at', 'posts.user_id', 'users.name', 'users.image as user_image')
        ->orderBy('posts.created_at', 'desc')
        ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Validate request data
        $validated = $request->validated();

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Add the authenticated user's ID to the validated data
        $validated['user_id'] = $user->id;

        // Create the post
        $post = PostItems::create($validated);

        // Return a successful response with the created post data
        return response()->json([
            'message' => 'Post created successfully',
            'data' => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->select('posts.id', 'posts.title', 'posts.description', 'posts.image', 'posts.created_at', 'posts.updated_at', 'posts.user_id', 'users.name', 'users.image as user_image')
        ->where('posts.id', $id)
        ->get();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
