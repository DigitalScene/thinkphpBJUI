<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/5/2
 * Time: 20:07
 */
class ProcessAction extends CommonAction{

    protected $model;

    /**
     * 初始化
     */
    public function _initialize(){
        parent::_initialize();
        $this->model=D('Process');
    }

    public function index(){
        $condition=$this->searchCondition();
        $condition['isDel']=0;//没有删除
        $list=$this->model->index($condition);
        $this->assign('search',$this->searchKeywords());
        $this->assign('tableFields',$this->model->tableFields);
        $this->assign('list',$list['info']);
        $this->assign('page',$list['page']);
        $this->display("process");
    }

}