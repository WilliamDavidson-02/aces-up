<h3><?= $card['rank'] ?></h3>
<?php
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
} ?>
<div class="suit-container <?= $rankGrid ?>">
    <?php for ($i = 0; $i < $rankValue; $i++) : ?>
        <h3><?= $card['suit'] ?></h3>
    <?php endfor; ?>
</div>
<h3 class="last-rank"><?= $card['rank'] ?></h3>