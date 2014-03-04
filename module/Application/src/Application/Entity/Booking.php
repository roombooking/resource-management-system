<?php
namespace Application\Entity;

class Booking {
    //         SELECT
    //              b.bookingid AS b_bookingid,
    //              b.name AS b_name,
    //              b.description AS b_description,
    //              b.participant_description AS b_participant_description,
    //              b.start AS b_start,
    //              b.end AS b_end,
    //              b.isprebooking AS b_isprebooking,
    //              b.isdeleted AS b_isdeleted,
    //              u_r.userid AS u_r_userid,
    //              u_r.roleid AS u_r_roleid,
    //              u_r.ldapid AS u_r_ldapid,
    //              u_r.loginname AS u_r_loginname,
    //              u_r.firstname AS u_r_firstname,
    //              u_r.lastname AS u_r_lastname,
    //              u_r.emailaddress AS u_r_emailaddress,
    //              u_b.userid AS u_b_userid,
    //              u_b.ldapid AS u_b_ldapid,
    //              u_b.loginname AS u_b_loginname,
    //              u_b.firstname AS u_b_firstname,
    //              u_b.lastname AS u_b_lastname,
    //              u_b.emailaddress AS u_b_emailaddress,
    //              r.resourceid AS r_resourceid,
    //              r.isbookable AS r_isbookable,
    //              r.isdeleted AS r_isdeleted,
    //              r.name AS r_name,
    //              r.description AS r_description,
    //              r.color AS r_color,
    //              u_b.roleid AS u_b_roleid,
    //              e.equipmentid AS e_equipmentid,
    //              p.size AS p_size,
    //              p.seatnumber AS p_seatnumber,
    //              p.placeid AS p_placeid,
    //              c.containmentid AS c_containmentid,
    //              c.parent AS c_parent,
    //              c.name AS c_name,
    //              c.description AS c_description,
    //              h.hirachyid AS h_hirachyid
    //         FROM
    //              Users u_b RIGHT OUTER JOIN Bookings b ON u_b.userid = b.booking_userid
    //              LEFT OUTER JOIN Users u_r ON b.responsible_userid = u_r.userid
    //              LEFT OUTER JOIN Resources r ON b.resourceid = r.resourceid
    //              LEFT OUTER JOIN Equipments e ON r.resourceid = e.resourceid
    //              LEFT OUTER JOIN Places p ON r.resourceid = p.resourceid
    //              LEFT OUTER JOIN Containments c ON r.resourceid = c.child
    //              LEFT OUTER JOIN Hirachies h ON c.hirachyid = h.hirachyid
    
    protected $b_bookingid;
    protected $b_name;
    protected $b_description;
    protected $b_participant_description;
    protected $b_start;
    protected $b_end;
    protected $b_isprebooking;
    protected $b_isdeleted;
    protected $u_r_userid;
    protected $u_r_roleid;
    protected $u_r_ldapid;
    protected $u_r_loginname;
    protected $u_r_firstname;
    protected $u_r_lastname;
    protected $u_r_emailaddress;
    protected $u_b_userid;
    protected $u_b_ldapid;
    protected $u_b_loginname;
    protected $u_b_firstname;
    protected $u_b_lastname;
    protected $u_b_emailaddress;
    protected $r_resourceid;
    protected $r_isbookable;
    protected $r_isdeleted;
    protected $r_name;
    protected $r_description;
    protected $r_color;
    protected $u_b_roleid;
    protected $e_equipmentid;
    protected $p_size;
    protected $p_seatnumber;
    protected $p_placeid;
    protected $c_containmentid;
    protected $c_parent;
    protected $c_name;
    protected $c_description;
    protected $h_hirachyid;
    
    /**
    * Sets h_hirachyid
    *
    * @param type $h_hirachyid
    * @return void
    */
    public function seth_hirachyid($h_hirachyid)
    {
            $this->h_hirachyid = $h_hirachyid;
    }
    
    /**
    * Gets h_hirachyid
    *
    * @return type
    */
    public function geth_hirachyid()
    {
            return $this->h_hirachyid;
    }
    
    /**
    * Sets c_description
    *
    * @param type $c_description
    * @return void
    */
    public function setc_description($c_description)
    {
            $this->c_description = $c_description;
    }
    
    /**
    * Gets c_description
    *
    * @return type
    */
    public function getc_description()
    {
            return $this->c_description;
    }
    
