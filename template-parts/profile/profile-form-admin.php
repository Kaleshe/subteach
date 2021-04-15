<?php

use Library\Lisp;
use Subteach\FormBuilder;
use Subteach\InputBuilder;
use Subteach\TableSettings;
use Subteach\UpdateQueryBuilder;
use Subteach\ViewQueryBuilder;

/**
 * Template part for displaying the school profile form
 *
 * @package Subteach
 */

function getColumnTypes($columnInfo)
{
    $columnTypes = [];
    foreach (array_keys($columnInfo) as $column) {
        $columnTypes[$column] = $columnInfo[$column]['type'];
    }
    return $columnTypes;
}

function showSchoolProfile(Lisp $settings, $search_id = null)
{
    global $wpdb;
    $table = $settings->getLiteralAt(1);
    $title = $settings->getStringAt(3);
    $managed_settings = new TableSettings($settings);
    $column_info = $managed_settings->getColumnInfo();
    $columns_with_type = $managed_settings->getColumnTypeMap();
    $input_types = $managed_settings->getInputTypeMap();
    $props = [];
    $bindings = [];
    $query_builder = new ViewQueryBuilder($table, $columns_with_type, $props, $bindings);
    $results = null;
    if ($search_id === null) {
        $query = $query_builder->buildWpdb();
        $results = $wpdb->get_results($query, ARRAY_A);
    } else {

        $query = $query_builder->buildWpdb('id');
        $results = $wpdb->get_results($wpdb->prepare($query, $search_id), ARRAY_A);
    }

    $inputs = [];

    foreach ($results as $row) {
        $id = $row['id'];
        $input_group = [];
        foreach (array_keys($row) as $column) {
            $row_id = $id;
            $info = $column_info[$column];
            $name = $column;
            $type = $input_types[$column];
            $value = $row[$column];
            $label = isset($info[':label']) ? $info[':label'] : $name;

            $input_group [] = new InputBuilder($name, $type, $value, $label, $row_id);
        }
        $inputs [] = join("\n", $input_group);
    }
    echo new FormBuilder($title, "update,$table", 'Update', '', [join("<br>\n", $inputs)]);
}

function get_update_type($post)
{
    foreach (array_keys($post) as $post_key) {
        $split_post = preg_split('/,/', $post_key);
        if (count($split_post) === 2 && $split_post[0] === 'update') {
            return $split_post[1];

        }
    }
    return null;
}

function interpret_post($post)
{
    $update_table = get_update_type($post);
    if ($update_table === null) {
        return '<h1>No update table</h1>';
    }

    $all_settings = [TableSettings::adminProfile(), TableSettings::priceLevels(),
        TableSettings::distanceTitles(), TableSettings::questions()];

    $all_settings = array_map(function ($settings) {
        return new TableSettings($settings);
    }, $all_settings);

    /** @var TableSettings $settings */
    $settings = (function ($settings, $table) {
        foreach ($settings as $setting) {
            if ($setting->getTable() === $table) {
                return $setting;
            }
        }
        return null;
    })($all_settings, $update_table);

    if ($settings === null) {
        return '<h1>No matching settings</h1>';
    }

    $update_rows = (function ($post) {
        $rows = [];
        foreach (array_keys($post) as $full_key) {
            if (preg_match('/^__update__,/', $full_key) === 1) {
                $filtered_entry = preg_replace('/^__update__,/', '', $full_key);
                [$id, $column] = preg_split('/,/', $filtered_entry);

                if (!key_exists($id, $rows)) {
                    $rows[$id] = [];
                }

                $rows[$id][$column] = $post[$full_key];
            }
        }
        return $rows;
    })($post);


    $update_columns = $settings->getUpdateColumns();


    foreach ($update_rows as $row) {
        $update_query_builder = new UpdateQueryBuilder($settings->getTable(), $settings->getColumnTypeMap(), [], []);
        $values = array_map(function ($each) use ($row) {
            return $row[$each];
        }, $update_columns);
        $values [] = $row['id'];
        $query = $update_query_builder->buildWpdb($update_columns, 'id');
        global $wpdb;
        $wpdb->query($wpdb->prepare($query, $values));
    }
    return '';

}

interpret_post($_POST);

showSchoolProfile(TableSettings::adminProfile(), 1);
echo '<br>';
showSchoolProfile(TableSettings::priceLevels());
echo '<br>';
showSchoolProfile(TableSettings::distanceTitles());
echo '<br>';
showSchoolProfile(TableSettings::questions());