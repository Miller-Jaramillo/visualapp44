<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoBarrasApiladas extends Component
{
    public $data = [];

    public function render()
    {
        // Consulta para obtener la cantidad de accidentes por tipo de víctima y clase de accidente
        $data = DB::table('archivos')
            ->select('tipo_victima', 'clase_accidente', DB::raw('count(*) as total'))
            ->groupBy('tipo_victima', 'clase_accidente')
            ->get();

        $this->data = $data->toArray();
        return view('livewire.charts.grafico-barras-apiladas');
    }
}
