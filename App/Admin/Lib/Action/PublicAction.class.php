<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/20
 * Time: 14:20
 */
class PublicAction extends Action{
    public $loginMarked;

    /**
     * @return mixed
     */
    public function getLoginMarked()
    {
        return $this->loginMarked;
    }

    /**
     * @param mixed $loginMarked
     */
    public function setLoginMarked($loginMarked)
    {
        $this->loginMarked = $loginMarked;
    }

    /**
     * 初始化设置
     */
    public function _initialze(){
        header("Content-Type:text/html;charset=utf-8");
        header("Content-Type:application/json;charset=utf-8");
        //C()什么意思，忘了
        //C（名称）获得配置变量（convertion.php  config.php）信息
        //C（名称，值） 设置配置变量信息
//        $loginMarked=C("TOKEN");
//        //登录标识，并且MD5加密
//        $this->loginMarked=md5($loginMarked['admin_marked']);

    }


    /**
     * 验证token信息
     *
     */
    private function checkToken(){
        //后者在使用就是实例化Model父类
        if(!M("User")->autoCheckToken($_POST)){
            //json_encode() 调用json_encode后会将中文转为unicode编码
            die(json_encode(array('status'=>0,'info'=>'令牌验证失败')));
        }
       //unset  销毁指定的变量。
        unset($_POST[C("TOKEN_NAME")]);
    }

    public function index(){
        if(IS_POST){
            //调用checkToken
//            $this->checkToken();
                //D() 是tp3.1.3里边对new操作的简化方法
            $resultLoginInfo=D('Public')->auth();

            $this->ajaxReturn($resultLoginInfo);
        }else{
            $loginMarked=C("TOKEN");
            //登录标识，并且MD5加密
            $loginMarked=md5($loginMarked['admin_marked']);
            //isset 判断这个变量是否存在
            if(isset($_COOKIE[$loginMarked])){
                $this->redirect("Index/index");
            }

            //这个什么意思 $this->display('[分组名:]模块名:操作名');
            $this->display("Common:login");
        }
    }


    /**
     * 显示验证码
     */
    public function verify_code(){
        import('ORG.Util.Image');
        Image::buildImageVerify($length=4, $mode=1, $type='png', $width=110, $height=34, $verifyName='verify');
    }


    /**
     * 退出登录
     */
    public function loginOut(){
        $loginMarked=C("TOKEN");
        //登录标识，并且MD5加密
        $loginMarked=md5($loginMarked['admin_marked']);
        setcookie("$loginMarked",NULL,-3600,"/");
        unset($_SESSION["$loginMarked"],$_COOKIE["$loginMarked"]);
        if (isset($_SESSION[C('USER_AUTH_KEY')])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
            unset($_SESSION);
            session_destroy();
        }
        $this->redirect("Index/index");
    }
}