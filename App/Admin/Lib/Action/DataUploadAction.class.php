<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/5/2
 * Time: 22:14
 */
class DataUploadAction extends CommonAction{

    protected $model;

    /**
     * 初始化
     */
    public function _initialize(){
        parent::_initialize();
        $this->model=D('Dataupload');

    }

    public function index(){
//        $conditionProcess="id=".I('get.processId',0,'intval');
//        $processModel=D('Process');
//        $process=$processModel->findOne($conditionProcess);

        $conditionDataUpload="id=".I('get.uploadId',0,'intval');
        $dataUpload= $this->model->findOne($conditionDataUpload);

        $disceneModel=D('Discene');
        $condition['dataUploadID']=I('get.uploadId',0,'intval');
        $condition['isDel']=0;//没有删除
        $list=$disceneModel->index($condition);

//        $this->assign("process",$process);
        $this->assign("dataUpload",$dataUpload);
        $this->assign("tableFields",$disceneModel->tableFields);
        $this->assign("list",$list['info']);
        $this->display();
    }


    /**
     * 新增场景
     */
    public function add(){
        if(IS_POST){

            $dataUploadID=$_POST['info']['dataUploadID'];
            $processModel=D('Process');
            $process=$processModel->findOne("dataUploadID=".$dataUploadID);
            if($process['dataUploadStatus']!=1&&$process['dataUploadStatus']==0){
                $process['dataUploadStatus']=1;
                $processData=$processModel->create($process);
                $processModel->edit($processData,"dataUploadID=".$dataUploadID);
            }

            $disceneModel=D('Discene');
            //创建数据对象
            $data=$disceneModel->create($_POST['info']);

            $data ? $this->ajaxReturn($disceneModel->add($data)) : $this->ajaxReturn(array('statusCode' => 300, 'message' => $this->model->getError()));
        }else{
            $info[dataUploadID]=I('get.dataUploadID',0,'intval');
            $this->assign("info",$info);
            $this->display();
        }
    }


    /**
     * 编辑
     */
    public function edit(){
        $disceneModel=D('Discene');
        if(IS_POST){
            $data=$disceneModel->create($_POST['info']);
            $data ? $this->ajaxReturn($disceneModel->edit($data)) : $this->ajaxReturn(array('statusCode' => 300, 'message' => $this->model->getError()));
        }else{
            // I('get.id');  相当于 $_GET['id']
            $condition="id=".I('get.id',0,'intval');
            $this->assign("info",$disceneModel->detail($condition));
            $this->display("add");
        }
    }

    /**
     * 移除
     */
    public function remove(){
        $disceneModel=D('Discene');
        $condition="id=".I('get.id',0,'intval');
        $this->ajaxReturn($disceneModel->remove($condition));
    }

    /**
     * 检测场景名
     */
    public function checkDisceneName(){
        $M=M("Discene");
        $where="name='".$_GET['name']."'";

        if(!empty($_GET['id'])){
            $where.=" And id !=".(int)$_GET['id'];
        }
        if($M->where($where)->count()>0){
            $this->ajaxReturn(array('statusCode'=>300,'message'=>"已经存在，请修改标题"));
        }else{
            $this->ajaxReturn(array('statusCode'=>200,'message'=>"可以使用"));
        }
    }


    /**
     * 上传图片
     */
    public function upload(){
        $this->display();
    }
}