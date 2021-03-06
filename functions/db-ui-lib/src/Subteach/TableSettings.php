<?php


namespace Subteach;


use Library\Lisp;
use Library\LispReader;

class TableSettings
{
    /**
     * @var Lisp
     */
    private $settings;

    public function __construct(Lisp $settings)
    {
        $this->settings = $settings;
    }

    public function getTable(): string
    {
        return $this->settings->getStringAt(1);
    }

    public function getColumnTypeMap()
    {
        $column_info = $this->getColumnInfo();
        $column_types = [];
        foreach (array_keys($column_info) as $column) {
            $column_types[$column] = $column_info[$column]['type'];
        }
        return $column_types;
    }

    public function getInputTypeMap()
    {
        $column_info = $this->getColumnInfo();
        $input_types = [];
        foreach(array_keys($column_info) as $column) {
            $current_column_info = $column_info[$column];
            $current_column_type = 'string';
            if(key_exists(':type', $current_column_info)) {
                $current_column_type = $current_column_info[':type'];
            }
            $input_types[$column] = $current_column_type;
        }
        return $input_types;
    }

    public function getColumnInfo()
    {
        /** @var Lisp $fields */
        $fields = $this->settings->get(4)->asLisp()->getRest();
        $columnInfo = [];
        for ($ptr = $fields; !$ptr->isNil(); $ptr = $ptr->getRest()) {
            /** @var Lisp $field */
            $field = $ptr->getFirstLisp();
            $info = [];
            $info['type'] = $field->getFirstLiteral();

            for ($each_param = $field->nth(2); !$each_param->isNil(); $each_param = $each_param->nth(2)) {
                $key = $each_param->getFirstLiteral();
                $value = $each_param->getStringAt(1);
                $info[$key] = $value;
            }

            $column = $field->getStringAt(1);
            $columnInfo[$column] = $info;
        }
        return $columnInfo;

    }

    public function getViewQuery(): Lisp
    {
        return $this->settings->getLispNamed('view-query')->getRest();
    }

    public function __toString(): string
    {
        return strval($this->settings);
    }

    public function getTitle(): string
    {
        if ($this->settings->getLiteralAt(2) === ':title') {
            return $this->settings->getStringAt(3);
        }
        return '';
    }


    public static function adminProfile(): Lisp
    {
        return LispReader::from(<<<EOF
            (table-admin "meta" :title "Contact Information"
                (fields
                    (int "id" :id () :type "hidden")
                    (string "telephone" :label "Telephone" :type "tel")
                    (string "email" :label "Email" :type "email")
                    (string "city" :label "City" :type "text")
                    (string "postcode" :label "Postcode" :type "text")
                    (string "street_address" :label "Street Address" :type "text")
                    )
                (view-query
                    :columns ("id" "telephone" "email" "city" "postcode" "street_address")
                    :where "id"
                    )
                (update-query
                    :set ("telephone" "email" "city" "postcode" "street_address")
                    :where "id"
                    )
                )
EOF
        );
    }

    public static function priceLevels(): Lisp
    {
        return LispReader::from(<<<EOF
            (table-admin "price_levels" :title "Price Levels"
                (fields
                    (int "id" :id () :type "hidden")
                    (int "month" :label "Month" :type "number")
                    (string "teachers" :label "Teachers" :type "text" )
                    (int "annual" :label "Annual" :type "number")
                    (string "title" :label "Title" :type "text")
                    )
                (view-query
                    :columns ("id" "month" "annual" "title")
                    )
                (update-query
                    :set ("month" "annual")
                    :where "id"
                    )
                )
EOF
        );
    }

    public static function questions(): Lisp
    {
        return LispReader::from(<<<EOF
            (table-admin "questions" :title "Q&A"
                (fields
                    (int "id" :id () :type "hidden")
                    (int "typeID" :label "Type ID" :type "hidden")
                    (string "question" :label "Question" :type "text")
                    (string "answer" :label "Answer" :type "text")
                    )
                (view-query
                    :columns ("id" "typeID" "question" "answer")
                    )
                (update-query 
                    :set ("typeID" "question" "answer")
                    :where "id"
                )
EOF
        );
    }

    // (view-query :columns ("col1" "col2") :where "id")
    public static function distanceTitles(): Lisp
    {
        return LispReader::from(<<<EOF
            (table-admin "distances" :title "Distances"
                (fields
                    (int "id" :id () :type "hidden")
                    (string "title" :label "Title" :type "text")
                    )
                (view-query
                    :columns ("id" "title")
                    )
                (update-query
                    :set ("title")
                    :where "id"
                    
                )
EOF
        );
    }

    public function getUpdateColumns()
    {
        $update_query = $this->settings->getLispNamed('update-query')->getRest();
        $columns_lisp = $update_query->getValue(':set')->asLisp();
        $update_columns = [];
        for ($ptr = $columns_lisp; !$ptr->isNil(); $ptr = $ptr->getRest()) {
            $update_columns [] = $ptr->getStringAt(0);
        }
        return $update_columns;
    }
}