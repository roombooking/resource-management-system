<?php
namespace Application\Entity;

class User
{
    protected $userid = 0;
    protected $role = '';
    protected $firstname = '';
    protected $lastname = '';
    protected $email = '';
    
    public function setId($userid) {
        $this->userid = $userid;
    }
    
    public function getId() {
        return $this->userid;
    }
    
    //FIXME: maybe Type Role?
    public function setRole($role) {
        $this->role = $role;
    }
    
    public function getRole() {
    	return $this->role;
    }
    
    public function setFirstname($name) {
    	$this->firstname = $name;
    }
    
    public function getFirstname() {
    	return $this->firstname;
    }
    
    public function setLastname($name) {
    	$this->lastname = $name;
    }
    
    public function getLastname() {
    	return $this->lastname;
    }

    public function setEmail($mail) {
    	$this->email = $mail;
    }
    
    public function getEmail() {
    	return $this->email;
    }
}

?>