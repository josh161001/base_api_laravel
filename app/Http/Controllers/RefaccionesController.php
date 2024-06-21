<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefaccionesRequest;
use App\Imports\RefaccionesImport;
use App\Models\Archivos;
use App\Models\Refacciones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RefaccionesController extends Controller
{

    public function index(Request $request)
    {

        try {

            $query = Refacciones::query();

            $query->with('categorias:id,nombre', 'archivos:id,id_refaccion,url_multimedia', 'lineas:id,nombre', 'marcas:id,nombre', 'claves_sat:id,nombre');

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
                    $q->where('modelo', 'like', "%$search%")
                        ->orWhere('descripcion', 'like', "%$search%");
                });
            }

            // limite de la consulta
            if ($request->has('limit')) {
                $limit = $request->input('limit');
                $query->limit($limit);
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


            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    // Generar una ruta única para almacenar el archivo
                    $rutaArchivo = $file->store('public/archivos/refacciones');

                    // Crear registro en la tabla Archivos
                    $archivo = new Archivos();
                    $archivo->id_refaccion = $refaccion->id;
                    $archivo->url_multimedia = Storage::url($rutaArchivo); // Obtener la URL pública del archivo
                    $archivo->save();
                }
            }


            return response()->json($refaccion, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar la refaccion', 'error' => $e], 500);
        }
    }


    public function storeExcel(Request $request)
    {
        try {
            $file = $request->file('import_file');

            Excel::import(new RefaccionesImport, $file);

            return response()->json(['message' => 'Refacciones importadas'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al importar las refacciones', 'error' => $e], 500);
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
