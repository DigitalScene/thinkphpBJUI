<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/28
 * Time: 9:07
 */
class ProjectModel extends BaseModel{

    /**
    +----------------------------------------------------------
     * 定义
     * @param  string  $model  使用$this->model调用模型名
     * @param  array  $_validate  自动验证
     * @param  array  $_auto  自动完成
     * @param  array  $tableFields  列表字段
     * @param  array  $searchFields  查询字段
    +----------------------------------------------------------
     */

    public $model='Project';

    //自动验证
    protected $_validate=array(
      array('name','require','请输入项目名'),
    );

    //自动完成
    protected $_auto=array();

    public $tableFields=array(
       'id'=>array('name'=>'ID','order'=>'1'),
        'name'=>array('name'=>'项目名','order'=>'1'),
        'creatingDate'=>array('name'=>'创建日期','order'=>'1'),
        'creatingPer'=>array('name'=>'创建人','order'=>'1'),
        'desc'=>array('name'=>'项目描述','order'=>'1'),
        'status'=>array('name'=>'项目状态','order'=>'1')
    );


    /**
     * 后台数据列表
     * $condition 查询条件
     * $list 返回列表数据
     */
    public function index($condition){


        $list=$this->getPageList($param=array('modelName'=>$this->model,'field'=>'*','order'=>'id DESC','listRows'=>'20'),$condition);

        foreach ($list['info'] as $k => $v) {
            $list['info'][$k]['id'] = $v['id'];
            $list['info'][$k]['name'] = $v['name'];
            $list['info'][$k]['creatingPer'] = $v['creatingPer'];
            $list['info'][$k]['creatingDate'] = ' 创建于 ' . $v['creatingDate'];
            $list['info'][$k]['desc'] = $v['desc'];
            if($v['status']==0){
                $list['info'][$k]['status'] ='项目尚未启动';
            }else if($v['status']==1){
                $list['info'][$k]['status'] ='项目正在启动中';
            }else if($v['status']==2){
                $list['info'][$k]['status'] ='用户数据上传中';
            }else if($v['status']==3){
                $list['info'][$k]['status'] ='原始图片编辑中';
            }else if($v['status']==4){
                $list['info'][$k]['status']='球形图制作中';
            }else if($v['status']==5){
                $list['info'][$k]['status']='场景构建中';
            }else if($v['status']==6){
                $list['info'][$k]['status']='数据整合中';
            }else if($v['status']==7){
                $list['info'][$k]['status']='已完成';
            }

        }
        return $list;
    }

    /**
     * 新增数据
     */
    public function add($data){
        return $this->insert($param=array('modelName'=>$this->model),$data);
    }


    /**
     * 数据详情
     * @param $condition 查询条件
     * @return array
     */
    public function detail($condition){
        return $this->getDetail($param=array('modelName'=>$this->model),$condition);
    }

    /**
    +----------------------------------------------------------
     * 数据更新
     * @param  array  $data  要更新的数据
     * @return  array  返回执行结果
    +----------------------------------------------------------
     */
    public function edit($data){

        return $this->update($param = array('modelName' => $this->model), $data, $condition);
    }

    /**
     * @param $condition 删除条件
     * @return array 返回执行结果
     */
    public function remove($condition){
        return $this->del($param=array('modelName'=>$this->model),$condition);
    }

    /**
     * @param $condition 查找条件
     * @return array 返回执行结果
     */
    public function findOne($condition){
        return $this->getDetailNoCache($param=array('modelName'=>$this->model),$condition);
    }

}