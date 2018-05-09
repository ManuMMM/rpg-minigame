<?php

// Load the frontend.php
// require_once() statement is identical to require()
// except PHP will check if the file has already been
// included, and if so, not include (require) it again.
require_once('controller/frontend.php');

session_start(); // We call session_start() after the require

if (isset($_GET['logout']))
{
  session_destroy();
  header('Location: .');
  exit();
}

// If the session exist, we restore the object
if (isset($_SESSION['perso'])){
    $perso = $_SESSION['perso'];
}

try {
    if(isset($_POST['create']) && isset($_POST['name'])){
        echo 'test';
        createCharacter(['name' => $_POST['name']]);
    }
    elseif (isset($_POST['use']) && isset($_POST['name'])) {
        echo 'test2';
        useCharacter($_POST['name']);
    }
    elseif (isset($_GET['hit'])) {
        echo 'test3';
        if (!isset($perso)){
            $message = 'Please log in in orderor create a new character to perform this action ';
            echo 'test4';
        }
        else{
            echo 'test5' . $perso->getName();
            hitCharacter($_GET['hit']);
        }
    }
    else {
        displayForm();
    }    
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}


