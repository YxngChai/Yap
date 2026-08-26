<?php


switch ($_POST['action']) {
  case "upload_image":
    if (!isset($_FILES['file'])) {
        die('No file uploaded');
    }

    $tmp = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];

    if ($error !== UPLOAD_ERR_OK) {
            die('File upload failed');
    }
    if (!is_uploaded_file($tmp)) {
        die('Invalid upload');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);

    $mime =  $finfo->file($tmp);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if(!isset($allowed[$mime])) {
        die('Invalid file format');
    } 
    
    $maxSize = 5 * 1024 * 1024;
    if($size > $maxSize) {
        die('File too large, 5MB maximum');
    }
    // might implement dimensions rules depending of image type
    // switch ($_POST['image_type']) {
    //     case "post_image":
    //     case "profile_image":
    //     case "cover_image":
    //       break;
    // }
    $imageDimensions = getimagesize($tmp);

    if (!$imageDimensions) {
        die('Invalid image');
    }
    [$width, $height] = $imageDimensions;
    
    if($width > 6000 || $height > 6000) {
        die('Dimensions are too large');
    }
    if($width < 300 || $height < 300) {
        die('Dimensions are too small');
    }


    $extension = $allowed[$mime];

    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    
    $path =  __DIR__ .'/../../public/assets/uploads/'.$filename;
    if (!move_uploaded_file($tmp,$path)) {
        die ('Failed to save image');
    }

    // add file name to DB
    redirectBack();
    exit;

    case "delete_image":
        exit;

}