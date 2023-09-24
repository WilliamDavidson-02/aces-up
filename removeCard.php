<?php

function removeCard() {
    global $cardsFirstColumn, $cardsSecondColumn, $cardsThirdColumn, $cardsFourthColumn, $discardPile;
    
    $cardsFirstColumn = $_SESSION['cardsFirstColumn'];
    $cardsSecondColumn = $_SESSION['cardsSecondColumn'];
    $cardsThirdColumn = $_SESSION['cardsThirdColumn'];
    $cardsFourthColumn = $_SESSION['cardsFourthColumn'];

    $cardValues = explode(" ", $_POST['cardToRemove']); // values from card button.
    $index = $cardValues[2];
    $columns = ['cardsFirstColumn', 'cardsSecondColumn', 'cardsThirdColumn', 'cardsFourthColumn'];
    $selectedCardInColumn = $columns[$index];
    $selectedCardIndex = $cardValues[3];

    $selectedCard = ['rank' => $cardValues[0], 'suit' => $cardValues[1]];
    $topRowOfCards = [end($cardsFirstColumn), end($cardsSecondColumn), end($cardsThirdColumn), end($cardsFourthColumn)];
    $topRowOfCards = array_filter($topRowOfCards, function($card) use ($selectedCard) {
        return (is_array($card) && $card['suit'] === $selectedCard['suit']);
    });
    if (count($topRowOfCards) > 1) {
        uasort($topRowOfCards, function($a, $b) {
            $letterValue = ['J' => 11, 'Q' => 12, 'K' => '13', 'A' => 14];
              
            return ((!is_numeric($a['rank']) ? $letterValue[$a['rank']] : $a['rank']) < (!is_numeric($b['rank']) ? $letterValue[$b['rank']] : $b['rank'])) ? -1 : 1;
        });
        if (end($topRowOfCards)['rank'] !== $selectedCard['rank']) {
            array_splice(${$selectedCardInColumn}, $selectedCardIndex, 1);
            
            $_SESSION['cardsFirstColumn'] = $cardsFirstColumn;
            $_SESSION['cardsSecondColumn'] = $cardsSecondColumn;
            $_SESSION['cardsThirdColumn'] = $cardsThirdColumn;
            $_SESSION['cardsFourthColumn'] = $cardsFourthColumn;
            $_SESSION['discardPile'] = $selectedCard;
            $discardPile = $selectedCard;
        }
    }
    // handle move card to another column if the column is empty and the card to remove can't be removed.
}