<?php
// Load the Autolader (which willmanage to load the required class when needed)
// require_once() statement is identical to require()
// except PHP will check if the file has already been
// included, and if so, not include (require) it again.
require_once 'Autoloader.php';
Autoloader::register();

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
        createCharacter(['name' => $_POST['name']]);
    }
    elseif (isset($_POST['use']) && isset($_POST['name'])) {
        useCharacter($_POST['name']);
    }
    elseif (isset($_GET['hit'])) {
        if (!isset($perso)){
            $message = 'Please log in or create a new character in order to perform this action ';
            echo $message . '<br><br> You\'ll be redirected in 5 sec';
            ?>
            <script>
                var time = 5;
                function tick(){
                    document.getElementById('body').insertAdjacentHTML(afterbegin, 'You\'ll be redirected in ' + time + 'seconde(s)');
                    time--;
                    if(sec == 0){
                        clearInterval(timer);
                    }
                }
                var timer = window.setInterval(tick, 1000);
            </script>
            <?php
            header( "Refresh:5; url=index.php", true, 303);
        }
        else{
            hitCharacter($_GET['hit'], $perso);
        }
    }
    else {
        displayForm();
    }    
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}


