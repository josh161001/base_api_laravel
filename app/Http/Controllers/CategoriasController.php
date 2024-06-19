<?php

namespace App\Http\Controllers;

use App\Models\categorias;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    //

    public function index()
    {
        try {
            $categorias = categorias::whereNull('id_padre')->with('subcategorias')->get();
            return response()->json($categorias);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $categoria = new categorias();
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
            $categoria = categorias::find($id);
            return response()->json($categoria);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $categoria = categorias::find($id);
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
            $categoria = categorias::find($id);
            $categoria->delete();
            return response()->json(['message' => 'Categoria eliminada']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
