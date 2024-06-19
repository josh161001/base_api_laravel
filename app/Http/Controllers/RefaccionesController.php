<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefaccionesRequest;
use App\Models\Refacciones;
use Illuminate\Http\Request;

class RefaccionesController extends Controller
{

    public function index(Request $request)
    {

        try {

            $query = Refacciones::query();

            // limitar la cantidad de registros
            if ($request->has('limit')) {

                $query->limit($request->query('limit'));
            }

            // filtrar por fechas //trabajando
            if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {

                $query->whereBetween('created_at', [$request->query('fecha_inicio'), $request->query('fecha_fin')]);
            }

            // filtrar por search 

            if ($request->has('search')) {

                $searchDB = $request->query('search');

                $query->where(function ($consulta) use ($searchDB) {
                    $consulta->where('modelo', 'LIKE', '%' . $searchDB . '%')
                        ->orWhere('sku', 'LIKE', '%' . $searchDB . '%')
                        ->orWhere('informacion', 'LIKE', '%' . $searchDB . '%')
                        ->orWhere('descripcion', 'LIKE', '%' . $searchDB . '%')
                        ->orWhere('herramientas', 'LIKE', '%' . $searchDB . '%')
                        ->orWhere('sintomas_fallas', 'LIKE', '%' . $searchDB . '%')
                        ->orWhere('intercambios', 'LIKE', '%' . $searchDB . '%');
                });
            }

            // Filtrar por cantidad
            if ($request->has('cantidad')) {
                $cantidad = $request->query('cantidad');
                $query->where('cantidad', $cantidad);
            }

            // filtrar por categoria
            if ($request->has('id_categoria')) {
                $query->where('id_categoria', $request->query('id_categoria'));
            }

            // filtrar por marca
            if ($request->has('id_marca')) {
                $query->where('id_marca', $request->query('id_marca'));
            }

            // filtrar por linea
            if ($request->has('id_linea')) {
                $query->where('id_linea', $request->query('id_linea'));
            }

            // filtrar por clave sat
            if ($request->has('id_clave_sat')) {
                $query->where('id_clave_sat', $request->query('id_clave_sat'));
            }

            $refacciones = $query->get();

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
