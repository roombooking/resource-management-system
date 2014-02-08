<?php
namespace Application\Entity;

class User
{
    protected $userid;
    protected $role;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $bookings;
    
    public function getUserid() {
        return $this->userid;
    }
    
    public function getRole() {
    	return $this->role;
    }
    
    public function getBookings() {
    	return $this->bookings;
    }
}

?>