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
} else if (isset($_POST['newRound'])) {
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
} else if (isset($_POST['cardToRemove'])) {
    $cardsFirstColumn = $_SESSION['cardsFirstColumn'];
    $cardsSecondColumn = $_SESSION['cardsSecondColumn'];
    $cardsThirdColumn = $_SESSION['cardsThirdColumn'];
    $cardsFourthColumn = $_SESSION['cardsFourthColumn'];

    $selectedCard = ['rank' => str_split($_POST['cardToRemove'])[0], 'suit' => str_split($_POST['cardToRemove'])[1]];
    print_r($selectedCard);
    $topRowOfCards = [end($cardsFirstColumn), end($cardsSecondColumn), end($cardsThirdColumn), end($cardsFourthColumn)];
    $topRowOfCards = array_filter($topRowOfCards, function($card) {
        global $selectedCard;

        return $card['suit'] === $selectedCard['suit'];
    });
    uasort($topRowOfCards, function($a, $b) {
        $letterValue = ['J' => 11, 'Q' => 12, 'K' => '13', 'A' => 14];
          
        return ((!is_numeric($a['rank']) ? $letterValue[$a['rank']] : $a['rank']) < (!is_numeric($b['rank']) ? $letterValue[$b['rank']] : $b['rank'])) ? -1 : 1;
    });
    print_r($topRowOfCards);
    // filter await no match suits and sort remaining card by value and if cardToRemove is first then remove it and if there is only one card of the suit don't remove anything
    // if there are more then 2 cards check if the card to remove is not the last one when sorted
    // handle move card to another column if the column is empty and the card to remove can't be removed.
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
                    <?php foreach($columnContainer[$i] as $key => $card): 
                        if ($key === count($columnContainer[$i]) - 1): ?>
                        <button type="submit" name="cardToRemove" value="<?= $card['rank'] . $card['suit']; ?>" class="card-container card-size <?php echo ($card['suit'] === 'H' || $card['suit'] === 'D') ? 'card-color' : ''; ?>" style="top: <?= $key * 20; ?>px">
                            <h3><?= $card['rank']; ?></h3>
                            <h1><?= $card['suit']; ?></h1>
                            <h3><?= $card['rank']; ?></h3>
                        </button>
                        <?php else: ?>
                        <div class="card-container card-size <?php echo ($card['suit'] === 'H' || $card['suit'] === 'D') ? 'card-color' : ''; ?>" style="top: <?= $key * 20; ?>px">
                            <h3><?= $card['rank']; ?></h3>
                            <h1><?= $card['suit']; ?></h1>
                            <h3><?= $card['rank']; ?></h3>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </section>
        <section class="user-interaction-container">
            <button type="submit" name="newRound" class="back-of-card card-size">
                <img src="./images/Card_back_01.svg" alt="">
            </button>
            <div class="discard-pile card-size"></div>   
            <button class="reset-game" name="reset">Reset game</button>
        </section>
    </form>
</body>
</html>