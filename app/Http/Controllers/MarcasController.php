<?php

namespace App\Http\Controllers;

use App\Models\marcas;
use Illuminate\Http\Request;

class MarcasController extends Controller
{


    public function index()
    {

        try {

            $marcas =  marcas::all();
            return response()->json($marcas);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener las marcas', 'error' => $e], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $marca = new marcas();
            $marca->nombre = $request->nombre;
            $marca->save();
            return response()->json($marca);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar la marca', 'error' => $e], 500);
        }
    }

    public function show($id)
    {
        try {
            $marca = marcas::find($id);

            if (!$marca) {
                return response()->json(['message' => 'Marca no encontrada'], 404);
            }

            return response()->json($marca);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener la marca'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $marca = marcas::find($id);

            if (!$marca) {
                return response()->json(['message' => 'Marca no encontrada'], 404);
            }
            $marca->nombre = $request->nombre;
            $marca->save();
            return response()->json($marca, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la marca'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $marca = marcas::find($id);

            if (!$marca) {
                return response()->json(['message' => 'Marca no encontrada'], 404);
            }

            $marca->delete();
            return response()->json(['message' => 'Marca eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la marca'], 500);
        }
    }
}
