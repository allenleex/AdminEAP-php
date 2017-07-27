<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月24日
*/
namespace ManageBundle\DB;

use CoreBundle\Services\AbstractServiceManager;

class Models extends AbstractServiceManager
{
    protected $stag, $filePath;
    
    public function _initialize()
    {
        //缓存标识,以数据库名称区别
        $this->stag = $this->get('core.common')->C('database_name')."_models";
        
        $this->filePath = $this->get('core.common')->getSiteRoot()."FileDB".DIRECTORY_SEPARATOR."config_models.yml";
    }

    /**
     * 添加
     * @param array $data
     * @return int id
     */
    public function add(array $data, \stdClass $info=null, $isValid=true)
    {
        if(isset($data['name'])&&!preg_match("/^[a-z_]+$/",$data['name']))
            throw new \LogicException('模型名称只能是英文字母');
    
        if(isset($data['service'])&&!preg_match("/^[a-z._]+$/",$data['service']))
            throw new \LogicException('服务名称只能是英文字母');
    
        $data['engine'] = isset($data['engine'])?$data['engine']:"MyISAM";
    
        if(isset($data['bundle'])&&$data['bundle'])
            $this->get('core.controller.command')->createService($data['bundle'], $data);
        return self::handleYmlData(parent::add($data, $info, $isValid));
    }
    
    /**
     * 添加
     * @param array $data
     * @return int id
     */
    public function add1(array $data, \stdClass $info=null)
    {
        $data['engine'] = isset($data['engine'])?$data['engine']:"MyISAM";
    
        if(isset($data['bundle'])&&$data['bundle'])
            $this->get('core.controller.command')->createService($data['bundle'], $data);
        return self::handleYmlData(parent::add($data, $info, false));
    }
    
    /**
     * 更新
     * @param int	$id		基于ID的更新条件
     * @param array $data	更新的参数
     * @return bool
     */
    public function update($id, array $data, $info=null, $isValid=true)
    {
    
        if(isset($data['name'])&&!preg_match("/^[a-z_]+$/",$data['name']))
            throw new \LogicException('模型名称只能是英文字母');
    
        if(isset($data['service'])&&!preg_match("/^[a-z._]+$/",$data['service']))
            throw new \LogicException('服务名称只能是英文字母');

        $result = self::handleYmlData(parent::update($id, $data, $info, $isValid));
    
        if(isset($data['name']))
        {
            if(isset($data['bundle'])&&$data['bundle'])
                $this->get('core.controller.command')->createService($data['bundle'], $data);
             
            if(isset($data['associated'])&&is_array($data['associated']))
            {
                foreach($data['associated'] as $item)
                {
                    $map = array();
                    $map['model_id'] = $item;
                    $map['name'] = $data['name'];
                    $count = $this->get('db.model_attribute')->count($map);
                     
                    if($count==0)
                    {
                        $map['title'] = $data['title']."id";
                        $map['type'] = 'numeric';
                         
                        $this->get('db.model_attribute')->add($map);
                         
                        $this->get('db.model_attribute')->createDbTable($item);
                    }
                }
            }
        }
         
        return $result;
    }
    
    public function handleYmlData($data)
    {
        $result = array();
        $map = array();
        $map['status'] = 1;
        $map['order'] = 'sort|asc,id|asc';
        $info = parent::findBy($map, null, 10000);

        if(isset($info['rows']))
        {
            foreach($info['rows'] as $item)
            {
                $result['id'][$item->getId()]['type'] = $item->getType();
                $result['id'][$item->getId()]['mode'] = $item->getMode();
                $result['id'][$item->getId()]['service'] = $item->getService();
                $result['id'][$item->getId()]['structure'] = $item->getStructure();
                $result['id'][$item->getId()]['identifier'] = $item->getIdentifier();
                $result['id'][$item->getId()]['attributeTable'] = $item->getAttributeTable();
    
                $result['name'][$item->getName()]['type'] = $item->getType();
                $result['name'][$item->getName()]['mode'] = $item->getMode();
                $result['name'][$item->getName()]['service'] = $item->getService();
                $result['name'][$item->getName()]['structure'] = $item->getStructure();
                $result['name'][$item->getName()]['identifier'] = $item->getIdentifier();
                $result['name'][$item->getName()]['attributeTable'] = $item->getAttributeTable();
    
                $result['identifier'][$item->getIdentifier()]['id'] = $item->getId();
            }
        }

        $this->get('core.ymlParser')->ymlWrite($result, $this->filePath);
    
        unset($info);
    
        //重置缓存
        $this->get('core.common')->S($this->stag, $result, 86400);
        
        unset($info);
        unset($result);
        return $data;
    }
    
    /**
     * 直接从文件中读取
     * @param array $criteria
     * @return multitype:
     */
    public function getData($str, $flag=null)
    {
        $info = $this->get('core.common')->S($this->stag);
    
        if(empty($info))
        {
            $info = $this->get('core.ymlParser')->ymlRead($this->filePath);
    
            $this->get('core.common')->S($this->stag, $info, 86400);
        }
        if(empty($info))
            return array();
    
        switch($flag)
        {
            case 'name':
                $info = isset($info['name'])?$info['name']:array();
                break;
            case 'identifier':
                $info = isset($info['identifier'])?$info['identifier']:array();
                break;
            default:
                $info = isset($info['id'])?$info['id']:array();
                break;
        }
    
        return isset($info[$str])?$info[$str]:array();
    }
}