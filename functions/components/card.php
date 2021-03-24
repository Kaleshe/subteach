<?php

function card( $text, $value ) {  
    return '
    <div class="card text-center py-space">
        <div class="cardValue">
            ' . $value . '
        </div>
        <p class="cardText">' . $text .'</p>
    </div>
    ';
}

?>