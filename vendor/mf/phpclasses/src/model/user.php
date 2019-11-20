<?php

namespace MF\Model;

use MF\DB\Sql;
use MF\Model;

class User extends Model{

    const SESSION_ERROR = "error";
    const SESSION_SUCCESS  = "success";
    const SESSION = "user";

    public static function getFromSession(){
        $user = new User();

        if(isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0){
            $user->get((int)$_SESSION[User::SESSION]['iduser']);
        }
        return $user;
    }

    public static function login($login, $password){
        $sql = new Sql();

        $results = $sql->select("select * from tb_users where deslogin = :LOGIN",array(
            ":LOGIN" => $login
        ));

        if(count($results)===0){
            throw new \Exception("Usuario inexistente ou senha invalida");
            
        }

        $data = $results[0];

        if(password_verify($password, $data["despassword"]) === true){
            $user = new User();

            $user->setData($data);
            
            $_SESSION[User::SESSION] = $user->getValues();

            return $user;

        }else{
            throw new \Exception("Usuario inexistente ou senha invalida");
            
        }
    }

    public static function logout(){
        $_SESSION[User::SESSION] = null;
    }

    public static function checkLogin($inadmin = true){
        //se a sessao nao esta definida ou se esta definida e esta vazia ou se p id nao é maior que
        if(
        !isset($_SESSION[User::SESSION])
        || 
        !$_SESSION[User::SESSION]
        ||
        !(int)$_SESSION[User::SESSION]['iduser'] > 0
        ){
            //Não esta logado
            return false;
        }else{
            //esta logado , so tera acesso se for administrador
            if($inadmin === true && (bool)$_SESSION[User::SESSION]['inadmin'] === true){
                return true;
            }else if($inadmin === false){
                //esta logado como usuario
                return true;
            }else{
                return false;
            }
        }
    }

    public static function checkLoginExists($deslogin){
        $sql = new Sql();

        $results = $sql->select("select * from tb_users where deslogin = :deslogin",array(
            ":deslogin"=>$deslogin
        ));

        return (count($results) > 0);
    }

    public static function verifyLogin($inadmin= true){
        if(!User::checkLogin($inadmin)){
            if($inadmin){
                header("Location: /admin/login");
            }else{
                header("Location: /login");
            }
            exit;
        }
          
    }
    public function get($iduser){
        $sql = new Sql();

        $results= $sql->select("select * from tb_users a inner join tb_persons b using(idperson) where a.iduser = :iduser",array(
            ":iduser"=>$iduser
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }

    public function save(){
        $sql = new sql();

        $results = $sql->select("CALL sp_users_save(:desperson,:desemail,:deslogin,:despassword,:nrphone,:inadmin)",array(
            ":desperson"=>$this->getdesperson(),
            ":desemail"=>$this->getdesemail(),
            ":deslogin"=>$this->getdeslogin(),
            ":despassword"=>User::hashPassword($this->getdespassword()),
            ":nrphone"=>$this->getnrphone(),            
            ":inadmin"=>$this->getinadmin()
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }

    public function update(){
        $sql = new Sql();

        $results = $sql->select("CALL sp_updateusers_save(:iduser,:desperson,:deslogin,:despassword,:desemail,:nrphone,:inadmin)",array(
            ":iduser"=>$this->getiduser(),
            ":desperson"=>$this->getdesperson(),
            ":deslogin"=>$this->getdeslogin(),
            ":despassword"=>User::hashPassword($this->getdespassword()),
            ":desemail"=>$this->getdesemail(),
            ":nrphone"=>$this->getnrphone(),
            ":inadmin"=>$this->getinadmin()
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }


    public static function listAll(){
        $sql = new Sql();

        return $sql->select("select * from tb_users a inner join tb_persons b using(idperson)");
    }
    
    public function setPassword($despassword){
        $sql = new Sql();

        $results = $sql->select("update tb_users set despassword = :despassword where iduser = :iduser",array(
            ":despassword"=>User::hashPassword($despassword),
            ":iduser"=>$this->getiduser()
        ));

        return (count($results) > 0);
    }

    public static function hashPassword($despassword){
        return password_hash($despassword,PASSWORD_DEFAULT, [
            'cost'=>12
        ]);
     }

    public function getOrder(){
            $sql = new Sql();

            $results = $sql->select("
            select 
            * 
            from tb_orders a
            inner join tb_ordersstatus b using(idstatus)
            inner join tb_carts c using(idcart)
            inner join tb_users d on d.iduser = a.iduser
            inner join tb_address e using(idaddress)
            inner join tb_persons f on f.idperson = d.idperson
            where a.iduser = :iduser
            ",array(
                ":iduser"=>$this->getiduser()
            ));
       

            return $results;
    }


    public static function setmsgError($msg){
        $_SESSION[User::SESSION_ERROR] = $msg;
    }
    public static function getMsgError(){
        $msg = (isset($_SESSION[User::SESSION_ERROR]))?$_SESSION[User::SESSION_ERROR] : null;

        User::clearSession();

        return $msg;
    }

    public static function clearSession(){
        $_SESSION[User::SESSION_ERROR] = null;
    }

    public static function setMsgSuccess($msg){
        $_SESSION[User::SESSION_SUCCESS] = $msg;
    }
    public static function getMsgSuccess(){
        $msg = isset($_SESSION[User::SESSION_SUCCESS])? $_SESSION[User::SESSION_SUCCESS] : null;

        User::clearSuccess();

        return $msg;
    }
    public static function clearSuccess(){
        $_SESSIO[User::SESSION_SUCCESS] = null;
    }
}




?>