    /**
    * Sets c_name
    *
    * @param type $c_name
    * @return void
    */
    public function setc_name($c_name)
    {
            $this->c_name = $c_name;
    }
    
    /**
    * Gets c_name
    *
    * @return type
    */
    public function getc_name()
    {
            return $this->c_name;
    }
    
    /**
    * Sets c_parent
    *
    * @param type $c_parent
    * @return void
    */
    public function setc_parent($c_parent)
    {
            $this->c_parent = $c_parent;
    }
    
    /**
    * Gets c_parent
    *
    * @return type
    */
    public function getc_parent()
    {
            return $this->c_parent;
    }
    
    /**
    * Sets c_containmentid
    *
    * @param type $c_containmentid
    * @return void
    */
    public function setc_containmentid($c_containmentid)
    {
            $this->c_containmentid = $c_containmentid;
    }
    
    /**
    * Gets c_containmentid
    *
    * @return type
    */
    public function getc_containmentid()
    {
            return $this->c_containmentid;
    }
    
    /**
    * Sets p_placeid
    *
    * @param type $p_placeid
    * @return void
    */
    public function setp_placeid($p_placeid)
    {
            $this->p_placeid = $p_placeid;
    }
    
    /**
    * Gets p_placeid
    *
    * @return type
    */
    public function getp_placeid()
    {
            return $this->p_placeid;
    }
    
    /**
    * Sets p_seatnumber
    *
    * @param type $p_seatnumber
    * @return void
    */
    public function setp_seatnumber($p_seatnumber)
    {
            $this->p_seatnumber = $p_seatnumber;
    }
    
    /**
    * Gets p_seatnumber
    *
    * @return type
    */
    public function getp_seatnumber()
    {
            return $this->p_seatnumber;
    }
    
    /**
    * Sets p_size
    *
    * @param type $p_size
    * @return void
    */
    public function setp_size($p_size)
    {
            $this->p_size = $p_size;
    }
    
    /**
    * Gets p_size
    *
    * @return type
    */
    public function getp_size()
    {
            return $this->p_size;
    }
    
    /**
    * Sets e_equipmentid
    *
    * @param type $e_equipmentid
    * @return void
    */
    public function sete_equipmentid($e_equipmentid)
    {
            $this->e_equipmentid = $e_equipmentid;
    }
    
    /**
    * Gets e_equipmentid
    *
    * @return type
    */
    public function gete_equipmentid()
    {
            return $this->e_equipmentid;
    }
    
    /**
    * Sets u_b_roleid
    *
    * @param type $u_b_roleid
    * @return void
    */
    public function setu_b_roleid($u_b_roleid)
    {
            $this->u_b_roleid = $u_b_roleid;
    }
    
    /**
    * Gets u_b_roleid
    *
    * @return type
    */
    public function getu_b_roleid()
    {
            return $this->u_b_roleid;
    }
    
    /**
    * Sets r_color
    *
    * @param type $r_color
    * @return void
    */
    public function setr_color($r_color)
    {
            $this->r_color = $r_color;
    }
    
    /**
    * Gets r_color
    *
    * @return type
    */
    public function getr_color()
    {
            return $this->r_color;
    }
    
    /**
    * Sets r_description
    *
    * @param type $r_description
    * @return void
    */
    public function setr_description($r_description)
    {
            $this->r_description = $r_description;
    }
    
    /**
    * Gets r_description
    *
    * @return type
    */
    public function getr_description()
    {
            return $this->r_description;
    }
    
    /**
    * Sets r_name
    *
    * @param type $r_name
    * @return void
    */
    public function setr_name($r_name)
    {
            $this->r_name = $r_name;
    }
    
    /**
    * Gets r_name
    *
    * @return type
    */
    public function getr_name()
    {
            return $this->r_name;
    }
    
    /**
    * Sets r_isdeleted
    *
    * @param type $r_isdeleted
    * @return void
    */
    public function setr_isdeleted($r_isdeleted)
    {
            $this->r_isdeleted = $r_isdeleted;
    }
    
    /**
    * Gets r_isdeleted
    *
    * @return type
    */
    public function getr_isdeleted()
    {
            return $this->r_isdeleted;
    }
    
    /**
    * Sets r_isbookable
    *
    * @param type $r_isbookable
    * @return void
    */
    public function setr_isbookable($r_isbookable)
    {
            $this->r_isbookable = $r_isbookable;
    }
    
