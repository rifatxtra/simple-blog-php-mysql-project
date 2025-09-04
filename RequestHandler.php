<?php
namespace LH;
class RequestHandler{
    public function postRequest($key){
        if(isset($_POST[$key])){
            return htmlspecialchars($_POST[$key]);
        }
        else return null;
    }
    public function getRequest($key){
        if(isset($_GET[$key])){
            return htmlspecialchars($_GET[$key]);
        }
        else return null;
    }

    public function validate($data){
        foreach($data as $dt){
            if(isset($_POST[$dt]) && !empty(trim($_POST[$dt]))){
                return true;
            }
            else{
                return false;
            }
        }
    }
}