<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月20日
*/
namespace ManageBundle\Controller;

class QueryController extends Controller
{
    public function loadDataAction()
    {
        return $this->sussess('查询成功');
    }
}