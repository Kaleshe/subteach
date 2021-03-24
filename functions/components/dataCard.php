<?php

function dataCard( $text, $data ) {  
    return '
    <div class="card text-center py-space-2">
        <div class="cardData">
            ' . $data . '
        </div>
        <p class="cardText">' . $text .'</p>
    </div>
    ';
}

?>