<?php

$suits = ['♥', '♦', '♠', '♣'];
$ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K', 'A'];
$deck = [];

foreach ($suits as $suit) {
    foreach ($ranks as $rank) {
        $deck[] = [
            'rank' => $rank,
            'suit' => $suit
        ];
    }
}

shuffle($deck);

$_SESSION['deck'] = $deck;
$_SESSION['discardPile'] = $discardPile;

foreach ($columnsMap as $column) {
    $_SESSION[$column] = [];
}
