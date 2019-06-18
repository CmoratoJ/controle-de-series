<?php

namespace App\Services;


use App\Serie;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $ep_por_temporada):Serie
    {
        DB::beginTransaction();
        $serie = Serie::create(['nome' => $nomeSerie]);
        $this->criaTemporadas($qtdTemporadas, $serie, $ep_por_temporada);
        DB::commit();

        return $serie;
    }

    private function criaTemporadas(int $qtdTemporadas, $serie, int $ep_por_temporada): void
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);

            $this->criaEpisodios($ep_por_temporada, $temporada);
        }
    }

    private function criaEpisodios(int $ep_por_temporada, $temporada): void
    {
        for ($j = 1; $j <= $ep_por_temporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}
