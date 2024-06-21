<?php

namespace App\Imports;

use App\Models\Refacciones;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RefaccionesImport implements ToModel, WithHeadingRow,  WithBatchInserts, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $models = $row['models'];

        $models = trim($models, "[]'");

        $models = explode("','", $models);

        $models = array_map(function ($model) {
            return trim($model, "'");
        }, $models);

        $row['models'] = json_encode($models);



        return new Refacciones([
            'id_marca' => 1,
            'id_categoria' => 1,
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
