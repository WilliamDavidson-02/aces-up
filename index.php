<?php

session_start();

require_once __DIR__ . '/createCards.php';

$deck = [];
$cardsFirstColumn = [];
$cardsSecondColumn = [];
$cardsThirdColumn = [];
$cardsFourthColumn = [];

if (isset($_POST['reset']) && isset($_SESSION['deck'])) {
    unset($_SESSION['deck']);
    unset($_SESSION['cardsFirstColumn']);
    unset($_SESSION['cardsSecondColumn']);
    unset($_SESSION['cardsThirdColumn']);
    unset($_SESSION['cardsFourthColumn']);
}

if (!isset($_SESSION['deck'])) {
    createDeck();
} else {
    // get session data
    $deck = $_SESSION['deck'];
    $cardsForNewRound = array_splice($deck, 0, 4);
    $cardsFirstColumn = [...$_SESSION['cardsFirstColumn'], $cardsForNewRound[0]];
    $cardsSecondColumn = [...$_SESSION['cardsSecondColumn'], $cardsForNewRound[1]];
    $cardsThirdColumn = [...$_SESSION['cardsThirdColumn'], $cardsForNewRound[2]];
    $cardsFourthColumn = [...$_SESSION['cardsFourthColumn'], $cardsForNewRound[3]];
    
    // save updated session data
    $_SESSION['deck'] = $deck;
    $_SESSION['cardsFirstColumn'] = $cardsFirstColumn;
    $_SESSION['cardsSecondColumn'] = $cardsSecondColumn;
    $_SESSION['cardsThirdColumn'] = $cardsThirdColumn;
    $_SESSION['cardsFourthColumn'] = $cardsFourthColumn;
}

$columnContainer = [$cardsFirstColumn, $cardsSecondColumn, $cardsThirdColumn, $cardsFourthColumn];

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
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="cards-column">
                    <?php foreach($columnContainer[$i] as $key => $card): ?>
                    <div class="card-container card-size <?php echo ($card['suit'] === 'H' || $card['suit'] === 'D') ? 'card-color' : ''; ?>" style="top: <?= $key * 20; ?>px">
                        <h3><?= $card['rank']; ?></h3>
                        <h1><?= $card['suit']; ?></h1>
                        <h3><?= $card['rank']; ?></h3>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
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