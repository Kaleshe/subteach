<?php

function card( $text, $value ) {  
    return '
    <div class="card">
        <div class="cardValue">
            ' . $value . '
        </div>
        <p class="cardText">' . $text .'</p>
    </div>
    ';
}

?>