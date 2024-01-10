<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoBurbujasAccidentes extends Component
{
    public $data = [];

    public function render()
    {
        // Consulta para obtener la cantidad de accidentes por edad y lesión
        $data = Archivo::select('edad', 'lesion', DB::raw('count(*) as total'))
            ->groupBy('edad', 'lesion')
            ->get();

        $this->data = $data->toArray();

        return view('livewire.charts.grafico-burbujas-accidentes');
    }
}
