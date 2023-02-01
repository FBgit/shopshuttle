<?php

namespace App;

class Transport {
    
     /**
     * Class constructor.
    
        public function __construct(type $ = null)
        {
            $this->dbo = Dbo::getInstance();
        }
     */

    // add tarif option
    public function add_opt($obj, $args) {
        // variable args
        $length = count($args);
        //extract($args);
        //echo $length.'<br>';
        if($length >2) {
            //return '<option value="'.$obj->$args[0].'">'.$obj->$args[1].' ... '. $obj->$args[2].'</option>';
        } else {
            $cat_num = $args[0];
            $cat_name = $args[1];
            return '<option value="'.$obj->$cat_num.'">'.$obj->$cat_name.'</option>';
        }
        
    }

    // Selects
    public function cat_control($data) {
         // get array w objects
         if(is_array($data)) {
            $ctl = '<select class="form-control">';
            
            foreach($data as $v) {
                $ctl.= $this->add_opt($v, ["cat_num", "cat_name"]);
            }
            $ctl.= '</select>';

            return $ctl;
         }   
         return false;
    }


    // Only Options
    public function cat_options($data) {
         // get array w objects
         if(is_array($data)) {
            $ctl = '';
            
            foreach($data as $v) {
                $ctl.= $this->add_opt($v, ["cat_num", "cat_name"]);
            }
            

            return $ctl;
         }   
         return false;
    }
    
    public function get_info() {
        echo "This is the TRANSPORT-class!";
    }
}