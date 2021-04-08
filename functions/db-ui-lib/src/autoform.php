<?php

//function t_class($elems)
//{
//    return $elems;
//}
//
//function t_attr($elems)
//{
//    return $elems;
//}
//
//function t_get_prop($id)
//{
//    return ['PROPS', $id];
//}

function autofield($name, $type, $label, $value, $id_prefix = '')
{
    $id = $id_prefix . $name;

    ?>
    <div>
        <label for="<?= $id ?>"><?= $label ?></label>
        <!--suppress HtmlFormInputWithoutLabel -->
        <input type="<?= $type ?>" name="<?= $name ?>"
               id="<?= $id ?>" value="<?= $value ?>">
    </div>
    <?php
}

function autoform($form_id, $submit_value, $action, $title, $attributes)
{
    ?>
    <div class="school-form | card px-space py-space w-max-theme mx-auto">
        <form class="grid gap-space-half" method="post" action="<?= $action; ?>">
            <h2 class="mb-space-half"><?= $title ?></h2>

            <?php
            // TODO: Output each
            ?>

            <input class="justify-self-start" type="submit" value="<?= $submit_value ?>" name="<?= $form_id ?>"
                   id="<?= $form_id ?>">

        </form>
    </div>
    <?php
}