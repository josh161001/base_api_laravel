<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    /**
     * Mostrar todos los clientes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {

            $query = Clientes::query();
            // Filtrar por fecha 
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
                    $q->where('nombre', 'like', "%$search%")
                        ->orWhere('RFC', 'like', "%$search%");
                });
            }
            // Aplicar límite a la consulta
            if ($request->has('limit')) {
                $limit = $request->input('limit');
                $query->limit($limit);
            }

            $query->where('estatus', 1);

            $query->with('usuario');

            $query = $query->get();

            if ($query->isEmpty()) {
                return response()->json([
                    'message' => 'No hay clientes registrados'
                ], 404);
            }

            return response()->json([
                'message' => 'Clientes encontrados',
                'clientes' => $query
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener clientes',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validar los datos requeridos
            $request->validate([
                'nombre' => 'required',
                'RFC' => 'required',
                'json' => 'required|array',
                'contacto' => 'required|array',
                'id_usuario' => 'required',
            ]);

            // Crear un nuevo cliente
            $cliente = new Clientes();
            $cliente->nombre = $request->nombre;
            $cliente->RFC = $request->RFC;
            $cliente->informacion_adicional = [
                'calle_no' => $request->json['calle_no'],
                'colonia' => $request->json['colonia'],
                'ciudad' => $request->json['ciudad'],
                'estado' => $request->json['estado'],
                'pais' => $request->json['pais'],
                'codigo_postal' => $request->json['codigo_postal'],
                'forma_pago' => $request->json['forma_pago'],
                'dias_credito' => $request->json['dias_credito'],
                'lim_credito' => $request->json['lim_credito'],
                'dias_bloqueo' => $request->json['dias_bloqueo'],
                'lista_precios' => $request->json['lista_precios'],
                'uso_cfdi' => $request->json['uso_cfdi'],
                'regimen_fiscal' => $request->json['regimen_fiscal'],
            ];
            $cliente->contacto = [
                'nombre' => $request->contacto['nombre'],
                'tel_oficina_i' => $request->contacto['tel_oficina_i'],
                'tel_oficina_ii' => $request->contacto['tel_oficina_ii'],
                'tel_movil' => $request->contacto['tel_movil'],
                'correo' => $request->contacto['correo'],
                'etiqueta' => $request->contacto['etiqueta'],
                'observaciones_contacto' => $request->contacto['observaciones_contacto'],
                'pin' => $request->contacto['pin'],
            ];

            $cliente->id_usuario = $request->id_usuario;
            $cliente->observaciones = $request->observaciones;

            $cliente->save();

            return response()->json([
                'message' => 'Cliente creado',
                'cliente' => $cliente
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {

        try {
            $cliente = Clientes::find($id);

            if (!$cliente) {
                return response()->json([
                    'message' => 'Cliente no encontrado'
                ], 404);
            }

            return response()->json([
                'message' => 'Cliente encontrado',
                'cliente' => $cliente
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {


            // Validar los datos requeridos
            $request->validate([
                'nombre' => 'required',
                'RFC' => 'required',
                'json' => 'required|array',
                'contacto' => 'required|array',
                'id_usuario' => 'required',
            ]);

            // Buscar el cliente
            $cliente = Clientes::find($id);

            if (!$cliente) {
                return response()->json([
                    'message' => 'Cliente no encontrado'
                ], 404);
            }

            // Actualizar el cliente
            $cliente->nombre = $request->nombre;
            $cliente->RFC = $request->RFC;
            $cliente->informacion_adicional = [
                'calle_no' => $request->json['calle_no'],
                'colonia' => $request->json['colonia'],
                'ciudad' => $request->json['ciudad'],
                'estado' => $request->json['estado'],
                'pais' => $request->json['pais'],
                'codigo_postal' => $request->json['codigo_postal'],
                'forma_pago' => $request->json['forma_pago'],
                'dias_credito' => $request->json['dias_credito'],
                'lim_credito' => $request->json['lim_credito'],
                'dias_bloqueo' => $request->json['dias_bloqueo'],
                'lista_precios' => $request->json['lista_precios'],
                'uso_cfdi' => $request->json['uso_cfdi'],
                'regimen_fiscal' => $request->json['regimen_fiscal'],
            ];
            $cliente->contacto = [
                'nombre' => $request->contacto['nombre'],
                'tel_oficina_i' => $request->contacto['tel_oficina_i'],
                'tel_oficina_ii' => $request->contacto['tel_oficina_ii'],
                'tel_movil' => $request->contacto['tel_movil'],
                'correo' => $request->contacto['correo'],
                'etiqueta' => $request->contacto['etiqueta'],
                'observaciones_contacto' => $request->contacto['observaciones_contacto'],
                'pin' => $request->contacto['pin'],
            ];

            $cliente->id_usuario = $request->id_usuario;
            $cliente->observaciones = $request->observaciones;

            $cliente->save();

            return response()->json([
                'message' => 'Cliente actualizado',
                'cliente' => $cliente
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $cliente = Clientes::find($id);

            if (!$cliente) {
                return response()->json([
                    'message' => 'Cliente no encontrado'
                ], 404);
            }

            $cliente->estatus = 0;

            $cliente->save();

            return response()->json([
                'message' => 'Cliente eliminado'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
