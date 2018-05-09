<?php
// Load the Autolader (which willmanage to load the required class when needed)
// require_once() statement is identical to require()
// except PHP will check if the file has already been
// included, and if so, not include (require) it again.
require_once 'model/Autoloader.php';
Autoloader::register();

// Create a character
function createCharacter($name) {
    // Create a new character manager
    $manager = new CharacterManager();
    // Stock the number of existing characters
    $numberOfCharacters = $manager->count();
    // Create a new character
    $perso = new Character($name);
    // Check if the name is not empty and if the name is not already used in the database
    if(!$perso->valideName()){
        // Save a informative message
        $error = 'Name entered is invalid';
        // Destroy the $perso variable
        unset($perso);
        // Require the view
        require('view/frontend/formView.php');
    }
    elseif ($manager->exists($perso->getName())) {
        // Save a informative message
        $error = 'Name already existing';
        // Destroy the $perso variable
        unset($perso);
        // Require the view
        require('view/frontend/formView.php');
    }
    // If all good, add it in the database
    else {
        $manager->add($perso);
        // We save it in a variable session in order to save a SQL request
        if (isset($perso)){
            $_SESSION['perso'] = $perso;
        }
        // Require the view
        require('view/frontend/playView.php');
    }    
}

// Use an existing character
function useCharacter($name) {
    // Create a new characterManager
    $manager = new CharacterManager();
    // Stock the number of existing characters
    $numberOfCharacters = $manager->count();
    // Check if the character exist
    // If it exists, get it from the database
    if($manager->exists($name)){
        $perso = $manager->getCharacter($name);
        // We save it in a variable session in order to save a SQL request
        if (isset($perso)){
            $_SESSION['perso'] = $perso;
            echo 'Session[\'perso\'] bien sauvegardée';
        }
        // Require the view
        require('view/frontend/playView.php');
    }
    // Else tell the user that this character doesn't exist
    else {
        $error = 'The character doesn\'t exist';
        // Require the view
        require('view/frontend/formView.php');
    }
}

//Hit a character
function hitCharacter($id) {
    // Create a new characterManager
    $manager = new CharacterManager();
    // Restore the $perso of the session
    $perso = $_SESSION['perso'];
    
    if (!$manager->exists((int) $id)){
        $message = 'The character you want to hit doesn\'t exist !';
    }
    else{
        // Fetch the character to be hit
        $persoToHit = $manager->getCharacter((int) $id);
        // Hit the targeted character
        $feedback = $perso->hit($persoToHit);
        // We get the matching output
        switch ($feedback){            
            case Character::THATS_ME :
                $message = 'Wait a min... why do you want to it yourself ???';
                break;

            case Character::CHARACTER_HIT :
                $message = 'The character was well hit !';
                // Updating the characters in the database
                $manager->update($perso);
                $manager->update($persoToHit);
                break;

            case Character::CHARACTER_DEAD :
                $message = 'You killed this character !';
                // Updating the characters in the database
                $manager->update($perso);
                $manager->delete($persoToHit);
                break;
        }
    }
    // Stock the number of existing characters (After the hit function if someone is dead)
    $numberOfCharacters = $manager->count();
    // Require the view
    require('view/frontend/playView.php');
}

// Display the form
function displayForm() {
    // Create a new characterManager
    $manager = new CharacterManager();
    // Stock the number of existing characters
    $numberOfCharacters = $manager->count();
    require './view/frontend/formView.php';
}




