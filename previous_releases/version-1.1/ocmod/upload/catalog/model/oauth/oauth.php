<?php

class ModelOauthOauth extends model {

    public function createNewOautUser($user){
        if(!isset($user['name'])){
            $user['name'] = $user['firstname'] . $user['lastname'];
        }

        $token_password = $user['password'];
        $this->db->query("INSERT INTO `" . DB_PREFIX . "oauth` SET `id_customer` = ".(int)$user['id_c'].", `name`= '". $user['name']. "'".
        ", `email` = '".$user['email']."', `token_password` = '".$token_password."', `id_auth` = ".$user['id']."  ");
        //echo "xz";

    }

    public function validateEmailUserOauth($email){

        $res = $this->db->query("SELECT `email` FROM `".DB_PREFIX."oauth` WHERE `email` = '".$email."'")->num_rows;
        if($res > 0){
            return true;
        }else{
            return false;
        }
    }
    public function validateEmailUser($email){

        $res = $this->db->query("SELECT `customer_id` FROM `".DB_PREFIX."customer` WHERE `email` = '".$email."'")->row;
        if(empty($res['customer_id'])){
        return true;
        }else{
         return $res['customer_id'];
        }
    }

    public function getOauth($token_oauth){

         $res = $this->db->query("SELECT * FROM `".DB_PREFIX."oauth` WHERE `token_password` ='".$token_oauth."' ")->row;

         //if(!empty($res)){
             return $res;
         //}else{
            // return false;
         //}


    }

    public function setStatus($status,$id_customer){

        $this->db->query("UPDATE `".DB_PREFIX."oauth` SET `status` = '".(int)$status."'");

    }

    public function setToken($token,$id_customer){

        $this->db->query("UPDATE `".DB_PREFIX."oauth` SET `token_password` = '".$token."' WHERE `id_customer`= '".(int)$id_customer."'");

    }

}