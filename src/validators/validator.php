<?php

class Validator {

    public static function validate($data, $rules) {
        $errors = [];

        foreach($rules as $field => $ruleSet) {

        $value = $data[$field] ?? null;

        //check fields not empty
        if (!empty($ruleSet['required']) && empty($value) && $value !== '0') {
            $errors[] = "$field is required";
            continue;
        }

        //check valid email not empty
        if(!empty($ruleSet['mail']) && !filter_var($value, FILTER_VALIDATE_EMAIL)){
            $errors[] = "$field must be valid email";
        }

        //check correct length
        if (isset($ruleSet['min'])){
            if (strlen(trim($value)) < $ruleSet['min']) {
                $errors[] = "$field must be at least {$ruleSet['min']} characters";
            }
        }
        if (isset($ruleSet['max'])){
            if (strlen(trim($value)) > $ruleSet['max']) {
                $errors[] = "$field must be at most {$ruleSet['max']} characters";
            }
        }

        }
        return $errors;
    }
}