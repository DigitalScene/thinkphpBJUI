<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/21
 * Time: 20:09
 */

//下面两个函数乱用，导致错误，不是Modules模型下的根本不需要写
/*namespace Lib\Model;
//标识model
use Model;*/

class PublicModel {
    protected $autoCheckFields=false;

    public function auth(){
        //得到post里面的数据
        $datas=$_POST;
        $verify=session('verify');
        if($verify!=(md5($_POST['verify_code']))){
//            json_decode()编译出来的是对象
//            die(json_encode(array('statusCode'=>300,'message'=>"验证码错误啦，再输入吧")));
            return array('statusCode'=>300,'message'=>"验证码错误啦，再输入吧");
        }
        //实例化UserModel
        $M=M("User");
        if($M->where(" `username`='".$datas['username']."'")->count()>=1){
            //从数据库查找数据
            $info=$M->where("`username`='".$datas['username']."'")->find();
           /* if($info['status']==0){
                return array('statusCode'=>300,'message' => "你的账号被禁用，有疑问请与管理员联系");
            }
            if($datas['op_type']==2){
                $rc=54265;

            }*/

            if($info['pwd']==md5($datas['pwd'].$info['username'])){
                //C() 什么意思 与define差不多  C方法是ThinkPHP用于设置、获取，以及保存配置参数的方法，使用频率较高。
                $loginMarked=C("TOKEN");
                $loginMarked=md5($loginMarked['admin_marked']);
                $shell=$info['uid'].md5($info['pwd'].C('AUTH_CODE'));
                $_SESSION[$loginMarked]="$shell";
                $shell.="_".time();
                setcookie($loginMarked,"$shell",0,"/");
                $_SESSION['myInfo']=$info;
               // U方法用于完成对URL地址的组装


                return array('statusCode' => 200, 'message' => "登录成功", 'url' => U("/Index/index"));
            }else {
                return array('statusCode' => 300, 'message' => "账号或密码错误");
            }
        }else {
            return array('statusCode' => 300, 'message' => "不存在用户名为 " . $datas["username"] . ' 的账号！');
        }
    }




}