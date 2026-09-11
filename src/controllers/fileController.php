<?php

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../helpers/errors.php';

$pdo = Database::getConnection();

verifyCsrf();

switch ($_POST['action']) {
  case "upload_image":

    if (!isset($_FILES['file'])) {
        die('No file uploaded');
    }

    $tmp = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];

    $errors = [];

    if ($error !== UPLOAD_ERR_OK) {
            $errors[] = 'File upload failed';
            jsonError($errors);
            exit;
            
    }
    if (!is_uploaded_file($tmp)) {
        $errors[] = 'Invalid upload';
        jsonError($errors);
        exit;
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
        jsonError($errors);
        exit;
    } 
    
    $maxSize = 5 * 1024 * 1024;
    if($size > $maxSize) {
        $errors[] = 'File too large, 5MB maximum.';
    }

    $imageDimensions = getimagesize($tmp);

    if (!$imageDimensions) {
        $errors[] = 'Invalid image';
    }
    [$width, $height] = $imageDimensions;
    
    if($width > 6000 || $height > 6000) {
        $errors[] = 'Dimensions are too large.';
    }
    if($width < 300 || $height < 300) {
        $errors[] = 'Dimensions are too small.';
    }
    if(!empty($errors)) {
        jsonError($errors);
        exit;
    }

    $extension = $allowed[$mime];

    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    
    $path =  __DIR__ .'/../../public/assets/uploads/'.$filename;
    if (!move_uploaded_file($tmp,$path)) {
        $errors[] = 'Failed to save the image';
        jsonError($errors);
        exit;
    }

    // - need to verify image_type input from the form
    // - check what is the image is for

    // might implement more specific dimensions rules depending of image type
    switch ($_POST['image_type']) {
        case "profile_image":
            $photoFileName = User::getProfilePicture($pdo, $_SESSION['user']['id']);

            if($photoFileName){
                $pathPhoto = __DIR__ . '/../../public/assets/uploads/' . $photoFileName['profile_picture'];

                if(is_file($pathPhoto)) {
                    unlink($pathPhoto);
                }
            }
            User::addProfilePicture($pdo, $filename, $_SESSION['user']['id']);
            $_SESSION['user']['profile_picture'] = $filename;

            header('Content-Type: application/json');
            echo json_encode([
            'success' => true,
            'errors' => NULL
            ]);
            exit;

        case "cover_image":
            $coverFileName = User::getCoverImage($pdo, $_SESSION['user']['id']);

            if($coverFileName){
                $pathImage = __DIR__ . '/../../public/assets/uploads/' . $coverFileName['cover_picture'];

                if(is_file($pathImage)) {
                    unlink($pathImage);
                }
            }
            User::addCoverimage($pdo, $filename, $_SESSION['user']['id']);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'errors' => NULL
            ]);
            exit;

        case "post_image":
          break;
    }

    // for profile picture:
     // get image name from DB


    case "delete_image":
        exit;
}