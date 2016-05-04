<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/5/2
 * Time: 14:49
 */
class DatauploadModel extends BaseModel{

    private $datauploadModel='Dataupload';

    protected $tableFields=array(
     'id'=>array('name'=>'ID','order'=>'1'),
     'dataUploadName'=>array('name'=>'dataUploadName','order'=>'1')
    );

    /**
     *创建dataUploadModel
     */
    public function createDataUpload($data){
        return $this->insert2($param=array('modelName'=>$this->datauploadModel),$data);
    }

    /**
     * @param $condition 查找条件
     * @return array 返回执行结果
     */
    public function findOne($condition){
        return $this->getDetailNoCache($param=array('modelName'=>$this->datauploadModel),$condition);
    }
}