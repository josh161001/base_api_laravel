<?php

namespace App\Http\Controllers\Vehiculos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculosController extends Controller
{
    public function index(Request $request)
    {


        try {

            $query = DB::table('vehicle as v')
                ->leftJoin('basevehicle as bv', 'v.BaseVehicleID', '=', 'bv.BaseVehicleID')
                ->leftJoin('region as r', 'v.RegionID', '=', 'r.RegionID')
                ->leftJoin('submodel as sm', 'v.SubmodelID', '=', 'sm.SubModelID')
                ->rightJoin('year as y', 'bv.BaseVehicleID', '=', 'y.YearID')
                ->leftJoin('make as m', 'bv.MakeID', '=', 'm.MakeID')
                ->leftJoin('model as ml', 'bv.ModelID', '=', 'ml.ModelID')
                ->leftJoin('vehicletype as vt', 'ml.VehicleTypeID', '=', 'vt.VehicleTypeID')
                ->leftJoin('vehicletypegroup as vtg', 'vt.VehicleTypeGroupID', '=', 'vtg.VehicleTypeGroupID')
                ->select(
                    'v.VehicleID',
                    'bv.BaseVehicleID',
                    'm.MakeName',
                    'r.ParentID',
                    'r.RegionAbbr',
                    'r.RegionName',
                    'sm.SubModelName',
                    'y.YearID',
                    'ml.ModelName',
                    'vt.VehicleTypeName',
                    'vtg.VehicleTypeGroupName'
                );

            // Filtrar por rango de fechas
            if ($request->has('start_date') && $request->has('end_date')) {
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $startDateObj = Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay();
                $endDateObj = Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay();
                $query->whereBetween('v.created_at', [$startDateObj, $endDateObj]);
            }

            // Filtrar por término de búsqueda
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('m.MakeName', 'like', "%$search%")
                        ->orWhere('r.RegionName', 'like', "%$search%")
                        ->orWhere('sm.SubModelName', 'like', "%$search%")
                        ->orWhere('ml.ModelName', 'like', "%$search%")
                        ->orWhere('vt.VehicleTypeName', 'like', "%$search%")
                        ->orWhere('vtg.VehicleTypeGroupName', 'like', "%$search%");
                });
            }

            //  filtrar por limie de consula
            if ($request->has('limit')) {
                $limit = $request->input('limit');
                $query->limit($limit);
            }

            $vehicles = $query->get();

            if ($vehicles->isEmpty()) {
                return response()->json([
                    'message' => 'No hay vehiculos registrados'
                ]);
            }

            return response()->json($vehicles);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener vehiculos',
                'error' => $e->getMessage()
            ]);
        }
    }
}
