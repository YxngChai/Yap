<?php

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../helpers/errors.php';
require_once __DIR__ . '/../validators/validator.php';

$pdo = Database::getConnection();

verifyCsrf();

switch ($_POST['action']) {
  case "upload_image":
    $imageType = $_POST['image_type'] ?? NULL;
    if (!in_array($imageType, ['profile_image', 'cover_image', 'post_image'], true)) {
    jsonError(['Invalid image type']);
    exit;
    }

    if (!isset($_FILES['file'])) {
        $errors[] = 'No file uploaded';
        jsonError($errors);
        exit;
    }

    $result = Validator::validateImage(($_FILES['file']));

    if(!$result['success']) {
        jsonError($result['errors']);
        exit;
    }
    $extension = $result['extension'];
    $tmp= $_FILES['file']['tmp_name'];
    
    

    // save the file
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        
    $path =  __DIR__ .'/../../public/assets/uploads/'.$filename;
        if (!move_uploaded_file($tmp,$path)) {
            $errors[] = 'Failed to save the image';
            jsonError($errors);
            exit;
        }



    // might implement more specific dimensions rules depending of image type
    switch ($imageType) {
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

            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'errors' => 'It Works'
            ]);
            exit;
        default: 
            if(is_file($path)) {
                    unlink($path);
                }
            jsonError(['Invalid image type']);
            exit;
        
    }

    // for profile picture:
     // get image name from DB


    case "delete_image":
        exit;
}