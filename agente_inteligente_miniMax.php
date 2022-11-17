<?php
function tabuleiro()
{
    return [
        1 => ' ', 2 => ' ', 3 => ' ',
        4 => ' ', 5 => ' ', 6 => ' ',
        7 => ' ', 8 => ' ', 9 => ' ',
    ];
}

function mostrarTabuleiro($tabuleiro)
{
    print_r(' ' . $tabuleiro[1] . ' │ ' . $tabuleiro[2] . ' │ ' . $tabuleiro[3] . '
');
    print_r('───┼───┼───
');
    print_r(' ' . $tabuleiro[4] . ' │ ' . $tabuleiro[5] . ' │ ' . $tabuleiro[6] . '
');
    print_r('───┼───┼───
');
    print_r(' ' . $tabuleiro[7] . ' │ ' . $tabuleiro[8] . ' │ ' . $tabuleiro[9] . '
    ');
    print_r('
    ');
}

function espacoEmBranco($tabuleiro, $posicao)
{
    if ($tabuleiro[$posicao] == ' ') {
        return True;
    } else {
        return False;
    }
}

function verificarVencedor($tabuleiro, $letra)
{
    if ($tabuleiro[1] == $tabuleiro[2] and $tabuleiro[1] == $tabuleiro[3] and $tabuleiro[1] == $letra) {
        return True;
    }
    if ($tabuleiro[4] == $tabuleiro[5] and $tabuleiro[4] == $tabuleiro[6] and $tabuleiro[4] == $letra) {
        return True;
    }
    if ($tabuleiro[7] == $tabuleiro[8] and $tabuleiro[7] == $tabuleiro[9] and $tabuleiro[7] == $letra) {
        return True;
    }

    if ($tabuleiro[1] == $tabuleiro[4] and $tabuleiro[1] == $tabuleiro[7] and $tabuleiro[1] == $letra) {
        return True;
    }
    if ($tabuleiro[2] == $tabuleiro[5] and $tabuleiro[2] == $tabuleiro[8] and $tabuleiro[2] == $letra) {
        return True;
    }
    if ($tabuleiro[3] == $tabuleiro[6] and $tabuleiro[3] == $tabuleiro[9] and $tabuleiro[3] == $letra) {
        return True;
    }

    if ($tabuleiro[1] == $tabuleiro[5] and $tabuleiro[1] == $tabuleiro[9] and $tabuleiro[1] == $letra) {
        return True;
    }
    if ($tabuleiro[7] == $tabuleiro[5] and $tabuleiro[7] == $tabuleiro[3] and $tabuleiro[7] == $letra) {
        return True;
    }

    return False;
}

function deuVelha($tabuleiro)
{

    foreach ($tabuleiro as $valor) {
        if ($valor == ' ') {
            return False;
        }
    }

    return True;
}

function minimax($tabuleiro, $depth, $ehMaximizing)
{
    if (verificarVencedor($tabuleiro, 'X')) {
        return 1;
    }

    if (verificarVencedor($tabuleiro, 'O')) {
        return -1;
    }

    if (deuVelha($tabuleiro)) {

        return 0;
    }

    if ($ehMaximizing) {
        $best_score = -800;
        foreach ($tabuleiro as $key => $valor) {
            if ($valor == ' ') {
                $tabuleiro[$key] = 'O';
                $score = minimax($tabuleiro, $depth + 1, False);  #Next move should minimize
                $tabuleiro[$key] = ' ';
                if ($score > $best_score) {

                    $best_score = $score;
                }
            }
        }

        return $best_score;
    } else {
        $best_score = 800;
        foreach ($tabuleiro as $key => $valor) {
            if ($valor == ' ') {
                $tabuleiro[$key] = 'X';
                $score = minimax($tabuleiro, $depth + 1, True);  # Next move should maximize
                $tabuleiro[$key] = ' ';
                if ($score < $best_score) {

                    $best_score = $score;
                }
            }
        }
        return $best_score;
    }
}


function inserirLetra($tabuleiro, $letra, $posicao)
{
    if (espacoEmBranco($tabuleiro, $posicao)) {
        $tabuleiro[$posicao] = $letra;
        print_r('');
        mostrarTabuleiro($tabuleiro);

        if (deuVelha($tabuleiro)) {
            print_r('Empate!');
            exit;
        }
        if (verificarVencedor($tabuleiro, 'O')) {
            print_r('O computador ganhou!
        ');
            exit;
        }
        if (verificarVencedor($tabuleiro, 'X')) {
            print_r('Você ganhou!
        ');
            exit;
        }
    } else {
        print_r('A posição escolhida está ocupada!
    ');
        $posicao = (int)readline('Digite a posição para sua jogada  X: ');
        $tabuleiro = inserirLetra($tabuleiro, $letra, $posicao);
    }

    return $tabuleiro;
}

function movimentoHumano($tabuleiro)
{
    $posicao = (int)readline('Digite a posição para sua jogada  X: ');
    return inserirLetra($tabuleiro, 'X', $posicao);
}


function movimentoComputador($tabuleiro)
{
    $best_score = -800;
    $best_move = 0;

    foreach ($tabuleiro as $key => $valor) {
        if ($valor == ' ') {
            $tabuleiro[$key] = ' ';
            $score = minimax($tabuleiro, 0, False);
            $tabuleiro[$key] = ' ';
            if ($score > $best_score) {
                $best_score = $score;
                $best_move = $key;
            }
        }
    }
    print_r('Jogada do computador:' . $best_move . '
');
    return inserirLetra($tabuleiro, 'O', $best_move);
}


print('Posições para jogar
');
print(' 1 │ 2 │ 3
');
print('───┼───┼───
');
print(' 4 │ 5 │ 6
');
print('───┼───┼───
');
print(' 7 │ 8 │ 9
');


$tabuleiro = tabuleiro();

while (!verificarVencedor($tabuleiro, 'X') || !verificarVencedor($tabuleiro, 'O')) {
    $tabuleiro = movimentoHumano($tabuleiro);
    $tabuleiro = movimentoComputador($tabuleiro);
}