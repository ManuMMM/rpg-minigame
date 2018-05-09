<?php

/*
 * Description of Autoloader
 *
 * @author Manu
 */

class Autoloader {
    /*
     * Register our autoloader
     * array(__CLASS__, 'autoload') correspond to array('name of the class', 'the function called in this class')
     * __CLASS__: Name of the current class
     */
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    /*
     * Include the file coreesponding to our class
     * @param $class (string): Name of the class to load
     */
    public static function autoload($class){
        require 'model/'. $class .'.php';
    }
}
