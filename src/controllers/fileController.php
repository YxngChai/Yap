<?php


switch ($_POST['action']) {
  case "upload_image":

    if(isset($_FILES['file'])) {
        $tmp = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $error = $_FILES['file']['error'];
        $type = $_FILES['file']['type'];

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

        $extension = $allowed[$mime];

        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        
        move_uploaded_file($tmp, __DIR__ .'/../../public/assets/uploads/'.$filename);
    }
    redirectBack();
    exit;

    case "delete_image":
        exit;

}