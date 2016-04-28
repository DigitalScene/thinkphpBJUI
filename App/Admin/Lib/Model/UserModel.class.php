<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/22
 * Time: 14:55
 */
class UserModel extends Model{

    /**
     * 定义
     */
    public $model='User';

    /**
     * @var array 这个是字段名
     */
    public $tableFields=array(
      'uid'=>array('name'=>'UID','order'=>'1'),
        'username'=>array('name'=>'账号','order'=>'1',),
        'name'=>array('name'=>'姓名','order'=>1),
        'sex'=>array('name'=>'性别','order'=>'0'),
        'status'=>array('name'=>'状态','order'=>'1')
    );

    /**
     * @var array这个有什么用
     * 当使用系统的create方法创建数据对象的时候会自动进行数据验证操作，
     */
    protected $_validate=array(
        array('name','require','姓名必填'),
        array('passwd','require','密码必填!'),
        array('repasswd','passwd','确认密码不正确',0,'confirm'),
        array('email','require','邮箱必填！'),
        array('email','email','邮箱格式错误！',2),
        array('name','','姓名已存在！',0,'unique',self::MODEL_INSERT),
    );

    /**
     * @var array这个有什么用
     * 自动完成类，可以完成数据自动处理功能，用啦处理默认值，数据过滤以及其他系统
     */
    protected $_auto=array(
        array('pass','md5',3,'function'),
        array('ifadmin','0',self::MODEL_INSERT),
        array('ip','get_client_ip',3,'function'),
        array('createtime','time',3,'function'),
    );

    /**
     * 管理员列表
     */
    public function index($condition){
        import('ORG.Util.Page');//导入分页类
//        $list=
        $Page=new Page();

    }

    /**
     * @param $condition数据详情
     */
    public function detail($condition){
//        return $this->get
    }

    /**
     * @param $uid
     * @return mixed获得用户详情
     */
    public function getMemberDetailByUid($uid){
        if(isset($uid)){
            $map["uid"]=$uid;
            return M("User")->where($map)->find();
        }
    }

    //获得用户列表
    public function getMemberListByAll(){
        return M("User")->select();
    }

    //编辑用户
    public function edit(){
        $M=M("User");
        $data=$_POST['info'];
        $data['updata_time']=time();
        if($M->save($data)){
            return array('status'=>1,'info'=>"已经更新",'url'=>U('Member/index'));
        }else {
            return array('status' => 0, 'info' => "更新失败，请刷新页面尝试操作");
        }
    }




}