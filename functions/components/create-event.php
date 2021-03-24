<?php

function create_event() {
    return'
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
            <form action="" class="create-event-form">
                <label for="subject">Subject</label>
                <input type="text" placeholder="Subject" class="w-full">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" required>
                <label for="time">Time</label>
                <input type="time" id="time" name="time" required>
                <label for="note">Note</label>
                <textarea name="note" id="note" cols="20" rows="5"></textarea>
                
            </form>
        </main>
        <footer class="modal__footer">
            <input type="submit" value="Create Event">
          <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Cancel</button>
        </footer>
      </div>
    </div>
  </div>

    ';
}