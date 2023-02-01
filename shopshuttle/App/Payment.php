<?php

namespace App;

class Payment {
    public function get_info() {
        echo "This is the \"PAYMENT-Class\"!";
    }

    public function inputField($name_id, $label, $ph, $value="", $type="text", $help="") {
        $tmp = ' <div class="mb-3">';
        if(!empty($label)){
             $tmp.= '<label for="'.$name_id.'" class="form-label">'.$label.'</label>';
        }
       
        $tmp.= '<input type="'.$type.'" class="form-control" name="'.$name_id.'" id="'.$name_id.'"  placeholder="'.$ph.'">';
        if(!empty($help)) {
            $tmp.= '<div id="'.$name_id.'-help" class="form-text">'.$help.'</div>';
        }
        $tmp.= '</div>';

        return $tmp;
    }
    public function inputFieldCombo($name_id, $label, $ph, $value="", $type="text", $help="") {
        $tmp = ' <div class="mb-3">
        <label for="'.$name_id.'" class="form-label">'.$label.'</label>
        <div class="row">
        <div class="col-md-3">
        <input type="'.$type.'" class="form-control" name="plz-'.$name_id.'" id="plz-'.$name_id.'">
        </div>
        <div class="col-md-9">
        <input type="'.$type.'" class="form-control" name="city-'.$name_id.'" id="city-'.$name_id.'"  placeholder="'.$ph.'">';
        if(!empty($help)) {
            $tmp.= '<div id="'.$name_id.'-help" class="form-text">'.$help.'</div>';
        }
        $tmp.= '</div>';
        $tmp.= '</div>';

        $tmp.= '</div>';

        return $tmp;
    }

    public function checkBox($name_id, $label, $onclick="", $help="") {
        $tmp = '<div class="mb-3 form-check">';
        $tmp.= '<input onclick="'.$onclick.'" type="checkbox" class="form-check-input" id="'.$name_id.'" name="'.$name_id.'">';
        $tmp.= '<label class="form-check-label" for="'.$name_id.'">'.$label.'</label>';
        if(!empty($help)) {
            $tmp.= '<div id="'.$name_id.'-help" class="form-text">'.$help.'</div>';
        }
        $tmp.= '</div>';

        return $tmp;
    }

    // Leere Felder
    public function checkEmptyPost($field, $attr) {
        if(empty($_POST[$field])) {
            return "$attr ist erforderlich - bitte Ausfüllen<br>";
        } else {
            return '';
        }
    }

    // bootstrap alert
    function alertBox($text, $class="success") {
        return '<div class="alert alert-'.$class.'">'.$text.'</div>';
    }


}







class Stripe {
    public function get_info() {
        echo "This is the \"STRIPE-Class\"!";
    }
}