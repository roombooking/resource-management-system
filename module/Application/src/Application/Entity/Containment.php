<?php
namespace Application\Entity;

/**
 * Containment Entity
 *
 * This entity represents resources and their containments within each other
 * as well as the hierarchies they belong to.
 *
 * The naming follows the database structure. The attributes are named
 * in the following fashion: {firstLetterOfTable}_{attributeName} to
 * prevent ambiguous names on joined tables.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */

class Containment {
    //     SELECT
    //          r.resourceid AS r_resourceid,
    //          r.isbookable AS r_isbookable,
    //          r.name AS r_name,
    //          r.description AS r_description,
    //          r.color AS r_color,
    //          p.placeid AS p_placeid,
    //          e.equipmentid AS e_equipmentid,
    //          c.hierarchyid AS c_hierarchyid,
    //          c.parent AS c_parent,
    //          c.name AS c_name,
    //          c.description AS c_description,
    //          h.hierarchyid AS h_hierarchyid
    //     FROM
    //          Resources r LEFT OUTER JOIN Places p ON r.resourceid = p.resourceid
    //          LEFT OUTER JOIN Equipments e ON r.resourceid = e.resourceid
    //          LEFT OUTER JOIN Containments c ON r.resourceid = c.child
    //          LEFT OUTER JOIN Hierarchies h ON c.hierarchyid = h.hierarchyid
    //     ORDER BY
    //          h.hierarchyid ASC,
    //          r.resourceid ASC
    
    protected $r_resourceid;
    protected $r_isbookable;
    protected $r_name;
    protected $r_description;
    protected $r_color;
    protected $p_placeid;
    protected $e_equipmentid;
    protected $c_hierarchyid;
    protected $c_parent;
    protected $c_name;
    protected $c_description;
    protected $h_hierarchyid;
    
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
    * Sets c_hierarchyid
    *
    * @param type $c_hierarchyid
    * @return void
    */
    public function setc_hierarchyid($c_hierarchyid)
    {
            $this->c_hierarchyid = $c_hierarchyid;
    }
    
    /**
    * Gets c_hierarchyid
    *
    * @return type
    */
    public function getc_hierarchyid()
    {
            return $this->c_hierarchyid;
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
    * Sets h_hierarchyid
    *
    * @param type $h_hierarchyid
    * @return void
    */
    public function seth_hierarchyid($h_hierarchyid)
    {
            $this->h_hierarchyid = $h_hierarchyid;
    }
    
    /**
    * Gets h_hierarchyid
    *
    * @return type
    */
    public function geth_hierarchyid()
    {
            return $this->h_hierarchyid;
    }
}
?>