<?php
namespace Application\Entity;

/**
 * Resource Entity
 *
 * This entity represents a resource.
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

class Resource {
//         SELECT
//              r.resourceid AS r_resourceid,
//              r.isbookable AS r_isbookable,
//              r.isdeleted AS r_isdeleted,
//              r.name AS r_name,
//              r.description AS r_description,
//              r.color AS r_color,
//              c.hierarchyid AS c_hierarchyid
//         FROM
//              Resources r LEFT OUTER JOIN Containments c ON r.resourceid = c.child
    
    protected $r_resourceid;
    protected $r_isbookable;
    protected $r_isdeleted;
    protected $r_name;
    protected $r_description;
    protected $r_color;
    
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
}
?>