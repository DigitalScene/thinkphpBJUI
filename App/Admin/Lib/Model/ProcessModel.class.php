<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/5/1
 * Time: 21:52
 */
class ProcessModel extends BaseModel{

    private $processModel='Process';

    public $tableFields=array(

        'projectID'=>array('name'=>'项目ID','order'=>'1'),
        'projectName'=>array('name'=>'项目名','order'=>'1'),
//        'dataUploadID'=>array('name'=>'dataUploadID','order'=>'1'),
        'dataUploadStatus'=>array('name'=>'用户数据上传模块','order'=>'1'),
        'isFinishPhotoEdit'=>array('name'=>'原始图片编辑模块','order'=>'1'),
        'isFinishSphericalGraph'=>array('name'=>'球形图制作模块','order'=>'1'),
//        'disceneMakingID'=>array('name'=>'disceneMakingID','order'=>'1'),
        'isFinishDisceneMaking'=>array('name'=>'场景构建模块','order'=>'1'),
//        'dataIntegrationID'=>array('name'=>'dataIntegrationID','order'=>'1'),
        'isFinishDataIntegration'=>array('name'=>'数据整合模块','order'=>'1')
    );

    /**
     * 后台数据列表
     * $condition 查询条件
     * $list 返回列表数据
     */
    public function index($condition){
        $list=$this->getPageList($param=array('modelName'=>$this->processModel,'field'=>'*','order'=>'id DESC','listRows'=>'20'),$condition);

        foreach ($list['info'] as $k => $v) {
//            $list['info'][$k]['id'] = $v['id'];
            if($v['dataUploadStatus']==0){
                $list['info'][$k]['dataUploadStatus'] = "尚未开始"."　"."<a href=\"index.php?m=DataUpload&a=index&processId=$v[id]&uploadId=$v[dataUploadID]\" class=\"btn btn-blue\" data-toggle=\"navtab\" data-id=\"mynavtab_$v[id]\" data-title=\"$v[projectName]数据上传模块\">开始编辑</a>";
            }elseif($v['dataUploadStatus']==1){
                $list['info'][$k]['dataUploadStatus'] = "正在制作中"."　"."<a href=\"index.php?m=DataUpload&a=index&processId=$v[id]&uploadId=$v[dataUploadID]\" class=\"btn btn-blue\" data-toggle=\"navtab\" data-id=\"mynavtab_$v[id]\" data-title=\"$v[projectName]数据上传模块\">开始编辑</a>";
            }elseif($v['dataUploadStatus']==2){
                $list['info'][$k]['dataUploadStatus'] = "已完成"."　"."<a href=\"index.php?m=DataUpload&a=index&processId=$v[id]&uploadId=$v[dataUploadID]\" class=\"btn btn-blue\" data-toggle=\"navtab\" data-id=\"mynavtab\" data-title=\"用户数据上传模块\">开始编辑</a>";
            }

//            $list['info'][$k]['creatingPer'] = $v['creatingPer'];
//            $list['info'][$k]['creatingDate'] = ' 创建于 ' . $v['creatingDate'];
//            $list['info'][$k]['desc'] = $v['desc'];
        }
        return $list;

    }



    /**
     *当启动项目时，创建process
     */
    public function createProcess($data){
        return $this->insert2($param=array('modelName'=>$this->processModel),$data);
    }

    /**
     * @param $data 要更新的数据
     * @param $condition 要更新的数据
     * @return array 返回执行结果
     */
    public function edit($data,$condition){
        return $this->update($param = array('modelName' => $this->processModel), $data, $condition);
    }

    /**
     * @param $condition 删除条件
     * @return array 返回执行结果
     */
    public function remove($condition){
        return $this->del($param=array('modelName'=>$this->processModel),$condition);
    }


    /**
     * @param $condition 查找条件
     * @return array 返回执行结果
     */
    public function findOne($condition){
        return $this->getDetailNoCache($param=array('modelName'=>$this->processModel),$condition);
    }



}