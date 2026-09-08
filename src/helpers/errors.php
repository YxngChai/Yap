<?php

function jsonError($errors){
    header('Content-Type: application/json');
    echo json_encode([
    'success' => false,
    'errors' => $errors
    ]);
}