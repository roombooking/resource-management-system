<?php
namespace Application\Entity;

class Booking {
    protected $bookingid;
    protected $booking_userid;
    protected $responsible_userid;
    protected $resourceid;
    protected $name;
    protected $description;
    protected $participant_description;
    protected $start;
    protected $end;
    protected $isprebooking;
    protected $isdeleted;
    
    /**
    * Legt bookingid fest
    *
    * @param type $bookingid
    * @return void
    */
    public function setbookingid($bookingid)
    {
            $this->bookingid = $bookingid;
    }
    
    /**
    * Gibt bookingid zurück
    *
    * @return type
    */
    public function getbookingid()
    {
            return $this->bookingid;
    }
    
	/**
	* Legt isdeleted fest
	*
	* @param type $isdeleted
	* @return void
	*/
	public function setIsdeleted($isdeleted)
	{
	        $this->isdeleted = $isdeleted;
	}
	
	/**
	* Gibt isdeleted zurück
	*
	* @return type
	*/
	public function getIsdeleted()
	{
	        return $this->isdeleted;
	}
	
	/**
	* Legt isprebooking fest
	*
	* @param type $isprebooking
	* @return void
	*/
	public function setIsprebooking($isprebooking)
	{
	        $this->isprebooking = $isprebooking;
	}
	
	/**
	* Gibt isprebooking zurück
	*
	* @return type
	*/
	public function getIsprebooking()
	{
	        return $this->isprebooking;
	}
	
	/**
	* Legt end fest
	*
	* @param type $end
	* @return void
	*/
	public function setEnd($end)
	{
	        $this->end = $end;
	}
	
	/**
	* Gibt end zurück
	*
	* @return type
	*/
	public function getEnd()
	{
	        return $this->end;
	}
	
	/**
	* Legt start fest
	*
	* @param type $start
	* @return void
	*/
	public function setStart($start)
	{
	        $this->start = $start;
	}
	
	/**
	* Gibt start zurück
	*
	* @return type
	*/
	public function getStart()
	{
	        return $this->start;
	}
	
	/**
	* Legt participant_description fest
	*
	* @param type $participant_description
	* @return void
	*/
	public function setParticipant_description($participant_description)
	{
	        $this->participant_description = $participant_description;
	}
	
	/**
	* Gibt participant_description zurück
	*
	* @return type
	*/
	public function getParticipant_description()
	{
	        return $this->participant_description;
	}
	
	/**
	* Legt description fest
	*
	* @param type $description
	* @return void
	*/
	public function setDescription($description)
	{
	        $this->description = $description;
	}
	
	/**
	* Gibt description zurück
	*
	* @return type
	*/
	public function getDescription()
	{
	        return $this->description;
	}
	
	/**
	* Legt name fest
	*
	* @param type $name
	* @return void
	*/
	public function setName($name)
	{
	        $this->name = $name;
	}
	
	/**
	* Gibt name zurück
	*
	* @return type
	*/
	public function getName()
	{
	        return $this->name;
	}
	
	/**
	* Legt resourceid fest
	*
	* @param type $resourceid
	* @return void
	*/
	public function setResourceid($resourceid)
	{
	        $this->resourceid = $resourceid;
	}
	
	/**
	* Gibt resourceid zurück
	*
	* @return type
	*/
	public function getResourceid()
	{
	        return $this->resourceid;
	}
	
	/**
	* Legt responsible_userid fest
	*
	* @param type $responsible_userid
	* @return void
	*/
	public function setResponsible_userid($responsible_userid)
	{
	        $this->responsible_userid = $responsible_userid;
	}
	
	/**
	* Gibt responsible_userid zurück
	*
	* @return type
	*/
	public function getResponsible_userid()
	{
	        return $this->responsible_userid;
	}
	
	/**
	* Legt booking_userid fest
	*
	* @param type $booking_userid
	* @return void
	*/
	public function setBooking_userid($booking_userid)
	{
	        $this->booking_userid = $booking_userid;
	}
	
	/**
	* Gibt booking_userid zurück
	*
	* @return type
	*/
	public function getBooking_userid()
	{
	        return $this->booking_userid;
	}
}
?>