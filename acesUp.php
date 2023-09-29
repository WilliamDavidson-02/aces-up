<?php
session_start();

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/createDeck.php';

$columnsMap = ['firstColumn', 'secondColumn', 'thirdColumn', 'fourthColumn'];

if (isset($_POST['newGame'])) {
    unset($_SESSION['deck']);
    foreach ($columnsMap as $key => $column) {
        unset($_SESSION[$column]);
    }
}

if (!isset($_SESSION['deck'])) {
    createDeck();
}

$deck = $_SESSION['deck'];

if (count($deck) > 0) {
    $newRoundOfCards = array_splice($deck, 0, 4);
    foreach ($columnsMap as $key => $column) {
        $cardsOnBoardColumns[$column] = [...$_SESSION[$column], $newRoundOfCards[$key]];
        $_SESSION[$column] = $cardsOnBoardColumns[$column];
    }
    $_SESSION['deck'] = $deck;
} else {
    foreach ($columnsMap as $key => $column) {
        $cardsOnBoardColumns[$column] = $_SESSION[$column];
    }
}

?>

<main class="aces-up-container">
    <section class="game-board-container">
        <?php foreach ($cardsOnBoardColumns as $column) : ?>
            <div class="card-column">
                <?php foreach ($column as $key => $card) : ?>
                    <div class="card card-size <?= ($card['suit'] == '♥' || $card['suit'] == '♦') ? 'red-card' : ''; ?>" style="top: <?= $key * 40 ?>px;">
                        <h3><?= $card['rank'] ?></h3>
                        <h3><?= $card['suit'] ?></h3>
                        <h3><?= $card['rank'] ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </section>
    <form class="aces-game-controls" method="post">
        <button class="round-btn card-size">
            <?php if (count($deck) / 4 <= 5) : ?>
                <div class="count-down-container"><?= (count($deck) / 4); ?></div>
            <?php endif; ?>
            <img src="/images/Card_back_01.svg" alt="button of card">
        </button>
        <div class="empty-card-container card-size"></div>
        <button class="new-game empty-card-container" type="submit" name="newGame">New game</button>
    </form>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>