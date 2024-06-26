<?php

namespace App\Http\Controllers\Archivos;

use App\Http\Controllers\Controller;
use App\Models\Archivos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivosController extends Controller
{

    public function store(Request $request, $id)
    {

        try {
            $request->validate([
                'url_multimedia.*' => 'required|mimes:jpeg,png,mp4'
            ]);

            // Procesar archivos multimedia
            if ($request->hasFile('url_multimedia')) {
                foreach ($request->file('url_multimedia') as $file) {
                    $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $name_file = $file_name . '_' . time() . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs('public/archivos', $name_file);

                    $url = Storage::url($path);

                    // crear registro en la tabla archivos
                    Archivos::create([
                        'id_refaccion' => $id,
                        'url_multimedia' => $url,
                        'mime_type' => $file->getClientMimeType()
                    ]);
                }
            } else {
                return response()->json(['message' => 'No se han enviado archivos'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar los archivos', 'error' => $e], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $archivo = Archivos::find($id);

            if ($archivo) {
                $archivo->delete();
                return response()->json(['message' => 'Archivo eliminado'], 200);
            } else {
                return response()->json(['message' => 'Archivo no encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el archivo', 'error' => $e], 500);
        }
    }
}
