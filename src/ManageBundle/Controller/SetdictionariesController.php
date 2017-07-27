<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月21日
*/
namespace ManageBundle\Controller;

/**
 * 字典管理
 * @author Administrator
 *
 */
class SetdictionariesController extends Controller
{
    public function listAction()
    {
        $map = array();
        $map['pageIndex'] = (int)$this->get('request')->get('pageIndex',1);
        $map['pageSize'] = (int)$this->get('request')->get('pageSize',10);
        $map['order'] = $this->get('request')->get('order','');
    
        $result = $this->get('db.users')->findBy($map);
        $result['columnList'] = self::getColumnList();
        return parent::success('操作成功', '', $result);
    }
}