<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/5/3
 * Time: 10:48
 */
class DisceneModel extends BaseModel{

    private $datauploadModel='Discene';

    //自动完成
    protected $_auto=array();

    public $tableFields=array(

        'id'=>array('name'=>'场景ID','order'=>'1'),
        'name'=>array('name'=>'场景名','order'=>'1'),
        'creatingPer'=>array('name'=>'场景创建人','order'=>'1'),
        'creatingDate'=>array('name'=>'场景创建日期','order'=>'1'),
        'desc'=>array('name'=>'场景描述','order'=>'1')
    );


    /**
     * 后台数据列表
     * $condition 查询条件
     * $list 返回列表数据
     */
    public function index($condition){
        $list=$this->getPageList($param=array('modelName'=>$this->datauploadModel,'field'=>'*','order'=>'id DESC','listRows'=>'20'),$condition);

//        foreach ($list['info'] as $k => $v) {
//            $list['info'][$k]['id'] = $v['id'];
//            $list['info'][$k]['creatingPer'] = $v['creatingPer'];
//            $list['info'][$k]['creatingDate'] = ' 创建于 ' . $v['creatingDate'];
//            $list['info'][$k]['desc'] = $v['desc'];
//        }
        return $list;

    }


    /**
     * 添加场景数据
     * @param mixed|string $data
     * @return array
     */
    public function add($data){
        return $this->insert($param=array('modelName'=>$this->datauploadModel),$data);
    }

    /**
     * 数据详情
     * @param $condition 查询条件
     * @return array
     */
    public function detail($condition){
        return $this->getDetailNoCache($param=array('modelName'=>$this->datauploadModel),$condition);
    }

    /**
    +----------------------------------------------------------
     * 数据更新
     * @param  array  $data  要更新的数据
     * @return  array  返回执行结果
    +----------------------------------------------------------
     */
    public function edit($data){

        return $this->update($param = array('modelName' => $this->datauploadModel), $data, $condition);
    }

    /**
     * @param $condition 删除条件
     * @return array 返回执行结果
     */
    public function remove($condition){
        return $this->del($param=array('modelName'=>$this->datauploadModel),$condition);
    }

}