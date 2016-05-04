<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/21
 * Time: 16:34
 */
class IndexAction extends CommonAction{

       public function Index(){
         $leftMenu=CommonModel::leftMenu();
          $p=new ProjectModel();
//           $condition=array('like','%'.''.'%');
//         $projects=$p->index($condition);
           $this->assign('level',$leftMenu['level']);
           $this->assign('leftMenu',$leftMenu['menu']);
//           $this->assign('projects',$projects);
         $this->display();
    }

}