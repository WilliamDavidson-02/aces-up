<?php

$values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
$suits = ['C', 'D', 'H', 'S'];
$deck = [];
$stockDeck = [];
$discardDeck = [];


function createDeck() {
    global $suits, $values, $deck;
    
    foreach($suits as $suit) {
        foreach($values as $value) {
            $deck[] = [$suit, $value];
        }
    }
    
    shuffle($deck);
}

createDeck();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Aces Up</title>
</head>
<body>
    <form class="playing-board-form" method="post">
        <section class="playing-board">
            <?php for ($index = 0; $index < 4; $index++): ?>
            <div class="card-container card-size">
                <h3><?= $deck[$index][1] ?></h3>
                <h1><?= $deck[$index][0] ?></h1>
                <h3><?= $deck[$index][1] ?></h3>
            </div>
            <?php endfor; ?>
        </section>
        <div class="user-interaction-container">
            <button type="submit" class="back-of-card">
                <img src="./images/Card_back_01.svg" alt="">
            </button>
            <div class="discard-pile"></div>    
        </div>
    </form>
</body>
</html>