<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Controller;
use App\Models\Categorias;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    //

    public function index()
    {
        try {
            $categorias = Categorias::whereNull('id_padre')->with('subcategorias')->get();

            if ($categorias->isEmpty()) {
                return response()->json(['message' => 'No hay categorias registradas'], 404);
            }

            return response()->json($categorias);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $categoria = new Categorias();
            $categoria->nombre = $request->nombre;
            $categoria->id_padre = $request->id_padre;
            $categoria->save();
            return response()->json($categoria);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        try {
            $categoria = Categorias::find($id);

            if (!$categoria) {
                return response()->json(['message' => 'Categoria no encontrada'], 404);
            }

            return response()->json($categoria);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $categoria = Categorias::find($id);

            if (!$categoria) {
                return response()->json(['message' => 'Categoria no encontrada'], 404);
            }

            $categoria->nombre = $request->nombre;
            $categoria->id_padre = $request->id_padre;
            $categoria->save();
            return response()->json($categoria);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $categoria = Categorias::find($id);

            if (!$categoria) {
                return response()->json(['message' => 'Categoria no encontrada'], 404);
            }

            $categoria->delete();
            return response()->json(['message' => 'Categoria eliminada']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
