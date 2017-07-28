<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月12日
*/
namespace ManageBundle\Controller;

class SetmenusController extends Controller
{
    public function saveAction()
    {
        if($this->get('request')->getMethod() == "POST")
        {
            $id = (int)$this->get('request')->get('id');
    
            $data = $this->get('request')->request->all();
    
            unset($data['csrf_token']);
    
            if($id>0)
                $this->get('db.menus')->update($id, $data);
            else
                $this->get('db.menus')->add($data);
    
            return parent::success('操作成功');
        }
    
        return parent::error('操作失败');
    }

    public function getTreeDataAction()
    {
        $map = array();
        $result = $this->get('db.menus')->findBy($map, null, 300);

        $result = $this->get('core.common')->getTree(isset($result['rows'])?$result['rows']:array());

        return parent::success('操作成功', '', json_decode(json_encode($result),true));
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
    
//         $nodes[1]['text'] = "CURD DEMO";
//         $nodes[1]['tags'] = "";
//         $nodes[1]['id'] = "8a8a80f05cbef2d8015cbf15254c0003";
//         $nodes[1]['parentId'] = "";
//         $nodes[1]['levelCode'] = "100002";
//         $nodes[1]['nodes'] = $nodes1;
//         $nodes[1]['icon'] =	"fa fa-calendar-check-o";
    
//         $nodes[2]['text'] = "组件使用说明";
//         $nodes[2]['tags'] = "";
//         $nodes[2]['id'] = "8a8a80f05cbef2d8015cbf15254c0007";
//         $nodes[2]['parentId'] = "";
//         $nodes[2]['levelCode'] = "100003";
//         $nodes[2]['nodes'] = $nodes1;
//         $nodes[2]['icon'] =	"fa fa-calendar-check-o";
    
    
        return parent::success('操作成功', '', $nodes);
    }
    
    public function getinfoAction()
    {    
        $result = $this->get('db.menus')->findOneById((int)$this->get('request')->get('id',0));

        return parent::success('操作成功', '', $this->get('serializer')->normalize($result));
    }
    
    public function checkAction()
    {
        return parent::success('成功');
    }
}