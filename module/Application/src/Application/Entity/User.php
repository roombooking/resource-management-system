<?php
namespace Application\Entity;

/**
 * User Entity
 *
 * This entity represents a user.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */

class User
{
    //FIXME: Hydrator?
    protected $userid = 0;
    protected $roleid = null;
    protected $isdeleted = false;
    protected $ldapid = '';
    protected $loginname = '';
    protected $firstname = '';
    protected $lastname = '';
    protected $emailaddress = '';
    
    public function setId($userid) {
        $this->userid = $userid;
    }
    
    public function getId() {
        return $this->userid;
    }
    
    public function setIsDeleted($deleted) {
        $this->isdeleted = (bool) $deleted;
    }
    
    public function isDeleted() {
        return (bool) $this->isdeleted;
    }
    
    public function setLdapId($ldapId) {
    	$this->ldapid = $ldapId;
    }
    
    public function getLdapId() {
    	return $this->ldapid;
    }
    
    public function setLoginName($loginName) {
    	$this->loginname = $loginName;
    }
    
    public function getLoginName() {
    	return $this->loginname;
    }
    
    //FIXME: maybe Type Role?
    public function setRole($role) {
        $this->roleid = $role;
    }
    
    public function getRole() {
    	return $this->roleid;
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