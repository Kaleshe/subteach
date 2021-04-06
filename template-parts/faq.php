<?php
/**
 * Template part for displaying faq question & answers
 * 
 * @package Subteach
 */

global $wpdb;

$faq = json_decode( json_encode( $wpdb->get_results( "SELECT * FROM questions" ) ), true);

$email = $wpdb->get_var( $wpdb->prepare( "SELECT email FROM meta WHERE ID = %d", 1 ) );

$phone = $wpdb->get_var( $wpdb->prepare( "SELECT telephone FROM meta WHERE ID = %d", 1 ) );

?>

<div class="faq">
  <?php foreach ( $faq as $qa ) { ?>
  <article class="accordion card mb-space-half p-space is-closed w-max-md mx-auto">
   <div class="question font-bold flex space-between">
      <p><?= $qa['question']; ?></p>
      <button></button>
    </div>
    <div class="answer">
      <p><?= $qa['answer']; ?></p>
    </div>
  </article>
  <?php } ?>
</div>

<div class="contact-information md:flex space-evenly mt-space-2 max-w-sm mx-auto">
    <p class="mb-space-half">Email: <a href="mailto:<?= $email; ?>"><?= $email; ?></a></p>
    <p class="mb-space-half">Telephone: <a href="tel:<?= $phone; ?>"><?= $phone; ?></a></p>
</div>

