<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/27
 * Time: 17:45
 */
class PictureModel extends Model{

    /**
     * 定义
     * string $model 使用$this->model 调用模型名
     * array $_validate 自动验证
     * array $auto 自动完成
     * array $_tableFields 列表字段
     * array $searchFields 查询字段
     */

    public $model='Picture';

    protected $_validate=array(
        array('title','require','请输入标题！'),
        array('content','require','请输入内容'),
    );

    protected $_auto=array(
      array('uTime','time',3,'function')
    );

    public $tableFields=array(
        'id'=>array('name'=>'ID','order'=>'1'),
        'cid'=>array('name'=>'类别','order'=>'1'),


    );
}
