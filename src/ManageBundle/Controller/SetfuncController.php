<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月21日
*/
namespace ManageBundle\Controller;

class SetfuncController extends Controller
{
    public function getTreeDataAction()
    {
        $nodes0 = array();
        $nodes0[0]['text'] = "我的待办a";
        $nodes0[0]['tags'] = "";
        $nodes0[0]['id'] = "8a8a80f05cbef2d8015cbf15254c0002";
        $nodes0[0]['parentId'] = "8a8a80f05cbef2d8015cbf15254c0001";
        $nodes0[0]['levelCode'] = "1000010001";
        $nodes0[0]['nodes'] = "";
        $nodes0[0]['icon'] = "fa fa-calendar-check-o";
        
        $nodes1 = array();
        $nodes1[0]['text'] = "用户列表-Dailog";
        $nodes1[0]['tags'] = "";
        $nodes1[0]['id'] = "8a8a80f05cbef2d8015cbf15254c0004";
        $nodes1[0]['parentId'] = "8a8a80f05cbef2d8015cbf15254c0003";
        $nodes1[0]['levelCode'] = "1000020001";
        $nodes1[0]['nodes'] = "";
        $nodes1[0]['icon'] = "fa fa-calendar-check-o";
        $nodes1[1]['text'] = "用户列表-Tab";
        $nodes1[1]['tags'] = "";
        $nodes1[1]['id'] = "8a8a80f05cbef2d8015cbf15254c0005";
        $nodes1[1]['parentId'] = "8a8a80f05cbef2d8015cbf15254c0003";
        $nodes1[1]['levelCode'] = "1000020002";
        $nodes1[1]['nodes'] = "";
        $nodes1[1]['icon'] = "fa fa-calendar-check-o";        
        $nodes1[2]['text'] = "用户列表-Page";
        $nodes1[2]['tags'] = "";
        $nodes1[2]['id'] = "8a8a80f05cbef2d8015cbf15254c0006";
        $nodes1[2]['parentId'] = "8a8a80f05cbef2d8015cbf15254c0003";
        $nodes1[2]['levelCode'] = "1000020003";
        $nodes1[2]['nodes'] = "";
        $nodes1[2]['icon'] = "fa fa-calendar-check-o";
        
        
        $nodes = array();
        $nodes[0]['text'] = "我的待办";
        $nodes[0]['tags'] = "";
        $nodes[0]['id'] = "8a8a80f05cbef2d8015cbf15254c0001";
        $nodes[0]['parentId'] = "";
        $nodes[0]['levelCode'] = "100001";
        $nodes[0]['nodes'] = $nodes0;
        $nodes[0]['icon'] =	"fa fa-calendar-check-o";
        
        $nodes[1]['text'] = "CURD DEMO";
        $nodes[1]['tags'] = "";
        $nodes[1]['id'] = "8a8a80f05cbef2d8015cbf15254c0003";
        $nodes[1]['parentId'] = "";
        $nodes[1]['levelCode'] = "100002";
        $nodes[1]['nodes'] = $nodes1;
        $nodes[1]['icon'] =	"fa fa-calendar-check-o";
        
        $nodes[2]['text'] = "组件使用说明";
        $nodes[2]['tags'] = "";
        $nodes[2]['id'] = "8a8a80f05cbef2d8015cbf15254c0007";
        $nodes[2]['parentId'] = "";
        $nodes[2]['levelCode'] = "100003";
        $nodes[2]['nodes'] = $nodes1;
        $nodes[2]['icon'] =	"fa fa-calendar-check-o";

    
        return parent::success('操作成功', '', $nodes);
    }
    
    public function getgroupAction()
    {
        //$map = array();
        //$map['id'] = (int)$this->get('request')->get('id',0);
    
        //$result = $this->get('db.users')->finOnedBy($map);
        $result = array();
        $result['id'] = "8a8a80f05cbef2d8015cbf15254c0001";
        $result['name'] = "我的待办";
        $result['code'] = "TODO";
        $result['url'] = "";
        $result['parentId'] = "";
        $result['levelCode'] = "100000";
        $result['icon'] = "fa fa-calendar-check-o";
        $result['functype'] = 0;
        $result['remark'] = "";
        $result['parentName'] = "系统菜单";
        $result['fflist'] = "";
        $result['roleId'] = "";
        $result['createDateTime'] = 1470899213;
        $result['updateDateTime'] = 1470899213;
        return parent::success('操作成功', '', $result);
    }
}