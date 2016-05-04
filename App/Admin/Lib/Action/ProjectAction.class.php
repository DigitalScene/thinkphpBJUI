<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/28
 * Time: 9:06
 */
class ProjectAction extends CommonAction{


    /**
     * 定义
     */
    protected $model;


    /**
     * 初始化
     */
    public function _initialize(){
       parent::_initialize();
        $this->model=D('Project');
    }

    /**
     * 列表
     */
    public function index(){

            $condition=$this->searchCondition();
            $condition['isDel']=0;//没有删除
            $list=$this->model->index($condition);
            $this->assign('search',$this->searchKeywords());
            $this->assign('tableFields',$this->model->tableFields);
            $this->assign('list',$list['info']);
            $this->assign('page',$list['page']);
            $this->display();

    }


    /**
     * 检测项目名
     */
    public function checkProjectName(){
        $M=M("Project");
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
     * 新增
     */
    public function add(){
        if(IS_POST){

            //创建数据对象
            $data=$this->model->create($_POST['info']);

            $data ? $this->ajaxReturn($this->model->add($data)) : $this->ajaxReturn(array('statusCode' => 300, 'message' => $this->model->getError()));
        }else{
            $this->display();
        }
    }


    /**
     * 编辑
     */
    public function edit(){
        if(IS_POST){
            $data=$this->model->create($_POST['info']);
            $data ? $this->ajaxReturn($this->model->edit($data)) : $this->ajaxReturn(array('statusCode' => 300, 'message' => $this->model->getError()));
        }else{
            // I('get.id');  相当于 $_GET['id']
            $condition="id=".I('get.id',0,'intval');
            $this->assign("info",$this->model->detail($condition));
            $this->display("add");
        }
    }

    /**
     * 移除
     */
    public function remove(){
        $condition="id=".I('get.id',0,'intval');
        $projectStatus="status=".I('get.status',0,'intval');
        if($projectStatus!="项目尚未启动"){
            //项目已经启动
            $processModel=D('Process');
            $conditionProcess="projectID=".I('get.id',0,'intval');
            $processModel->remove($conditionProcess);
        }
        $this->ajaxReturn($this->model->remove($condition));
    }

    /**
     * 启动项目
     */
    public function startUp(){
        $condition="id=".I('get.id',0,'intval');
        $condition.=' And isDel=0';//没有删除
        $project=$this->model->findOne($condition);
        $project['status']=1;
        $data=$this->model->create($project);
        //修改项目状态
        $data ? $this->model->edit($data) : $this->ajaxReturn(array('statusCode' => 300, 'message' => $this->model->getError()));

        //同时创建dataUpload
        $dataUploadModel=D('Dataupload');
        $dataupload['projectID']=$data['id'];
        $dataupload['projectName']=$data['name'];
        //创建对象
        $datauploadData= $dataUploadModel->create($dataupload);
        //插入数据到数据库中
        $dataUploadModel->createDataUpload($datauploadData);
        //注意'".$data['name']."'" 字符串查询需要''
        $dataUploadFindOne=$dataUploadModel->findOne("projectID=".$data['id']." And projectName='".$data['name']."'");


        //同时创建项目过程
        $processModel=D('Process');
        $process['projectID']=$data['id'];
        $process['projectName']=$data['name'];
        $process['dataUploadID']=$dataUploadFindOne['id'];
        $process['isFinishDataUpload']=0;
        $process['isFinishPhotoEdit']=0;
        $process['isFinishSphericalGraph']=0;
        $process['disceneMakingID']=null;
        $process['isFinishDisceneMaking']=0;
        $process['dataIntegrationID']=null;
        $process['isFinishDataIntegration']=0;
        $process['isDel']=0;//没有删除
        //创建对象
        $processData=$processModel->create($process);
        //插入数据到数据库中
        //返回执行结果
        $this->ajaxReturn($processModel->createProcess($processData));
    }

}