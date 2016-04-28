<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/24
 * Time: 0:56
 */
class CommonAction extends Action{

    public $loginMarked;
    public $myInfo;

    /**
     * 初始化
     * 如果，继承本类的类自身也需要初始化 那么需要在使用本继承类的类里使用parent::_initialize();
     */
    public function _initialize(){
        $this->loginMarked=md5(C('TOKEN.admin_marked'));
        $this->checkLogin();

        $this->myInfo=$_SESSION['myInfo'];
        $this->assign("myInfo",$_SESSION['myInfo']);
    }


    public function checkLogin() {
        if (isset($_COOKIE[$this->loginMarked])) {
            $cookie = explode("_", $_COOKIE[$this->loginMarked]);
            $timeout = C("TOKEN");
            if (time() > (end($cookie) + $timeout['admin_timeout'])) {
//                setcookie("$this->loginMarked", NULL, -3600, "/");
//                unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
//                $this->error("登录超时，请重新登录", U("Admin/Public/index"));
            } else {
                if ($cookie[0] == $_SESSION[$this->loginMarked]) {
                    setcookie("$this->loginMarked", $cookie[0] . "_" . time(), 0, "/");
                } else {
                    //setcookie("$this->loginMarked", NULL, -3600, "/");
                    //unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                    //$this->error("帐号异常，请重新登录", U("Public/index"));
                }
            }
        } else {
            $this->redirect("Admin/Public/index");
        }
        return TRUE;
    }


}