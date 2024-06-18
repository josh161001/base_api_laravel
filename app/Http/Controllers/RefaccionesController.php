<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefaccionesRequest;
use App\Models\Refacciones;
use Illuminate\Http\Request;

class RefaccionesController extends Controller
{

    public function index()
    {

        try {
            $refacciones = Refacciones::all();

            if ($refacciones->isEmpty()) {
                return response()->json(['message' => 'No hay refacciones'], 404);
            }

            return response()->json($refacciones, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener las refacciones', 'error' => $e], 500);
        }
    }

    public function show($id)
    {
        try {
            $refaccion = Refacciones::find($id);

            if (!$refaccion) {
                return response()->json(['message' => 'Refaccion no encontrada'], 404);
            }

            return response()->json($refaccion, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener la refaccion'], 500);
        }
    }


    public function store(RefaccionesRequest $request)
    {
        try {
            $refaccion = Refacciones::create($request->all());
            return response()->json($refaccion, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar la refaccion', 'error' => $e], 500);
        }
    }

    public function update(RefaccionesRequest $request, $id)
    {
        try {
            $refaccion = Refacciones::find($id);

            if (!$refaccion) {
                return response()->json(['message' => 'Refaccion no encontrada'], 404);
            }

            $refaccion->update($request->all());

            return response()->json($refaccion, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la refaccion'], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $refaccion = Refacciones::find($id);

            if (!$refaccion) {
                return response()->json(['message' => 'Refaccion no encontrada'], 404);
            }

            $refaccion->delete();

            return response()->json(['message' => 'Refaccion eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la refaccion'], 500);
        }
    }
}
