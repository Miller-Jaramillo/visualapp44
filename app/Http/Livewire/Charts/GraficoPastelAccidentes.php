<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoPastelAccidentes extends Component
{
    public $labels = [];
    public $counts = [];
    public $selectedRegistroId;
    public $conteoMujeres;
    public $conteoHombres;

    public function mount()
    {
        // Obtener todos los registros para el elemento select
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.charts.grafico-pastel-accidentes', [
            'registros' => Registro::all(),
        ]);
    }

    // Método para responder a cambios en la opción seleccionada
    public function updatedSelectedRegistroId()
    {
        $this->loadData();
        $this->emit('updateChart', $this->selectedRegistroId);
    }

    // Método para cargar datos del gráfico
    private function loadData()
    {
        // Consultar el conteo general si no se selecciona ningún registro específico
        if (!$this->selectedRegistroId) {
            $this->conteoMujeres = Archivo::where('genero', 'F')->count();
            $this->conteoHombres = Archivo::where('genero', 'M')->count();
        } else {
            // Consultar el conteo específico para el registro seleccionado
            $this->conteoMujeres = Archivo::where('genero', 'F')
                ->where('registro_id', $this->selectedRegistroId)
                ->count();

            $this->conteoHombres = Archivo::where('genero', 'M')
                ->where('registro_id', $this->selectedRegistroId)
                ->count();
        }

        // Actualizar datos para el gráfico
        $this->labels = ['Mujeres', 'Hombres'];
        $this->counts = [$this->conteoMujeres, $this->conteoHombres];
    }
}
