<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月20日
*/
namespace CoreBundle\Services;

use CoreBundle\Model\ModelBase;

abstract class AbstractServiceManager extends ModelBase
{
    public function add(array $data, \stdClass $info=null, $isValid=true)
    {    
        //初始化元数据
        if(!is_object($info))
        {
            $info = self::getMetadata();

            $this->get('core.common')->handleMetadata($info, $data);
        }
    
        //嵌入创建时间
        if(method_exists($info->entity, 'getCreateTime'))
            $info->entity->setCreateTime(time());
    
        //嵌入修改时间
        if(method_exists($info->entity, 'getUpdateTime'))
            $info->entity->setUpdateTime(time());
    
        //嵌入状态
        if(method_exists($info->entity, 'getStatus'))
            $info->entity->setStatus(1);
    
        //注入区域字段
        if(is_array($info->column) && isset($info->column['area']) && !isset($data['area'])){
            $info->entity->setArea($this->get('request')->getSession()->get('area',0));
        }
    
        //嵌入唯一标识
        if(method_exists($info->entity, 'getIdentifier'))
            $info->entity->setIdentifier($this->get('core.common')->createIdentifier());
         
        //写库
        self::getObjectManager()->clear();        
        self::getObjectManager()->persist($info->entity);
        self::getObjectManager()->flush();
        self::getObjectManager()->clear();
    
        return $info->entity;
    }
    
    /**
     * 更新
     * @param int	$id		基于ID的更新条件
     * @param array $data	更新的参数
     * @return bool
     */
    public function update($id, array $data, $info=null, $isValid=true)
    {
        //复制表单
        $_copy = (int)$this->get('request')->get('_copy',0);
    
        if($_copy==1)
            return self::add($data, $info=null, $isValid=true);
        
        //获得原数据
        if(!is_object($info))
            $info = self::findOneBy(array('id'=>$id));
        
        //系统类数据必须为启用
        if(method_exists($info, 'getIssystem')&&$info->getIssystem()==1)
            $data['available'] = 1;

        $this->get('core.common')->handleMetadata($info, $data, self::getMetadata(true));

        //嵌入修改时间
        if(method_exists($info, 'getUpdateTime'))
            $info->setUpdateTime(time());
    
        if(method_exists($info, 'setAttributes'))
            $info->setAttributes('');
        
        self::getObjectManager()->clear();
        self::getObjectManager()->merge($info);
        self::getObjectManager()->flush();
        self::getObjectManager()->clear();

        return $info;
    }
    
    public function retCache()
    {
        return true;
    }
    
    /**
     * 处理查询条件(基于权限)
     * @param array $map
     */
    protected function _handleMap(array &$map)
    {
        $user = $this->get('core.common')->getUser();
    
        $mid = method_exists($user, 'getMid')?(int)$user->getMid():0;
    
        if($mid==1)
            return true;
    
        $token = $this->get('security.token_storage')->getToken();
    
        if(!is_object($token))
            return true;
    
        $attributes = $token->getAttributes();
    
        //$menus = isset($attributes['menus'])?$attributes['menus']:$this->get('core.rbac')->getMenuNodes($user->getRules());
        $menus = isset($attributes['menus'])?$attributes['menus']:array();
    
        if($menus)
            $map['id']['in'] = array_keys($menus);
    
        $map['_multi'] = false;
    
        //默认Bundle
        $bundle = $this->get('core.common')->getBundleName();
        $map['bundle'] = strtolower(substr($bundle,0,-6));
    
        return true;
    }
    
    /**
     * 获取表结构
     * @param string $tableClass
     * @param string $flag
     */
    public function getMetadata($flag=false)
    {
        //定义对像类型数据
        $metadata = new \stdClass();
    
        //取表Metadata
        $classMetadata = parent::getClassMetadata();
    
        if($flag)
            return $classMetadata;
    
        $identifier  = $classMetadata->getIdentifier();
        $columnNames = $classMetadata->columnNames;
    
        //去主键，自增长型主键不能直接赋值
        foreach($identifier as $v)
        {
            unset($columnNames[$v]);
        }
    
        $metadata->identifier = $classMetadata->getIdentifier();
        $metadata->column     = $columnNames;
        $metadata->entity     = new $classMetadata->name;
        $metadata->reflFields = $classMetadata->reflFields;
        $metadata->fieldMapps = $classMetadata->fieldMappings;
        $metadata->tablename  = $classMetadata->table['name'];
    
        return $metadata;
    }
}