<?php

namespace App\Http\Controllers;

use App\Models\claves_sat;
use Illuminate\Http\Request;

class Claves_SATController extends Controller
{

    public function index()
    {
        try {
            $claves_sat = claves_sat::all();
            return response()->json($claves_sat);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener las claves SAT', 'error' => $e], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $clave_sat = new claves_sat();
            $clave_sat->clave = $request->clave;
            $clave_sat->save();

            return response()->json(['message' => 'Clave SAT creada', 'clave_sat' => $clave_sat]);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Error al guardar la clave SAT', 'error' => $e], 500);
        }
    }

    public function show($id)
    {
        try {
            $clave_sat = claves_sat::find($id);

            if (!$clave_sat) {
                return response()->json(['message' => 'Clave SAT no encontrada'], 404);
            }

            return response()->json($clave_sat);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener la clave SAT'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $clave_sat = claves_sat::find($id);

            if (!$clave_sat) {
                return response()->json(['message' => 'Clave SAT no encontrada'], 404);
            }

            $clave_sat->clave = $request->clave;
            $clave_sat->save();
            return response()->json($clave_sat);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la clave SAT'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $clave_sat = claves_sat::find($id);

            if (!$clave_sat) {
                return response()->json(['message' => 'Clave SAT no encontrada'], 404);
            }

            $clave_sat->delete();

            return response()->json(['message' => 'Clave SAT eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la la clave SAT '], 500);
        }
    }
}
