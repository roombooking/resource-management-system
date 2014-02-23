<?php
namespace Application\Entity;

class User
{
    //FIXME: Hydrator?
    protected $id = 0;
    protected $role_id = null;
    protected $ldap_id = '';
    protected $loginname = '';
    protected $firstname = '';
    protected $lastname = '';
    protected $emailaddress = '';
    
    public function setId($userid) {
        $this->id = $userid;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setLdapId($ldapId) {
    	$this->ldap_id = $ldapId;
    }
    
    public function getLdapId() {
    	return $this->ldap_id;
    }
    
    public function setLoginName($loginName) {
    	$this->loginname = $loginName;
    }
    
    public function getLoginName() {
    	return $this->loginname;
    }
    
    //FIXME: maybe Type Role?
    public function setRole($role) {
        $this->role_id = $role;
    }
    
    public function getRole() {
    	return $this->role_id;
    }
    
    public function setFirstName($name) {
    	$this->firstname = $name;
    }
    
    public function getFirstName() {
    	return $this->firstname;
    }
    
    public function setLastName($name) {
    	$this->lastname = $name;
    }
    
    public function getLastName() {
    	return $this->lastname;
    }

    public function setEmail($mail) {
    	$this->emailaddress = $mail;
    }
    
    public function getEmail() {
    	return $this->emailaddress;
    }
}