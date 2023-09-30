<?php

function cardActions()
{
    global $columnsMap, $cardsOnBoardColumns, $discardPile;

    foreach ($columnsMap as $column) {
        $cardsOnBoardColumns[$column] = $_SESSION[$column];
    }

    $cardToRemove = end($cardsOnBoardColumns[$_POST['cardToRemove']]);

    $topRowOfCards = [];
    foreach ($cardsOnBoardColumns as $column) {
        $topRowOfCards[] = end($column);
    }

    $topRowOfCards = array_filter($topRowOfCards, function ($card) use ($cardToRemove) {
        return (is_array($card) && $card['suit'] === $cardToRemove['suit']);
    });

    if (count($topRowOfCards) > 1) {
        uasort($topRowOfCards, function ($a, $b) {
            $letterValue = ['J' => 11, 'Q' => 12, 'K' => '13', 'A' => 14];

            return ((!is_numeric($a['rank']) ? $letterValue[$a['rank']] : $a['rank']) < (!is_numeric($b['rank']) ? $letterValue[$b['rank']] : $b['rank'])) ? -1 : 1;
        });
        if (end($topRowOfCards)['rank'] !== $cardToRemove['rank']) {
            array_pop($cardsOnBoardColumns[$_POST['cardToRemove']]);
            $_SESSION['discardPile'] = $cardToRemove;
            $discardPile = $cardToRemove;

            foreach ($columnsMap as $column) {
                $_SESSION[$column] = $cardsOnBoardColumns[$column];
            }
        }
    }
}
