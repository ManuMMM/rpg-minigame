<?php ob_start(); ?>

    <p><a href="?logout=1">Log out</a></p>
    
    <fieldset>
        <legend>My informations</legend>
        <p>
            Name : <?= htmlspecialchars($perso->getName()) ?><br />
            Damages : <?= $perso->getDamages() ?>
        </p>
    </fieldset>
    
    <?php
    if(isset($message)){
    ?>
        <fieldset>
        <legend>Message</legend>
        <p>
            <?= htmlspecialchars($message) ?>
        </p>
        </fieldset>
    <?php
    }
    ?>
    
    <fieldset>
        <legend>Attack someone</legend>
        <p>
            <?php
            $persos = $manager->getListOfOthersCharacters($perso->getName());

            if (empty($persos)) {
                echo 'No one to hit';
            }
            else{
                foreach ($persos as $onePerso){
                    echo '<a href="?hit=', $onePerso->getId(), '">', htmlspecialchars($onePerso->getName()), '</a> (dégâts : ', $onePerso->getDamages(), ')<br />';
                }
            }
            ?>
        </p>
    </fieldset>
 
<?php $content = ob_get_clean(); ?>
  
<?php require('template.php'); ?>


