<?php


namespace Subteach;


class FormBuilder
{
    private $title, $form_id, $submit_value, $action, $inputs;

    public function __construct($title, $form_id, $submit_value, $action, $inputs = null)
    {
        $this->title = $title;
        $this->form_id = $form_id;
        $this->submit_value = $submit_value;
        $this->action = $action;
        $this->inputs = $inputs;
    }

    public function __toString()
    {
        ob_start();
        ?>
        <div class="school-form | card px-space py-space w-max-theme mx-auto">
            <form class="grid gap-space-half" method="post" action="<?= $this->action; ?>">
                <h2 class="mb-space-half"><?= $this->title ?></h2>

                <?= $this->renderInputs() ?>

                <input class="justify-self-start" type="submit" value="<?= $this->submit_value ?>"
                       name="<?= $this->form_id ?>"
                       id="<?= $this->form_id ?>">

            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    private function renderInputs()
    {
        if($this->inputs === null)
        {
            return '';
        }
        return join("\n", $this->inputs);
    }

}