<?php
session_start();

require_once __DIR__ . '/header.php';
require __DIR__ . '/createDeck.php';

$newRoundOfCards = array_splice($deck, 0, 4);

$cardsOnBoardColumns = [
    'firstColumn' => [...$_SESSION['firstColumn'], $newRoundOfCards[0]],
    'secondColumn' => [...$_SESSION['secondColumn'], $newRoundOfCards[1]],
    'thirdColumn' => [...$_SESSION['thirdColumn'], $newRoundOfCards[2]],
    'fourthColumn' => [...$_SESSION['fourthColumn'], $newRoundOfCards[3]],
];
?>

<main class="aces-up-container">
    <section class="game-board-container">
        <?php foreach ($cardsOnBoardColumns as $column) : ?>
            <div class="card-column">
                <?php foreach ($column as $key => $card) : ?>
                    <div class="card card-size" style="top: <?= $key * 20 ?>;">
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
            <img src="/images/Card_back_01.svg" alt="button of card">
        </button>
        <div class="empty-card-container card-size"></div>
        <a class="new-game empty-card-container" href="/acesUp.php">New game</a>
    </form>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>