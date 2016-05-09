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
        //获取场景名id
        $disceneId=I('get.id',0,'intval');
        session('disceneId',$disceneId);
        $this->display();
    }

    /**
     * 已经上传完毕，接受数据
     */
    public function finishupload(){

        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires:Mon,26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: ".gmdate("D,d M Y H:i:s")." GMT");
        header("Cache-Control:no-store,no-cache,must-revalidate");
        header("Cache-Control:post-check=0,pre-check=0",false);
        header("Pragma:no-cache");

        // Support CORS
        // header("Access-Control-Allow-Origin: *");
        // other CORS headers if any...
        if($_SERVER['REQUEST_METHOD']=='OPTIONS'){
            exit();//finish preflight CORS requests here
        }


        if(!empty($_REQUEST['debug'])){
            $random=rand(0,intval($_REQUEST['debug']));
            if($random===0){
                header("HTTP/1.0 500 Internal Server Error");
                exit();
            }
        }


        //5 minutes execution time
        @set_time_limit(5 * 60);


        //Settings
        $targetDir='Uploads/Uploads_tmp';
        $uploadDir='Uploads/Uploads';

        $cleanupTargetDir=true;//Remove old files
        $maxFileAge=5 * 3600;//Temp file age in seconds

        //create target dir
        if(!file_exists($targetDir)){
//            @makedir($targetDir);

            mkdir ( $targetDir,0777 ,true);
        }

        //create uploadDir
        if(!file_exists($uploadDir)){
//            @makedir($uploadDir);
            mkdir ( $uploadDir,0777 ,true );
        }

        //Get a file name
        if(isset($_REQUEST["name"])){
            $fileName=$_REQUEST["name"];
        }elseif(!empty($_FILES)){
            $fileName=$_FILES["file"]["name"];
        }else{
            $fileName=uniqid("file_");
        }

        $fileName=iconv('UTF-8','GB2312',$fileName);//编码

        $filePath=$targetDir.DIRECTORY_SEPARATOR.$fileName;


        //Chunking might be enabled
        $chunk=isset($_REQUEST["chunk"])?intval($_REQUEST["chunk"]):0;
        $chunks=isset($_REQUEST["chunks"])?intval($_REQUEST["chunks"]):1;

//        if(!is_dir($targetDir)){
//            echo is_dir($targetDir)."hello";
//            exit();
//        }else{
//            echo is_dir($targetDir)."为目录";
//            exit();
//        }


        //Remove old temp files
        if($cleanupTargetDir){
            if(!is_dir($targetDir) || !$dir=opendir($targetDir) ){
                die('{"jsonrpc" : "2.0", "error" : {"code":100,"message":"Failed to open temp directory."},"id" : "id"}');
            }

            while(($file=readdir($dir))!=false){
                $tmpfilePath=$targetDir.DIRECTORY_SEPARATOR.$file;

                //If temp file is current file proceed to the next;
                if($tmpfilePath=="{$filePath}_{$chunk}.part"|| $tmpfilePath=="{$filePath}_{$chunk}.parttmp"){
                   continue;
                }

                //Remove temp file if it is older than the max age and is not the current file
                if(preg_match('/\.(part|parttmp)$/',$file) && (@filemtime($tmpfilePath)<time()-$maxFileAge)){
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        //open temp file
        if(!$out=@fopen("{$filePath}_{$chunk}.parttmp","wb")){
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }


        if(!empty($_FILES)){
            if($_FILES["file"]["error"]|| !is_uploaded_file($_FILES["file"]["tmp_name"])){
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if(!$in=@fopen($_FILES["file"]["tmp_name"],"rb")){
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }else{
            if(!$in=@fopen("php://input", "rb")){
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while($buff=fread($in,4096)){
            fwrite($out,$buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp","{$filePath}_{$chunk}.part");

        $index=0;
        $done=true;
        for($index=0;$index<$chunks;$index++){
            if(!file_exists("{$filePath}_{$index}.part")){
                $done=false;
                break;
            }
        }

        //把数据放进真正的目录即uploads/uploads下
        //DIRECTORY_SEPARATOR 目录分隔符 '/'
        $disceneId=session("disceneId");
        //日期目录
        import('ORG.Util.Date');
        $date=date("Y-m-d");
        //随机数和字母目录
        $str='1234567890abcdefghijklmnopqrstuvwxyz';
        $t1=$str[rand(0,35)].$str[rand(0,35)].$str[rand(0,35)].$str[rand(0,35)].$str[rand(0,35)].$str[rand(0,35)];

        $uploadPath=$uploadDir.DIRECTORY_SEPARATOR.$disceneId.DIRECTORY_SEPARATOR.$date.DIRECTORY_SEPARATOR.$t1;
        if(!file_exists($uploadPath)){
//            @makedir($uploadDir);
            mkdir ( $uploadPath,0777 ,true );
        }

        $picsrc=$uploadPath.DIRECTORY_SEPARATOR.$fileName;

        if($done){
            if(!$out=@fopen($picsrc,"wb")){
                die('{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if(flock($out,LOCK_EX)){
                for($index=0;$index<$chunks;$index++){
                    if(!$in=@fopen("{$filePath}_{$index}.part","rb")){
                        break;
                    }
                    while($buff=fread($in,4096)){
                        fwrite($out,$buff);
                    }
                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }
                flock($out, LOCK_UN);
            }

            $pictureModel=D('Picture');
            $pic['picsrc']=$picsrc;
            $pic['disceneID']=$disceneId;
            $pic['level']=0;
            $dataPic=$pictureModel->create($pic);
            $pictureModel->addPicture($dataPic);

            @fclose($out);
        }

        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

    /**
     * 预览图片
     */
    public function lookup(){
        //获取场景名id
        $where="disceneID=".I('get.id',0,'intval');
        $pictureModel=D('Picture');
        $list=$pictureModel->findAllByDisceneId($where);
        $this->assign("list",$list);
        $this->display();
    }

    /**
     * 图片下载
     */
    public function download(){
        if(IS_POST){
            $pan=$_POST['pan'];
            $fileDir=$pan.$_POST['path'];

            if(!file_exists($fileDir)){
                mkdir ( $fileDir,0777 ,true);
            }

            $pictures=$_POST['pictures'];
            for($i=0;$i<count($pictures);$i++){
                if($pictures[$i]=="") return false;

                ob_start();
                readfile($pictures[$i]);
                $img=ob_get_contents();
                ob_end_clean();
                $size=strlen($img);

                $str='1234567890abcdefghijklmnopqrstuvwxyz';
                $t1=$str[rand(0,35)].$str[rand(0,35)].$str[rand(0,35)].$str[rand(0,35)].$str[rand(0,35)].$str[rand(0,35)];


                $ext=strrchr($pictures[$i],"\\");
//                echo $ext;exit();
//                $ext=strtolower($ext);
//                if($ext!=".gif" && $ext!=".jpg" && $ext!=".png" && $ext!="jpeg") return false;

                $fp2=@fopen($fileDir.DIRECTORY_SEPARATOR.$ext,"a");
                fwrite($fp2,$img);
            }
            $this->ajaxReturn( array('statusCode' => 200, 'message' => C('ALERT_MSG.EXECUTE_SUCCESS'), 'closeCurrent' => true, 'url' =>''));
        }else{
            //获取场景名id
            $where="disceneID=".I('get.id',0,'intval');
            $pictureModel=D('Picture');
            $list=$pictureModel->findAllByDisceneId($where);
            $this->assign("list",$list);
            $this->display();
        }

    }
}