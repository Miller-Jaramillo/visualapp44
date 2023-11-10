<?php

namespace App\Imports;

use App\Models\Archivo;
use App\Models\Registro;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ArchivosImport implements ToCollection
{
    protected $registro;

    public function __construct(Registro $registro)
    {
        $this->registro = $registro;
    }
    public function collection(Collection $rows)
    {
        // Comenzar desde la segunda fila para omitir los encabezados
        foreach ($rows->skip(1) as $row) {
            // Verificar si la fila está vacía
            if ($row->filter(function ($value) {
                return $value !== null && $value !== '';
            })->isNotEmpty()) {
                // Obtener el valor de fecha de Excel (asegúrate de que sea la columna correcta)
                $excelDate = $row[0]; // Asumiendo que la fecha está en la primera columna

                // Convertir el valor de fecha de Excel a un número (formato Excel)
                $excelValue = (float)$excelDate;

                // Convertir el número de Excel a una fecha
                $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($excelValue);

                // Crear una fecha a partir del timestamp
                $fecha = date('Y-m-d', $timestamp);

                // Crear un nuevo registro_accidente y asignar los valores desde el archivo XLSX
                Archivo::create([
                    'fecha' => $fecha,
                    'direccion' => $row[1] ?? null,
                    'barrio' => $row[2] ?? null,
                    'comuna' => $row[3] ?? null,
                    'codigo_postal' => $row[4] ?? null,
                    'edad' => $row[5] ?? null,
                    'genero' => $row[6] ?? null,
                    'tipo_victima' => $row[7] ?? null,
                    'clase_accidente' => $row[8] ?? null,
                    'caso_accidente' => $row[9] ?? null,
                    'lesion' => $row[10] ?? null,
                    'hipotesis' => $row[11] ?? null,
                    'registro_id' => $this->registro->id, // Asociamos el id del registro
                ]);
            }
        }
    }


}