    /**
    * Gets r_isbookable
    *
    * @return type
    */
    public function getr_isbookable()
    {
            return $this->r_isbookable;
    }
    
    /**
    * Sets r_resourceid
    *
    * @param type $r_resourceid
    * @return void
    */
    public function setr_resourceid($r_resourceid)
    {
            $this->r_resourceid = $r_resourceid;
    }
    
    /**
    * Gets r_resourceid
    *
    * @return type
    */
    public function getr_resourceid()
    {
            return $this->r_resourceid;
    }
    
    /**
    * Sets u_b_emailaddress
    *
    * @param type $u_b_emailaddress
    * @return void
    */
    public function setu_b_emailaddress($u_b_emailaddress)
    {
            $this->u_b_emailaddress = $u_b_emailaddress;
    }
    
    /**
    * Gets u_b_emailaddress
    *
    * @return type
    */
    public function getu_b_emailaddress()
    {
            return $this->u_b_emailaddress;
    }
    
    /**
    * Sets u_b_lastname
    *
    * @param type $u_b_lastname
    * @return void
    */
    public function setu_b_lastname($u_b_lastname)
    {
            $this->u_b_lastname = $u_b_lastname;
    }
    
    /**
    * Gets u_b_lastname
    *
    * @return type
    */
    public function getu_b_lastname()
    {
            return $this->u_b_lastname;
    }
    
    /**
    * Sets u_b_firstname
    *
    * @param type $u_b_firstname
    * @return void
    */
    public function setu_b_firstname($u_b_firstname)
    {
            $this->u_b_firstname = $u_b_firstname;
    }
    
    /**
    * Gets u_b_firstname
    *
    * @return type
    */
    public function getu_b_firstname()
    {
            return $this->u_b_firstname;
    }
    
    /**
    * Sets u_b_loginname
    *
    * @param type $u_b_loginname
    * @return void
    */
    public function setu_b_loginname($u_b_loginname)
    {
            $this->u_b_loginname = $u_b_loginname;
    }
    
    /**
    * Gets u_b_loginname
    *
    * @return type
    */
    public function getu_b_loginname()
    {
            return $this->u_b_loginname;
    }
    
    /**
    * Sets u_b_ldapid
    *
    * @param type $u_b_ldapid
    * @return void
    */
    public function setu_b_ldapid($u_b_ldapid)
    {
            $this->u_b_ldapid = $u_b_ldapid;
    }
    
    /**
    * Gets u_b_ldapid
    *
    * @return type
    */
    public function getu_b_ldapid()
    {
            return $this->u_b_ldapid;
    }
    
    /**
    * Sets u_b_userid
    *
    * @param type $u_b_userid
    * @return void
    */
    public function setu_b_userid($u_b_userid)
    {
            $this->u_b_userid = $u_b_userid;
    }
    
    /**
    * Gets u_b_userid
    *
    * @return type
    */
    public function getu_b_userid()
    {
            return $this->u_b_userid;
    }
    
    /**
    * Sets u_r_emailaddress
    *
    * @param type $u_r_emailaddress
    * @return void
    */
    public function setu_r_emailaddress($u_r_emailaddress)
    {
            $this->u_r_emailaddress = $u_r_emailaddress;
    }
    
    /**
    * Gets u_r_emailaddress
    *
    * @return type
    */
    public function getu_r_emailaddress()
    {
            return $this->u_r_emailaddress;
    }
    
    /**
    * Sets u_r_lastname
    *
    * @param type $u_r_lastname
    * @return void
    */
    public function setu_r_lastname($u_r_lastname)
    {
            $this->u_r_lastname = $u_r_lastname;
    }
    
    /**
    * Gets u_r_lastname
    *
    * @return type
    */
    public function getu_r_lastname()
    {
            return $this->u_r_lastname;
    }
    
    /**
    * Sets u_r_firstname
    *
    * @param type $u_r_firstname
    * @return void
    */
    public function setu_r_firstname($u_r_firstname)
    {
            $this->u_r_firstname = $u_r_firstname;
    }
    
    /**
    * Gets u_r_firstname
    *
    * @return type
    */
    public function getu_r_firstname()
    {
            return $this->u_r_firstname;
    }
    
