<?php

namespace App\Http\Controllers\Lineas;

use App\Http\Controllers\Controller;
use App\Models\Lineas;
use Illuminate\Http\Request;

class LineasController extends Controller
{

    public function index()
    {
        try {
            $lineas = lineas::all();
            return response()->json($lineas);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener las lineas', 'error' => $e], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $linea = new lineas();
            $linea->nombre = $request->nombre;
            $linea->save();
            return response()->json(["message" => "Linea creada", $linea], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar la linea', 'error' => $e], 500);
        }
    }

    public function show($id)
    {
        try {
            $linea = lineas::find($id);
            return response()->json($linea, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'linea no encontrada'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $linea = lineas::find($id);
            $linea->nombre = $request->nombre;
            $linea->save();
            return response()->json(['message' => 'Linea actualizada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la linea'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $linea = lineas::find($id);

            if (!$linea) {
                return response()->json(['message' => 'Linea no encontrada'], 404);
            }

            $linea->delete();
            return response()->json(['message' => 'Linea eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la linea'], 500);
        }
    }
}
