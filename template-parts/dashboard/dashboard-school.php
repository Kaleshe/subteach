<?php
/**
 * Template part for displaying the school dashboard
 *
 * Displays the number of placements, last search, last booked profile
 * with meta data, links to a generated search with autofilled data from last search
 *
 * @package Subteach
 */


$user_id = get_current_user_id();
$coverImageID = get_user_meta($user_id)['cover_image'][0];
$coverImage = $coverImageID ? wp_get_attachment_image_src($coverImageID, 'full') : false;

$last_search = get_last_search($user_id, get_user_type_as_string());

$last_search_line_1 = 'N/A';
$last_search_line_2 = '';


$last_subject_id = '';
$last_subject = '';
$last_time = '';
$last_date = '';

if ($last_search !== null) {
  $last_subject_id = $last_search->subjectID;
  $last_subject = $last_search->subjectLiteral;
  $last_time = "$last_search->hour:$last_search->minute";
  $last_date = "$last_search->date";

  $last_search_line_1 = "$last_subject @ $last_time";
  $last_search_line_2 = $last_date;
}

?>

<?php if ($coverImage) { ?>
    <div class="cover-image"
         style="height: 37vmin; width: 100%; background: url(<?= $coverImage[0]; ?>); background-position-y: 60%; background-size: cover;">

    </div>
<?php } ?>
<script type="text/javascript">
  function setSubject(subjectID) {
    const subjects = document.getElementById("subjects");
    for (let i = 0; i < subjects.childElementCount; ++i) {
      const child = subjects.children[i];
      const id = child.getAttribute("data-subject-id");
      if (id === subjectID) {
        document.getElementById("subjectsList").value = child.value;
        document.getElementById("subjectID").value = subjectID;
        // alert(`Setting subject to ${child.value}`);
        return;
      }
    }
    // alert("Failed to find a match!");
  }

  function onDuplicateClicked() {
    MicroModal.show('event-modal');
    const lastSubjectID = "<?= $last_subject_id?>";
    setSubject(lastSubjectID);
    document.getElementById("date").value = "<?= $last_date ?>";
    document.getElementById("time").value = "<?= $last_time ?>";
  }

  window.addEventListener('load', () => {
    document.getElementById('duplicate-button').addEventListener('click', onDuplicateClicked);
  });
</script>
<div class="school-dashboard">
    <div class="school-dashboard-cards coloured-bg py-space-2 px-space">
        <div class="container">
            <div class="cards grid md:cols-3 gap-space">
              <?php
              echo dataCard(esc_html('Number of Placements'), 0);
              ?>
                <div class="card p-space text-center flex justify-center items-center">
                    <div>
                        <div>
                            <p class="text-md font-bold mb"><?= esc_html('Last Search'); ?></p>
                            <p class="text-xs"><?= esc_html("$last_search_line_1"); ?></p>
                            <p class="text-xs"><?= esc_html("$last_search_line_2"); ?></p>
                        </div>
                        <button class="mt-space-half" id="duplicate-button"
                                href=""><?= esc_html('Duplicate'); ?></button>
                    </div>
                </div>
              <?php
              echo profileCard('Last booked profile', 'teacher', 2);
              ?>
            </div>
        </div>
    </div>

    <div class="px-space">
        <div class="container">
            <h2 class="mt-space"><?= esc_html('Liked Profiles'); ?></h2>
          <?php

          if (liked_profiles()) {
            $profiles = liked_profiles(); ?>
              <div class="liked-profiles mt-space grid gap-space-half">
                <?php

                foreach ($profiles as $profile) {
                  echo profileCard('View Profile', $profile, 'teacher', 'inline-flex flex-col');
                }

                ?>
              </div>
          <?php } else { ?>
              <p class="mt"><?php _e('You haven\'t liked any profiles'); ?></p>
          <?php }

          ?>
        </div>
    </div>
</div>