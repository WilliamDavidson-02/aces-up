<?php

function createDeck() {
    global $deck, $cardsFirstColumn, $cardsSecondColumn, $cardsThirdColumn, $cardsFourthColumn;

    $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    $suits = ['C', 'D', 'H', 'S'];
    
    foreach($suits as $suit) {
        foreach($ranks as $rank) {
            $deck[] = [
                'suit' => $suit,
                'rank' => $rank
            ];
        }
    }

    shuffle($deck);

    $cardsForNewRound = array_splice($deck, 0, 4);
    $_SESSION['cardsFirstColumn'] = [$cardsForNewRound[0]];
    $_SESSION['cardsSecondColumn'] = [$cardsForNewRound[1]];
    $_SESSION['cardsThirdColumn'] = [$cardsForNewRound[2]];
    $_SESSION['cardsFourthColumn'] = [$cardsForNewRound[3]];

    $cardsFirstColumn = $_SESSION['cardsFirstColumn'];
    $cardsSecondColumn = $_SESSION['cardsSecondColumn'];
    $cardsThirdColumn = $_SESSION['cardsThirdColumn'];
    $cardsFourthColumn = $_SESSION['cardsFourthColumn'];
    
    $_SESSION['deck'] = $deck;
}