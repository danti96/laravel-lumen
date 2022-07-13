<?php

namespace App\Http\Controllers;

use App\Models\Mascotas;
use App\Models\MascotasCitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MascotasController extends Controller
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
    public function index()
    {
        $mascotas = Mascotas::get();
        return response()->json([
            "count" => $mascotas->count(),
            "data" => $mascotas
        ], 200);
    }
    public function register(Request $request)
    {
        if ($request->isJson()) {
            $this->validate($request, [
                "nombre" => "required",
                "raza" => "required",
            ], [
                "nombre.required" => "Nombre es requerido",
                "raza.required" => "Raza es requerido",
            ]);

            $key_allow = $this->keysAllow($request->all(), ['nombre', 'raza', 'remember_token']);
            if (count($key_allow) > 0) {
                return response()->json([
                    "Message" => "Keys not allowed",
                    "keys" => $key_allow
                ], 400, []);
            }

            $data = $request->json()->all();

            try {
                DB::beginTransaction();
                $mascota = new Mascotas();
                $mascota->nombre = $data['nombre'];
                $mascota->raza = $data['raza'];
                $mascota->save();
                DB::commit();
                return response()->json($mascota, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(["error" => $th->getMessage()], 400, []);
            }
        }
        return response()->json(["error" => "Format not allowed"], 401, []);
    }
    public function search($id)
    {
        try {
            $mascota = Mascotas::where('id', $id)->first();
            return response()->json([
                "count" => $mascota->count(),
                "data" => $mascota
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 400, []);
        }
    }
    public function update(Request $request)
    {
        if ($request->isJson()) {
            $this->validate($request, [
                "nombre" => "required",
                "raza" => "required",
                "id" => "required",
            ], [
                "nombre.required" => "Nombre es requerido",
                "raza.required" => "Raza es requerido",
                "id.required" => "Id es requerido",
            ]);

            $key_allow = $this->keysAllow($request->all(), ['nombre', 'raza', 'remember_token', 'id']);
            if (count($key_allow) > 0) {
                return response()->json([
                    "Message" => "Keys not allowed",
                    "keys" => $key_allow
                ], 400, []);
            }

            $data = $request->json()->all();

            try {
                DB::beginTransaction();
                $mascota = Mascotas::where('id', $data['id'])->first();
                $mascota->nombre = $data['nombre'];
                $mascota->raza = $data['raza'];
                $mascota->save();
                DB::commit();
                return response()->json($mascota, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(["error" => $th->getMessage()], 400, []);
            }
        }
        return response()->json(["error" => "Format not allowed"], 401, []);
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $mascota = Mascotas::where('id', $id)->first();
            $mascota->delete();
            DB::commit();
            return response()->json(["message" => "Delete successful"], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["error" => $th->getMessage()], 400, []);
        }
    }
    /* Citas */

    public function mascotascitas()
    {
        $mascotas = MascotasCitas::get();
        return response()->json([
            "count" => $mascotas->count(),
            "data" => $mascotas
        ], 200);
    }
    public function mascotasregister(Request $request)
    {
        if ($request->isJson()) {
            $this->validate($request, [
                "mascota_id" => "required",
                "fecha_agendamiento" => "required",
            ], [
                "mascota_id.required" => "Mascota es requerido",
                "fecha_agendamiento.required" => "Fecha de agendamiento es requerido",
            ]);

            $key_allow = $this->keysAllow($request->all(), ['mascota_id', 'fecha_agendamiento', 'remember_token']);
            if (count($key_allow) > 0) {
                return response()->json([
                    "Message" => "Keys not allowed",
                    "keys" => $key_allow
                ], 400, []);
            }

            $data = $request->json()->all();

            try {
                DB::beginTransaction();
                $mascota = new MascotasCitas();
                $mascota->mascota_id = $data['mascota_id'];
                $mascota->fecha_agendamiento = $data['fecha_agendamiento'];
                $mascota->save();
                DB::commit();
                return response()->json($mascota, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(["error" => $th->getMessage()], 400, []);
            }
        }
        return response()->json(["error" => "Format not allowed"], 401, []);
    }
    public function mascotassearch($id)
    {
        try {
            $mascota = MascotasCitas::where('id', $id)->first();
            return response()->json([
                "count" => $mascota->count(),
                "data" => $mascota
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 400, []);
        }
    }
    public function mascotasupdate(Request $request)
    {
        if ($request->isJson()) {
            $this->validate($request, [
                "mascota_id" => "required",
                "fecha_agendamiento" => "required",
                "id" => "required",
            ], [
                "mascota_id.required" => "Nombre es requerido",
                "fecha_agendamiento.required" => "Raza es requerido",
                "id.required" => "Id es requerido",
            ]);

            $key_allow = $this->keysAllow($request->all(), ['mascota_id', 'fecha_agendamiento', 'remember_token', 'id']);
            if (count($key_allow) > 0) {
                return response()->json([
                    "Message" => "Keys not allowed",
                    "keys" => $key_allow
                ], 400, []);
            }
            $data = $request->json()->all();

            try {
                DB::beginTransaction();
                $mascota = MascotasCitas::where('id', $data['id'])->first();
                $mascota->mascota_id = $data['mascota_id'];
                $mascota->fecha_agendamiento = $data['fecha_agendamiento'];
                $mascota->save();
                DB::commit();
                return response()->json($mascota, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(["error" => $th->getMessage()], 400, []);
            }
        }
        return response()->json(["error" => "Format not allowed"], 401, []);
    }
    public function mascotasdelete($id)
    {
        try {
            DB::beginTransaction();
            $mascota = MascotasCitas::where('id', $id)->first();
            $mascota->delete();
            DB::commit();
            return response()->json(["message" => "Delete successful"], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["error" => $th->getMessage()], 400, []);
        }
    }
    private function keysAllow($data, $keys)
    {
        for ($i = 0; $i < count($keys); $i++) {
            $item = $keys[$i];
            unset($data[$item]);
        }
        return $data;
    }
}
