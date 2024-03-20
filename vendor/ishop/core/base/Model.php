<?php

namespace ishop\base;

use ishop\DB;

use RedBeanPHP\R;
use Valitron\Validator;

abstract class Model {
    public $attributes = [];
    public $errors = [];
    public $rules = [];

    public function __construct() {
        DB::instance();
    }

    public function load($data): void {
        foreach ($this->attributes as $key => $value) {
            if (isset($data[$key])) {
                $this->attributes[$key] = $data[$key];
            }
        }
    }

    public function save($table) {
        $tbl = R::dispense($table);
        foreach ($this->attributes as $key => $value) {
            $tbl->$key = $value;
        }

        return R::store($tbl);
    }

    public function update($table, $id) {
        $bean = R::load($table, $id);
        foreach ($this->attributes as $key => $value) {
            $bean->$key = $value;
        }

        return R::store($bean);
    }

    public function validate($data): bool {
        Validator::langDir(WWW . '/validator/lang');
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);
        if ($v->validate()) {
            return true;
        }
        $this->errors = $v->errors();
        return false;
    }

    public function getErrors() {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $key) {
                $errors .= '<li>' . $key . '</li>';
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }

    public function checkUnique($params, $table): bool {
        foreach ($params as $key => $value) {
            $entry = R::findOne("$table", "{$key} = ?", [$value]);
            if ($entry) {
                $this->errors["key.{$key}"][0] = "Поле {$key} должно быть уникальным";
                return false;
            }
        }
        return true;
    }
}