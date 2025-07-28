<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('token-personal')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::post('/register-teste', function (\Illuminate\Http\Request $request) {
    $user = User::create([
        'name' => $request->input('name', 'teste'),
        'email' => $request->input('email', 'teste@example.com'),
        'password' => Hash::make($request->input('password', '123456')),
    ]);

    return response()->json(['message' => 'Usuário criado com sucesso', 'user' => $user]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
