<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月21日
*/
namespace ManageBundle\Controller;

class SetgroupController extends Controller
{
    public function getgroupAction()
    {
        //$map = array();
        //$map['id'] = (int)$this->get('request')->get('id',0);
        
        //$result = $this->get('db.users')->finOnedBy($map);
        $result = array();
        $result['id'] = "8a8a80f05cbef2d8015cbf15254c0001";
        $result['name'] = "业务部";
        $result['code'] = "Company";        
        $result['parentId'] = "";
        $result['levelCode'] = "100000";
        $result['orgType'] = "";
        $result['remark'] = "";
        $result['parentName'] = "组织机构维护";
        $result['createDateTime'] = 1497854453;
        $result['updateDateTime'] = 1497854453;
        return parent::success('操作成功', '', $result);
    }
}