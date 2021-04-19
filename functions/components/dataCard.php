<?php

function dataCard($text, $data)
{
    ob_start();
    ?>

    <div class="card text-center py-space-2">
        <div class="cardData">
            <?= $data; ?>
        </div>
        <p class="cardText"><?= $text; ?></p>
    </div>

    <?php
    return ob_get_clean();
}
