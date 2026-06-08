<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status'  => 'Success',
            'message' => 'Users retrieved successfully',
            'data'    => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status'  => 'Success',
            'message' => 'User created successfully',
            'data'    => $user
        ], 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'User not found',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'Success',
            'message' => 'User found',
            'data'    => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'User not found',
                'data'    => null
            ], 404);
        }

        $user->update([
            'name'     => $request->name ?? $user->name,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json([
            'status'  => 'Success',
            'message' => 'User updated successfully',
            'data'    => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'User not found',
                'data'    => null
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status'  => 'Success',
            'message' => 'User deleted successfully',
            'data'    => null
        ]);
    }
}