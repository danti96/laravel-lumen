<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function login(Request $request)
    {
        if ($request->isJson()) {
            $this->validate($request, [
                "email" => "required",
                "password" => "required",
            ], [
                "email.required" => "Email es requerido",
                "password.required" => "Password es requerido",
            ]);

            $data = $request->json()->all();

            try {
                $user = User::where(['email' => $data['email']])->first();
                if ($user && Hash::check($data['password'], $user->password)) {
                    $user->remember_token = Str::random(60);
                    $user->save();
                    return response()->json($user, 200);
                } else {
                    return response()->json(["error" => "email and password do not match"], 500, []);
                }
            } catch (\Throwable $th) {
                return response()->json(["error" => $th->getMessage()], 400, []);
            }
        }
        return response()->json(["error" => "Format not allowed"], 401, []);
    }
    public function register(Request $request)
    {
        if ($request->isJson()) {
            $this->validate($request, [
                "name" => "required",
                "email" => "required",
                "password" => "required",
            ], [
                "name.required" => "name es requerido",
                "email.required" => "Email es requerido",
                "password.required" => "Password es requerido",
            ]);

            $data = $request->json()->all();
            if ($this->existsUser($data['email'])) {
                return response()->json(["error" => "Email ya existe"], 400, []);
            }
            try {
                DB::beginTransaction();
                $user = new User();
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = Hash::make($data['password']);
                $user->save();
                DB::commit();
                return response()->json($user, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(["error" => $th->getMessage()], 400, []);
            }
        }
        return response()->json(["error" => "Format not allowed"], 401, []);
    }
    public function existsUser($email)
    {
        $user = User::where([
            'email' => $email,
        ])->count();

        if ($user == 0) {
            return false;
        } else {
            return true;
        }
    }
    //
}
