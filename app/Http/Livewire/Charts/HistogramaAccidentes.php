<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class HistogramaAccidentes extends Component
{
    public $edades;

    public function render()
    {
        // Consulta para obtener las edades de las personas involucradas en accidentes
        $this->edades = Archivo::pluck('edad')->toArray();

        return view('livewire.charts.histograma-accidentes');
    }
}
