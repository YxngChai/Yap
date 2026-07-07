<?php

class Validator {

    public static function validate(array $data ,array $rules) {
        $errors = [];

        foreach($rules as $field => $ruleSet) {

        $value = trim((string)($data[$field] ?? ''));

        //check fields not empty
        if (!empty($ruleSet['required']) && empty($value) && $value !== '0') {
            $errors[] = "$field is required";
            continue;
        }

        //check valid email not empty
        if(!empty($ruleSet['email']) && !filter_var($value, FILTER_VALIDATE_EMAIL)){
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
        if(!empty($ruleSet['date'])) {
            $date = DateTime::createFromFormat('Y-m-d', $value);

            if(!$date || $date->format('Y-m-d') !== $value) {
                $errors[] = "$field must be a valid date";
            } else {
                $oldestAllowed = new DateTime('today');
                $oldestAllowed->modify('-120 years');
                if ($date < $oldestAllowed) {
                    $errors[] = "$field is too old";
                }
                $youngestAllowed = new DateTime('today');
                $youngestAllowed->modify('-16 years');
                if ($date > $youngestAllowed) {
                    $errors[] = "You must be at least 16 years old";
                }
                if ($date > new DateTime('today')) {
                    $errors[] = "$field cannot be in the future";
                }

            }
        }

        }
        return $errors;
    }
}