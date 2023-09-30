<?php

function cardActions()
{
    global $columnsMap, $cardsOnBoardColumns, $discardPile;

    foreach ($columnsMap as $column) {
        $cardsOnBoardColumns[$column] = $_SESSION[$column];
    }

    $selectedCard = end($cardsOnBoardColumns[$_POST['selectedCard']]);

    if (is_array($selectedCard)) {
        $topRowOfCards = [];
        foreach ($cardsOnBoardColumns as $column) {
            $topRowOfCards[] = end($column);
        }

        $filteredTopRowOfCards = array_filter($topRowOfCards, function ($card) use ($selectedCard) {
            return (is_array($card) && $card['suit'] === $selectedCard['suit']);
        });

        if (count($filteredTopRowOfCards) > 1) {
            uasort($filteredTopRowOfCards, function ($a, $b) {
                $letterValue = ['J' => 11, 'Q' => 12, 'K' => '13', 'A' => 14];

                return ((!is_numeric($a['rank']) ? $letterValue[$a['rank']] : $a['rank']) < (!is_numeric($b['rank']) ? $letterValue[$b['rank']] : $b['rank'])) ? -1 : 1;
            });
            if (end($filteredTopRowOfCards)['rank'] !== $selectedCard['rank']) {
                array_pop($cardsOnBoardColumns[$_POST['selectedCard']]);
                $_SESSION['discardPile'] = $selectedCard;
                $discardPile = $selectedCard;

                foreach ($columnsMap as $column) {
                    $_SESSION[$column] = $cardsOnBoardColumns[$column];
                }
            }
        } else {
            $emptyColumns = $cardsOnBoardColumns;
            $emptyColumns = array_filter($emptyColumns, function ($column) {
                return (count($column) === 0);
            }, ARRAY_FILTER_USE_BOTH);

            // If there are more the 1 empty column the shuffle will make the selection of column random every time.
            $columnsKeys = array_keys($emptyColumns);
            shuffle($columnsKeys);

            if (count($emptyColumns) > 0) {
                array_pop($cardsOnBoardColumns[$_POST['selectedCard']]);
                $cardsOnBoardColumns[$columnsKeys[0]][] = $selectedCard;

                foreach ($columnsMap as $column) {
                    $_SESSION[$column] = $cardsOnBoardColumns[$column];
                }
            }
        }
    }
}
