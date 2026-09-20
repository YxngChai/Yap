<?php

class Validator {

    public static function validateUser(array $data ,array $rules) {
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
        if (!empty($ruleSet['username'])) {
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
                $errors[] = "$field contains invalid characters";
            }
        }
        if (!empty($ruleSet['name'])) {
            if (!preg_match("/^[\p{L}' -]+$/u", $value)) {
                $errors[] = "$field contains invalid characters";
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
    public static function validatePost(array $data ,array $rules) {
        $errors = [];
        foreach($rules as $field => $ruleSet) {

        $value = trim((string)($data[$field] ?? ''));

        if (isset($ruleSet['min'])){
            if (strlen(trim($value)) < $ruleSet['min']) {
                $errors[] = "Must be at least {$ruleSet['min']} characters!";
            }
        }
        if (isset($ruleSet['max'])){
            if (strlen(trim($value)) > $ruleSet['max']) {
                $errors[] = "Cannot exceed {$ruleSet['max']} characters!";
            }
        }
        }
        return $errors;

    }

    public static function validateImage(array $file): array {
        $tmp = $file['tmp_name'];
        $size = $file['size'];
        $error = $file['error'];

        $errors = [];

        if ($error !== UPLOAD_ERR_OK) {
                $errors[] = 'File upload failed';
                return ['success' => false, 'errors' => $errors];
                
        }
        if (!is_uploaded_file($tmp)) {
            $errors[] = 'Invalid upload';
            return ['success' => false, 'errors' => $errors];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $mime =  $finfo->file($tmp);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if(!isset($allowed[$mime])) {
            $errors[] = 'Invalid file format';
            return ['success' => false, 'errors' => $errors];
        } 
        
        $maxSize = 5 * 1024 * 1024;
        if($size > $maxSize) {
            $errors[] = 'File too large, 5MB maximum.';
        }

        $imageDimensions = getimagesize($tmp);

        if (!$imageDimensions) {
            $errors[] = 'Invalid image';
            return ['success' => false, 'errors' => $errors];
        }
        [$width, $height] = $imageDimensions;
        
        if($width > 6000 || $height > 6000) {
            $errors[] = 'Dimensions are too large.';
        }
        if($width < 300 || $height < 300) {
            $errors[] = 'Dimensions are too small.';
        }
        if(!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $extension = $allowed[$mime];


        return ['success' => true, 'extension' => $extension];
    }
}