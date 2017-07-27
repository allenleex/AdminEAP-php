<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月4日
*/
namespace CoreBundle\Controller;

class IndexController extends Controller
{
    public function errorAction()
    {
        return parent::render();
    }
}