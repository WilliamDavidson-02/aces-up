<?php
require_once __DIR__ . '/header.php';
require __DIR__ . '/createDeck.php';

session_start();
$cardsOnBoardColumns = [
    'firstColumn' => [],
    'secondColumn' => [],
    'thirdColumn' => [],
    'fourthColumn' => [],
]
?>

<main class="aces-up-container">
    <section class="game-board-container">
        <?php foreach ($cardsOnBoardColumns as $column) : ?>
            <div>This is a column</div>
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