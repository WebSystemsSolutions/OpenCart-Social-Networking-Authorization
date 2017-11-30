<?php

class ModelOauthField extends model {

    public function getUser($id){

        return $this->db->query("SELECT * FROM `".DB_PREFIX."customer` WHERE `customer_id` ='".(int)$id."' ")->row;

    }



    public function addUserRequestField($data,$id){

        $this->db->query("UPDATE `".DB_PREFIX."customer` SET `firstname`='".$data['firstname']."',`lastname`='".$data['lastname']."',`email`='".$data['email']."',`telephone`='".$data['telephone']."',salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE `customer_id` ='".(int)$id."' ");
    }

}