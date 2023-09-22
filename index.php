<?php

session_start();

$deck = [];
$cardsOnBoard = [];

if (isset($_POST['reset']) && isset($_SESSION['deck'])) {
    unset($_SESSION['deck']);
    unset($_SESSION['cardsOnBoard']);
}

if (!isset($_SESSION['deck'])) {
    createDeck();
} else {
    // get session data
    $deck = $_SESSION['deck'];
    $deck = array_splice($deck, 4);
    $cardsOnBoard = [...$_SESSION['cardsOnBoard'], ...array_splice($deck, 0, 4)];

    // save updated session data
    $_SESSION['deck'] = $deck;
    $_SESSION['cardsOnBoard'] = $cardsOnBoard;
}

function createDeck() {
    global $deck, $cardsOnBoard;

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

    $cardsOnBoard = array_splice($deck, 0, 4);
    $_SESSION['cardsOnBoard'] = $cardsOnBoard;
    
    $deck = array_splice($deck, 4);
    $_SESSION['deck'] = $deck;
}

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
            <?php foreach($cardsOnBoard as $card): ?>
            <div class="card-container card-size <?php echo ($card['suit'] === 'H' || $card['suit'] === 'D') ? 'card-color' : ''; ?>">
                <h3><?= $card['rank'] ?></h3>
                <h1><?= $card['suit'] ?></h1>
                <h3><?= $card['rank'] ?></h3>
            </div>
            <?php endforeach; ?>
        </section>
        <section class="user-interaction-container">
            <button type="submit" class="back-of-card card-size">
                <img src="./images/Card_back_01.svg" alt="">
            </button>
            <div class="discard-pile card-size"></div>   
            <button class="reset-game" name="reset">Reset game</button>
        </section>
    </form>
</body>
</html>