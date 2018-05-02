<?php

/**
 * Description of Personnage
 * -----------------------------------------------------------------------------------------
 * Class that will allow to instance a Character Object with the following characteristics:
 *      - Unique ID
 *      - Name
 *      - Damages
 * and the following functionnalities:
 *      - Hit (an other personnage)
 *      - Receive damages
 * -----------------------------------------------------------------------------------------
 * @author Manu
 */
class Character {
    
    private $_id,
            $_name,
            $_damages;
    
    const THATS_ME = 1; // Constant return by the method "hit" if the character is attacking himself/herself
    const CHARACTER_DEAD = 2; // Constant return by the method "receiveDamages" if the character is dead
    const CHARACTER_HIT = 3; // Constant return by the method "receiveDamages" if the character has been hit

    // Constructor //
    
    public function __construct(array $data) {
        $this->hydrate($data);
    }
    
    // Function Hydratation //
    
    public function hydrate($data) {
        foreach ($data as $key => $value){
            // Define the name of the corresponding method
            $method = 'set' . ucfirst($key);
            // Check if a such method exist
            // method_exists(object, 'method name')
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
    
    // Functions reflecting the functionnalities of the character //
    
    public function hit(Character $perso) {
        // First of all, making sure that the character don't hit himself/herself
        // If that the case we stop all & we return a value which indicating it
        if($perso->getId() == $this->_id){
            return self::THATS_ME;
        }        
        
        // We indicate to the character hit that he will receive damages
        return $perso->receiveDamages();
    }

    public function receiveDamages() {        
        // We increase damages by 5
        $this->setDamages($this->getDamages() + 5);

        // If the damages goes over 100, it will return a value which means that the character is dead.
        if($this->getDamages() >= 100){
            return self::CHARACTER_DEAD;
        }
        
        // Otherwise we will just return a value stating that the character has been hit
        return self::CHARACTER_HIT;
    }
    
    // GETTERS //
    
    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->_name;
    }
    
    public function getDamages() {
        return $this->_damages;
    }

    // SETTERS //
    
    public function setId($id) {
        $id = (int) $id;
        if($id > 0){
            $this->_id = $id;
        }
    }
    
    public function setName($name) {
        if(is_string($name)){
            $this->_name = $name;
        }
    }
    
    public function setDamages($damages) {
        $damages = (int) $damages;
        if ($damages >= 0 && $damages <= 100) {
            $this->_damages = $damages;
        }
    }
    
}
