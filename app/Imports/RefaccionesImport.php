<?php

namespace App\Imports;

use App\Models\Categorias;
use App\Models\Marcas;
use App\Models\Refacciones;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RefaccionesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $categorias;
    private $marcas;

    public function __construct()
    {
        $this->categorias = Categorias::pluck('id', 'nombre');
        $this->marcas = Marcas::pluck('id', 'nombre');
    }

    public function model(array $row)
    {
        $categoriaId = null;



        $models = $row['models'];

        $models = trim($models, "[]'");

        $models = explode("','", $models);

        $models = array_map(function ($model) {
            return trim($model, "'");
        }, $models);

        $row['models'] = json_encode($models);


        // Verificar si la categoría ya existe
        if (isset($this->categorias[$row['categoria']])) {
            // Si existe, obtener el ID
            $categoriaId = $this->categorias[$row['categoria']];
        } else {
            $categoria = new Categorias();
            $categoria->nombre = $row['categoria'];
            $categoria->save();

            // Actualizar la lista de categorías
            $this->categorias = Categorias::pluck('id', 'nombre');
            $categoriaId = $categoria->id;
        }

        if (isset($this->marcas[$row['marca']])) {
            $marcaId = $this->marcas[$row['marca']];
        } else {
            $marca = new Marcas();
            $marca->nombre = $row['marca'];
            $marca->save();

            $this->marcas = Marcas::pluck('id', 'nombre');
            $marcaId = $marca->id;
        }
        return new Refacciones([
            'id_categoria' => $categoriaId,
            'id_marca' => $marcaId,
            'modelo' => $row['modelo'],
            'descripcion' => $row['descripcion'],
            'models' => $row['models'],
            'position' => $row['position'],
        ]);
    }

    public function batchSize(): int
    {
        return 4000;
    }

    public function chunkSize(): int
    {
        return 4000;
    }
}
