<?php
session_start();

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/cardActions.php';

$columnsMap = ['firstColumn', 'secondColumn', 'thirdColumn', 'fourthColumn'];
$cardsOnBoardColumns = [];
$discardPile = [];

if (isset($_POST['newGame'])) {
    unset($_SESSION['deck']);
    foreach ($columnsMap as $key => $column) {
        unset($_SESSION[$column]);
    }
}

if (!isset($_SESSION['deck'])) {
    require_once __DIR__ . '/createDeck.php';
}

$deck = $_SESSION['deck'];
$discardPile = $_SESSION['discardPile'];

if (!empty($deck) && isset($_POST['newRound']) || isset($_POST['newGame'])) {
    $newRoundOfCards = array_splice($deck, 0, 4);
    foreach ($columnsMap as $key => $column) {
        $cardsOnBoardColumns[$column] = [...$_SESSION[$column], $newRoundOfCards[$key]];
        $_SESSION[$column] = $cardsOnBoardColumns[$column];
    }
    $_SESSION['deck'] = $deck;
} else if (isset($_POST['selectedCard'])) {
    cardActions();
} else {
    foreach ($columnsMap as $column) {
        $cardsOnBoardColumns[$column] = $_SESSION[$column];
    }
}

?>

<form method="post" class="aces-up-container">
    <section class="game-board-container">
        <?php foreach ($cardsOnBoardColumns as $index => $column) : ?>
            <div class="card-column">
                <?php if (count($column) === 0) : ?>
                    <div class="card-size empty-card-container"></div>
                <?php endif; ?>
                <?php foreach ($column as $key => $card) :
                    if (count($column) === $key + 1) : ?>
                        <button type="submit" name="selectedCard" value="<?= $index ?>" class="card card-size <?= ($card['suit'] == '♥' || $card['suit'] == '♦') ? 'red-card' : ''; ?>" style="top: <?= $key * 40 ?>px;">
                            <h3><?= $card['rank'] ?></h3>
                            <h3><?= $card['suit'] ?></h3>
                            <h3><?= $card['rank'] ?></h3>
                        </button>
                    <?php else : ?>
                        <div class="card card-size <?= ($card['suit'] == '♥' || $card['suit'] == '♦') ? 'red-card' : ''; ?>" style="top: <?= $key * 40 ?>px;">
                            <h3><?= $card['rank'] ?></h3>
                            <h3><?= $card['suit'] ?></h3>
                            <h3><?= $card['rank'] ?></h3>
                        </div>
                <?php endif;
                endforeach; ?>
            </div>
        <?php endforeach; ?>
    </section>
    <section class="aces-game-controls">
        <button type="submit" name="newRound" class="round-btn card-size">
            <?php if (count($deck) / 4 <= 5) : ?>
                <div class="count-down-container"><?= (count($deck) / 4); ?></div>
            <?php endif; ?>
            <img src="/images/Card_back_01.svg" alt="button of card">
        </button>
        <div class="empty-card-container discard card-size <?= (!empty($discardPile) && ($discardPile['suit'] == '♥' || $discardPile['suit'] == '♦')) ? 'red-card' : ''; ?> <?= (!empty($discardPile)) ? 'card' : ''; ?>">
            <?php if (!empty($discardPile)) : ?>
                <h3><?= $discardPile['rank'] ?></h3>
                <h3><?= $discardPile['suit'] ?></h3>
                <h3><?= $discardPile['rank'] ?></h3>
            <?php endif; ?>
        </div>
        <button class="new-game empty-card-container" type="submit" name="newGame">New game</button>
    </section>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>