    /**
    * Sets u_r_loginname
    *
    * @param type $u_r_loginname
    * @return void
    */
    public function setu_r_loginname($u_r_loginname)
    {
            $this->u_r_loginname = $u_r_loginname;
    }
    
    /**
    * Gets u_r_loginname
    *
    * @return type
    */
    public function getu_r_loginname()
    {
            return $this->u_r_loginname;
    }
    
    /**
    * Sets u_r_ldapid
    *
    * @param type $u_r_ldapid
    * @return void
    */
    public function setu_r_ldapid($u_r_ldapid)
    {
            $this->u_r_ldapid = $u_r_ldapid;
    }
    
    /**
    * Gets u_r_ldapid
    *
    * @return type
    */
    public function getu_r_ldapid()
    {
            return $this->u_r_ldapid;
    }
    
    /**
    * Sets u_r_roleid
    *
    * @param type $u_r_roleid
    * @return void
    */
    public function setu_r_roleid($u_r_roleid)
    {
            $this->u_r_roleid = $u_r_roleid;
    }
    
    /**
    * Gets u_r_roleid
    *
    * @return type
    */
    public function getu_r_roleid()
    {
            return $this->u_r_roleid;
    }
    
    /**
    * Sets u_r_userid
    *
    * @param type $u_r_userid
    * @return void
    */
    public function setu_r_userid($u_r_userid)
    {
            $this->u_r_userid = $u_r_userid;
    }
    
    /**
    * Gets u_r_userid
    *
    * @return type
    */
    public function getu_r_userid()
    {
            return $this->u_r_userid;
    }
    
    /**
    * Sets b_isdeleted
    *
    * @param type $b_isdeleted
    * @return void
    */
    public function setb_isdeleted($b_isdeleted)
    {
            $this->b_isdeleted = $b_isdeleted;
    }
    
    /**
    * Gets b_isdeleted
    *
    * @return type
    */
    public function getb_isdeleted()
    {
            return $this->b_isdeleted;
    }
    
    /**
    * Sets b_isprebooking
    *
    * @param type $b_isprebooking
    * @return void
    */
    public function setb_isprebooking($b_isprebooking)
    {
            $this->b_isprebooking = $b_isprebooking;
    }
    
    /**
    * Gets b_isprebooking
    *
    * @return type
    */
    public function getb_isprebooking()
    {
            return $this->b_isprebooking;
    }
    
    /**
    * Sets b_end
    *
    * @param type $b_end
    * @return void
    */
    public function setb_end($b_end)
    {
            $this->b_end = $b_end;
    }
    
    /**
    * Gets b_end
    *
    * @return type
    */
    public function getb_end()
    {
            return $this->b_end;
    }
    
    /**
    * Sets b_start
    *
    * @param type $b_start
    * @return void
    */
    public function setb_start($b_start)
    {
            $this->b_start = $b_start;
    }
    
    /**
    * Gets b_start
    *
    * @return type
    */
    public function getb_start()
    {
            return $this->b_start;
    }
    
    /**
    * Sets b_participant_description
    *
    * @param type $b_participant_description
    * @return void
    */
    public function setb_participant_description($b_participant_description)
    {
            $this->b_participant_description = $b_participant_description;
    }
    
    /**
    * Gets b_participant_description
    *
    * @return type
    */
    public function getb_participant_description()
    {
            return $this->b_participant_description;
    }
    
    /**
    * Sets b_description
    *
    * @param type $b_description
    * @return void
    */
    public function setb_description($b_description)
    {
            $this->b_description = $b_description;
    }
    
    /**
    * Gets b_description
    *
    * @return type
    */
    public function getb_description()
    {
            return $this->b_description;
    }
    
    /**
    * Sets b_name
    *
    * @param type $b_name
    * @return void
    */
    public function setb_name($b_name)
    {
            $this->b_name = $b_name;
    }
    
    /**
    * Gets b_name
    *
    * @return type
    */
    public function getb_name()
    {
            return $this->b_name;
    }
    
    /**
    * Sets b_bookingid
    *
    * @param type $b_bookingid
    * @return void
    */
    public function setb_bookingid($b_bookingid)
    {
            $this->b_bookingid = $b_bookingid;
    }
    
    /**
    * Gets b_bookingid
    *
    * @return type
    */
    public function getb_bookingid()
    {
            return $this->b_bookingid;
    }
    
}
?>