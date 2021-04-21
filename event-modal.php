<?php
/**
 * Event Modal
 *
 * @package Subteach
 */

$subjects = get_subjects();

if ( isset($_POST['submit_event'] ) ) {
  create_event();
}
?>

<div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
      <header class="modal__header">
        <h2 class="modal__title text-lg" id="modal-1-title">
          Create Event
        </h2>
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="modal-1-content">
      <div id="modal-1-content">
          <form action="" class="create-event-form" method="post" action="<?php $_PHP_SELF; ?>">
              <label for="subject">Subject</label>
              <input id="subjectsList" list="subjects" placeholder="Subject" class="w-full" name="subject">
              <datalist id="subjects">
                <?php foreach ( $subjects as $subject ) {
                  echo '<option data-subject-id="'. $subject['ID'] .'" value="' . $subject['title'] . ' - ' . get_subject_level_title( $subject['levelID'] ) . '" />';
                }
                ?>
              </datalist>
              <input type="text" name="subjectID" hidden>
              <label for="date">Date</label>
              <input type="date" name="date" id="date" required>
              <label for="time">Time</label>
              <input type="time" id="time" name="time" required>
              <label for="note">Note</label>
              <textarea name="note" id="note" cols="20" rows="5"></textarea>
              <footer class="modal__footer">
                <input type="submit" name="submit_event" value="Create Event">
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Cancel</button>
            </footer>
          </form>
      </main>

    </div>
  </div>
</div>