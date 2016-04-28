<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/28
 * Time: 9:07
 */
class ProjectModel extends Model{

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

    );
}