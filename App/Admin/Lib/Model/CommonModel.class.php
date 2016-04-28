<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/23
 * Time: 11:31
 */
class CommonModel extends Model{

    /**
     * 左侧导航菜单
     */
    public function leftMenu(){
        //这里填写的是数据库的数据库表名
        $M=M("Leftmenu");
        $condition1['pid']=0;
        $condition1['status']=1;
        //这里得到菜单的头部菜单
        $list['level']=$M->field('id,level,name')->where($condition1)->order('oid ASC')->select();

        $condition['status']=1;

        foreach($list['level'] as $k=>$v){
            $condition['id']=array('neq',$v['id']);
            $condition['level']=$v['id'];
            //得到除了头部菜单的其他菜单内容
            $list['menu'][$k]=$M->where($condition)->order('oid ASC')->select();
        }
        return $list;
    }


}