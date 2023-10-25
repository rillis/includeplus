<?php

function tempoAtras($dataHora) {
    $dataFornecida = new DateTime($dataHora);
    $dataAtual = new DateTime();

    $intervalo = $dataAtual->diff($dataFornecida);

    $minutosAtras = $intervalo->i + $intervalo->h * 60 + $intervalo->d * 24 * 60;

    if ($minutosAtras < 60) {
        return "$minutosAtras minutos atrás";
    } else {
        $horasAtras = floor($minutosAtras / 60);
        return "$horasAtras horas atrás";
    }
}