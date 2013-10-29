<?php 
class carte {  

    protected $id;

 function __construct($id) {
        $this->setid($id);
        }
	

 	public function getid() {
        return $this->id;
    }
    public function setid($id) {
        $this->id = $id;
    }
 }	
 
 ?>