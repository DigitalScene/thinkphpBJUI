<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/27
 * Time: 17:45
 */
class PictureModel extends BaseModel{

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
        'picsrc'=>array('name'=>'图片路径','order'=>'1'),
        'disceneID'=>array('name'=>'场景id','order'=>'1'),
        'level'=>array('name'=>'等级','order'=>'1'),
    );

    /**
     * 添加图片
     * @param $data
     * @return array
     */
    public function addPicture($data){
        return $this->insert($param=array('modelName'=>$this->model),$data);
    }

    /**
     * 根据条件查找相应的数据
     * @param $condition
     */
    public function findAllByDisceneId($condition){
        $list=$this->getAllList($param=array('modelName'=>$this->model,'field'=>'*','order'=>'id DESC'),$condition);

//        foreach ($list as $k => $v) {
//            $list[$k]['picsrc']="<img src='$v[picsrc]' style='height: 110px;width: 110px;margin-left: 8px;'/>";
//        }

        return $list;
    }

}
