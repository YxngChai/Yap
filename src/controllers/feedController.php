<?php


require_once __DIR__ . '/../models/post.php';

$pdo = Database::getConnection();


$posts = Post::findAll($pdo);



require __DIR__ . "/../../views/feed.php";