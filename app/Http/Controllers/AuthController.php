<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index(Request $request)
    {
        try {
            $query =  User::query();

            // Filtrar por rango de fechas
            if ($request->has('start_date') && $request->has('end_date')) {
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $startDateObj = Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay();
                $endDateObj = Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDateObj, $endDateObj]);
            }

            // Filtrar por término de búsqueda
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nombre_completo', 'like', "%$search%")
                        ->orWhere('correo', 'like', "%$search%");
                });
            }

            // Aplicar límite a la consulta
            if ($request->has('limit')) {
                $limit = $request->input('limit');
                $query->limit($limit);
            }

            $query->whereNull('id_padre')->with('subUsuarios')->get();

            if ($query->get()->isEmpty()) {
                return response()->json(['message' => 'No hay usuarios registrados'], 404);
            }

            return response()->json($query->get());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener los usuarios', 'error' => $e->getMessage()]);
        }
    }


    public function store(Request $request)
    {

        try {
            $request->validate([
                'nombre_completo' => 'required|string',
                'correo' => 'required|email|unique:users',
                'movil' => 'required|string',
                'contrasena' => 'required|string',
            ]);

            $user = new User();
            $user->nombre_completo = $request->nombre_completo;
            $user->correo = $request->correo;
            $user->id_padre = $request->id_padre;
            $user->id_rol = $request->id_rol;
            $user->movil = $request->movil;
            $user->contrasena = Hash::make($request->contrasena);
            $user->save();

            return response()->json(['message' => 'Usuario creado correctamente', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el usuario', 'error' => $e->getMessage()]);
        }
    }

    public function login(LoginRequest $request)
    {

        try {

            $user = User::where('correo', $request->correo)->first();

            if (!$user || !Hash::check($request->contrasena, $user->contrasena)) {
                return response()->json(['message' => 'Credenciales incorrectas'], 401);
            }

            if ($user->correo_verified_at == null || $user->estatus == 0) {
                return response()->json(['message' => 'Correo no verificado'], 401);
            }

            $token = $user->createToken($request->correo)->plainTextToken;

            return response()->json(['message' => 'Inicio de sesión exitoso', 'user' => $user,  'token' => $token], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al iniciar sesión', 'error' => $e->getMessage()]);
        }
    }


    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al cerrar sesión', 'error' => $e->getMessage()]);
        }
    }
}
