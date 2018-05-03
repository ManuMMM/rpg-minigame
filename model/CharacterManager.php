<?php

/**
 * Description of CharacterManager
 * -----------------------------------------------------------------------------
 * Class that will manage the link of character Object with the database
 * -----------------------------------------------------------------------------
 * @author Manu
 */

class CharacterManager extends Manager {
    
    private $_db;
    
    // Constructor //
    
    public function __construct($db) {
        $this->setDb($db);
    }
    
    // Function Hydratation //    
    
    // Functions reflecting the functionnalities of the charactermanager //
    
    public function add(Character $perso) {
        // Prepare the INSERT request
        $req = $this->getDb()->prepare('INSERT INTO characters(name) VALUES(:name)');
        // Binding value (it will be a name, so a str, we specify the PDO::PARAM_STR parameter but it should be already the default one)
        $req->bindValue(':name', $perso->getName(), PDO::PARAM_STR);
        // Execute the request
        $req->execute();
        // Finish processing the request
        $req->closeCursor();
        
        // Hydrate the Character Object
        $perso->hydrate([
          'id' => $this->_db->lastInsertId(),
          'damages' => 0,
        ]);
    }
    
    public function update(Character $perso) {
        // Prepare the UPDATE request
        $req = $this->getDb()->prepare('UPDATE characters SET damages = :damages WHERE id = :id');
        // Binding values (these will be int, so we specify the PDO::PARAM_INT parameter)
        $req->bindValue(':damages', $perso->getDamages(), PDO::PARAM_INT);
        $req->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
        // Execute the request
        $req->execute();
        // Finish processing the request
        $req->closeCursor();
    }
    
    public function delete(Character $perso) {
        // Execute a DELETE request
        $req = $this->getDb()->prepare('DELETE FROM characters WHERE id = :id');
        $req->$req->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
        $req->execute();
        // Finish processing the request
        $req->closeCursor();
    }
    
    public function getCharacter($info) {
        // If $info is an integrer => we want to get a character by its ID
        // Execute a SELECT request WEHRE id = $info
        // Return a Character Object
        if(is_int($info)){
            $req = $this->getDb()->prepare('SELECT id, name, damages FROM characters WHERE id = :id');
            $req->bindValue(':id', $info, PDO::PARAM_INT);
            $req->execute();
            $data = $req->fetch(PDO::FETCH_ASSOC);
            // Finish processing the request
            $req->closeCursor();
            return new Character($data);
        }
        
        // If not, it's that $info is a name => we want to get a character by its name
        // Execute a SELECT request WEHRE name = $info
        // Return a Character Object
        else {
            $req = $this->getDb()->prepare('SELECT id, name, damages FROM characters WHERE name = :name');
            $req->bindValue(':name', $info, PDO::PARAM_STR);
            $req->execute();
            $data = $req->fetch(PDO::FETCH_ASSOC);
            // Finish processing the request
            $req->closeCursor();
            return new Character($data);
        }
    }
    
    public function count() {
        // Execute a COUNT() request & return the result number (we can use a query because no parameters are needed @security)
        return $this->getDb()->query('SELECT COUNT(*) FROM characters')->fetchColumn();
    }
    
    public function getListOfOthersCharacters($name) {
        // Define the array $persos which will be return
        $persos = [];
        // Do a SELECT request WHERE name is not $name 
        // Return the list of the characters in an array of Character instances        
        $req = $this->getDb()->prepare('SELECT id, name, damages FROM characters WHERE name <> :name ORDER BY name');
        $req->bindValue(':name', $name, PDO::PARAM_STR);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $persos[] = new Character($data);
        }
        // Finish processing the request
        $req->closeCursor();
        return $persos;
    }
    
    public function exists($info) {
        // If $info is an integrer => we want to get a character by its ID
        // Execute a COUNT() request WEHRE id = $info
        // Return a boolean
        if (is_int($info)) {
            $req = $this->getDb()->prepare('SELECT COUNT(*) FROM characters WHERE id = :id');
            $req->bindValue(':id', $info, PDO::PARAM_INT);
            $req->execute();
            $answer = $req->fetchColumn();
            // Finish processing the request
            $req->closeCursor();
            return (bool) $answer;
        }
        // If not, it's that $info is a name => we want to get a character by its name
        // Execute a SELECT request WEHRE name = $info
        // Return a boolean
        else {            
            $req = $this->getDb()->prepare('SELECT COUNT(*) FROM characters WHERE name = :name');
            $req->bindValue(':name', $info, PDO::PARAM_STR);
            $req->execute();
            $answer = $req->fetchColumn();
            // Finish processing the request
            $req->closeCursor();
            return (bool) $answer;
        }
    }
    
    // GETTERS //
    
    public function getDb() {
        return $this->_db;
    }
    
    // SETTERS //
    
    public function setDb(PDO $db) {
        $this->_db = $this->dbConnect();
    }
    
}
