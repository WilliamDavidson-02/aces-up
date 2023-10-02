<?php

function cardContentType($card)
{
    global $rankGrid, $rankValue;

    $letterValue = ['J' => 11, 'Q' => 12, 'K' => 13, 'A' => 14];
    $rankValue = (is_numeric($card['rank'])) ? $card['rank'] : $letterValue[$card['rank']];
    switch ($rankValue) {
        case ($rankValue === 4 || $rankValue === 6):
            $rankGrid = 'twoColumnGrid';
            break;
        case ($rankValue === 5 || $rankValue >= 7):
            $rankGrid = 'threeColumnGrid';
            break;
        default:
            $rankGrid = 'oneColumnGrid';
    }
}
