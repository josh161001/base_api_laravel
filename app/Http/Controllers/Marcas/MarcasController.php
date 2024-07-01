<?php

namespace App\Http\Controllers\Marcas;

use App\Http\Controllers\Controller;
use App\Models\Marcas;
use Illuminate\Http\Request;

class MarcasController extends Controller
{


    public function index()
    {

        try {

            $marcas =  Marcas::all();

            if ($marcas->isEmpty()) {
                return response()->json(['message' => 'No hay marcas registradas'], 404);
            }

            return response()->json($marcas);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener las marcas', 'error' => $e], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $marca = new Marcas();
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
            $marca = Marcas::find($id);

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
            $marca = Marcas::find($id);

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
            $marca = Marcas::find($id);

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
