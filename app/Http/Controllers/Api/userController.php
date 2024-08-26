<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserItemRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')->get();
        // $users = User::all();
        return response($users,201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserItemRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        // if(!is_null($validated->image)){
        //     Storage::disk('public')->delete($validated->image);
        // }
        // $validated['image'] = $request->file('image')->storePublicly('images', 'public');
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }
        $user = User::create($validated);
        
        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserItemRequest $request, string $id)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::findOrFail($id);
        if(!is_null($user->image)){
            Storage::disk('public')->delete($user->image);
        }
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }
        // $validated['image'] = $request->file('image')->storePublicly('images', 'public');
        $user = User::where('id', $id)->update($validated);
        return response($user, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
