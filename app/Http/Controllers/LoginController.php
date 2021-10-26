<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    const USER_TYPES = [
        'rd' => 0,
        'qa' => 1
    ];
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->name)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'name' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = '';
        if ($user->type == self::USER_TYPES['rd']) {
            $token = $user->createToken('token-name', ['ticket:resolve'])->plainTextToken;
        }

        if ($user->type == self::USER_TYPES['qa']) {
            $token = $user->createToken('token-name', ['ticket:update', 'ticket:create', 'ticket:delete'])->plainTextToken;
        }

        return response()->json([
            'name' => $user->name,
            'type' => $user->type,
            'token' => $token
        ]);
    }
}
