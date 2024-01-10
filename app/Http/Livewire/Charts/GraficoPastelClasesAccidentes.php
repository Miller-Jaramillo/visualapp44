<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoPastelClasesAccidentes extends Component
{
    public $labels = [];
    public $counts = [];

    public function render()
    {
        // Consulta para obtener las clases de accidente y la cantidad de accidentes por clase
        $data = Archivo::groupBy('clase_accidente')
            ->select('clase_accidente', DB::raw('count(*) as total'))
            ->get();

        // Extraer etiquetas y recuentos de la respuesta
        $this->labels = $data->pluck('clase_accidente')->toArray();
        $this->counts = $data->pluck('total')->toArray();

        return view('livewire.charts.grafico-pastel-clases-accidentes');
    }
}
