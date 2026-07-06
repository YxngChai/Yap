<?php


require_once __DIR__ . '/../models/post.php';

$pdo = Database::getConnection();


// if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

//     switch ($_POST['action'])  {
//         case 'create_post':
//             Post::create($pdo, [
//                 'content' => $_POST['post_content'],
//                 'image_path' => NULL,
//                 'user_id' => $_SESSION['user']['id'],
//             ]);
//             var_dump('/yap/public/profile/' . $_SESSION['user']['id']);
//             header('Location: /yap/public/profile/' . $_SESSION['user']['id']);
//             exit;
//             break; 
        // case 'delete_post':
        //     header('Location: /yap/public/');
        //     exit;
        // case 'remove picture':
        //     break;
        // case 'update_post':
        //     exit;
        
//     }
// }

$posts = Post::findUserPosts($pdo, $_SESSION['user']['id']);

require __DIR__ . "/../../views/profile.php";