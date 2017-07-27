<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月3日
*/
namespace ManageBundle\Controller;

use CoreBundle\Controller\Controller as BaseController;

class Controller extends BaseController
{
    public function indexAction()
    {
        return parent::render();
    }
    
    public function getTreeDataAction()
    {
        $nodes = array();
        $nodes[0]['text'] = "业务部";
        $nodes[0]['tags'] = "";
        $nodes[0]['id'] = "8a8a80f05cbef2d8015cbf15254c0002";
        $nodes[0]['parentId'] = "8a8a80f05cbef2d8015cbf15254c0001";
        $nodes[0]['levelCode'] = "100001";
        $nodes[0]['icon'] = "";
        $nodes[0]['nodes'] = "";
        $nodes[1]['text'] = "开发部";
        $nodes[1]['tags'] = "";
        $nodes[1]['id'] = "8a8a80f05cbef2d8015cbf15254c0003";
        $nodes[1]['parentId'] = "8a8a80f05cbef2d8015cbf15254c0001";
        $nodes[1]['levelCode'] = "100002";
        $nodes[1]['icon'] = "";
        $nodes[1]['nodes'] = "";
        $nodes[2]['text'] = "研发部";
        $nodes[2]['tags'] = "";
        $nodes[2]['id'] = "8a8a80f05cbef2d8015cbf15254c0004";
        $nodes[2]['parentId'] = "8a8a80f05cbef2d8015cbf15254c0001";
        $nodes[2]['levelCode'] = "100003";
        $nodes[2]['icon'] = "";
        $nodes[2]['nodes'] = "";
        
        
        $result = array();
        $result[0]['text'] = "08CMS";
        $result[0]['tags'] = "";
        $result[0]['id'] = "8a8a80f05cbef2d8015cbf15254c0001";
        $result[0]['parentId'] = 0;
        $result[0]['levelCode'] = "100000";
        $result[0]['icon'] = "";
        $result[0]['nodes'] = $nodes;
        
        return parent::success('操作成功', '', $result);
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must activate the check in your security firewall configuration.');
    }
}