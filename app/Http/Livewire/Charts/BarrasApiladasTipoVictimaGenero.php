<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BarrasApiladasTipoVictimaGenero extends Component
{
    public $data;
    public $tipoVictimaMasMujeres;
    public $tipoVictimaMenosMujeres;
    public $accidentesTipoVictimaMasMujeres;
    public $accidentesTipoVictimaMenosMujeres;
    public $tipoVictimaMasHombres;
    public $tipoVictimaMenosHombres;
    public $accidentesTipoVictimaMasHombres;
    public $accidentesTipoVictimaMenosHombres;

    public function render()
    {
        return view('livewire.charts.barras-apiladas-tipo-victima-genero');
    }

    public function mount()
    {
        $this->data = Archivo::select('tipo_victima', 'genero')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('tipo_victima', 'genero')
            ->get();

        $this->procesarDatos();
    }

    private function procesarDatos()
    {
        // Procesar datos para obtener información adicional
        $conteoGeneroTipoVictima = [];

        foreach ($this->data as $dato) {
            $conteoGeneroTipoVictima[$dato->genero][$dato->tipo_victima] = ($conteoGeneroTipoVictima[$dato->genero][$dato->tipo_victima] ?? 0) + $dato->total;
        }

        // Obtener el tipo de víctima con más mujeres y el que menos mujeres tiene
        $this->tipoVictimaMasMujeres = $this->obtenerTipoVictimaMasMujeres($conteoGeneroTipoVictima);
        $this->tipoVictimaMenosMujeres = $this->obtenerTipoVictimaMenosMujeres($conteoGeneroTipoVictima);

        // Obtener el número de accidentes para el tipo de víctima con más mujeres y el que menos mujeres tiene
        $this->accidentesTipoVictimaMasMujeres = $conteoGeneroTipoVictima['F'][$this->tipoVictimaMasMujeres] ?? 0;
        $this->accidentesTipoVictimaMenosMujeres = $conteoGeneroTipoVictima['F'][$this->tipoVictimaMenosMujeres] ?? 0;

        // Obtener el tipo de víctima con más hombres y el que menos hombres tiene
        $this->tipoVictimaMasHombres = $this->obtenerTipoVictimaMasHombres($conteoGeneroTipoVictima);
        $this->tipoVictimaMenosHombres = $this->obtenerTipoVictimaMenosHombres($conteoGeneroTipoVictima);

        // Obtener el número de accidentes para el tipo de víctima con más hombres y el que menos hombres tiene
        $this->accidentesTipoVictimaMasHombres = $conteoGeneroTipoVictima['M'][$this->tipoVictimaMasHombres] ?? 0;
        $this->accidentesTipoVictimaMenosHombres = $conteoGeneroTipoVictima['M'][$this->tipoVictimaMenosHombres] ?? 0;
    }

    private function obtenerTipoVictimaMasMujeres($conteoGeneroTipoVictima)
    {
        $tipoVictimaMasMujeres = null;
        $maxConteoMujeres = 0;

        foreach ($conteoGeneroTipoVictima['F'] as $tipoVictima => $conteo) {
            if ($conteo > $maxConteoMujeres) {
                $maxConteoMujeres = $conteo;
                $tipoVictimaMasMujeres = $tipoVictima;
            }
        }

        return $tipoVictimaMasMujeres;
    }

    private function obtenerTipoVictimaMenosMujeres($conteoGeneroTipoVictima)
    {
        $tipoVictimaMenosMujeres = null;
        $minConteoMujeres = PHP_INT_MAX;

        foreach ($conteoGeneroTipoVictima['F'] as $tipoVictima => $conteo) {
            if ($conteo < $minConteoMujeres) {
                $minConteoMujeres = $conteo;
                $tipoVictimaMenosMujeres = $tipoVictima;
            }
        }

        return $tipoVictimaMenosMujeres;
    }

    private function obtenerTipoVictimaMasHombres($conteoGeneroTipoVictima)
    {
        $tipoVictimaMasHombres = null;
        $maxConteoHombres = 0;

        foreach ($conteoGeneroTipoVictima['M'] as $tipoVictima => $conteo) {
            if ($conteo > $maxConteoHombres) {
                $maxConteoHombres = $conteo;
                $tipoVictimaMasHombres = $tipoVictima;
            }
        }

        return $tipoVictimaMasHombres;
    }

    private function obtenerTipoVictimaMenosHombres($conteoGeneroTipoVictima)
    {
        $tipoVictimaMenosHombres = null;
        $minConteoHombres = PHP_INT_MAX;

        foreach ($conteoGeneroTipoVictima['M'] as $tipoVictima => $conteo) {
            if ($conteo < $minConteoHombres) {
                $minConteoHombres = $conteo;
                $tipoVictimaMenosHombres = $tipoVictima;
            }
        }

        return $tipoVictimaMenosHombres;
    }
}
