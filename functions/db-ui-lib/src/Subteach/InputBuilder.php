<?php


namespace Subteach;


class InputBuilder
{
    public function __construct($name, $type, $value, $label = null, $row_id = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->label = $label;
        $this->row_id = $row_id;
    }

    public function __toString()
    {
        return self::render($this->getName(), $this->type, $this->value, $this->label);
    }

    private function getName(): string
    {
        return self::getPrefixRowIdIfNotNull($this->row_id, $this->name);
    }

    private static function render($name, $input_type, $value, $label): string
    {
        // TODO: Make the label optional ...
//        $readonly = $name === 'id' ? 'readonly' : '';
        $readonly = '';
        ob_start();
        {
            ?>
            <div>
                <label for="<?= $name ?>"><?= $label ?></label>
                <input type="<?= $input_type ?>" <?=$readonly?> name="<?= $name ?>"
                       id="<?= $name ?>" value="<?= $value ?>">
            </div>
            <?php
        }
        return ob_get_clean();
    }

    private static function getPrefixRowIdIfNotNull($rowId, $nameOrId)
    {
        $prefix = $rowId === null ? '' : "__update__,$rowId,";
        return $prefix . $nameOrId;
    }
}