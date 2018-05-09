<?php ob_start(); ?>

<form action="" method="post">
    <p>
        Name of your character : <input type="text" name="name" maxlength="50" placeholder="<?php if(isset($error)){echo $error;} ?>" />
        <input type="submit" value="Create this character" name="create" />
        <input type="submit" value="Use this character" name="use" />
    </p>
</form>
 
<?php $content = ob_get_clean(); ?>
  
<?php require('template.php'); ?>

