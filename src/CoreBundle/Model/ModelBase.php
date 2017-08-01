<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年4月5日
*/
namespace CoreBundle\Model;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ModelBase extends EntityRepository
{
    protected $_qb;
    protected $container;
    protected $pageIndex= 1;
    protected $pageSize = 8;
    protected $pageSkip = 1;
    protected $orderBy	= 'ASC';
    protected $useCache = true;
    protected $hydrationMode = 1;
    protected $groups = array();
    protected $order = array('id'=>'ASC');
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
 
        $this->_em = $this->get('doctrine')->getManager($this->get('core.common')->getDefaultEntity());
        
        $this->_entityName = $this->get('core.common')->getUserBundle().":".ucfirst(self::get_class_name());
        
        parent::__construct($this->_em, self::getClass());
        
        //初始化方法
        if(method_exists($this,'_initialize'))
            $this->_initialize();
    }
    
    public function getObjectManager()
    {
        return $this->_em;
    }
    
    /**
     * 运算符处理
     * @param array $params
     * @param QueryBuilder $query
     * @param string $aliasName
     * @param string $param
     * @param number $flag
     */
    public function formulaFun(array $info, $aliasName=null, &$param=null, $flag=1, $table=null)
    {
        $aliasName = $aliasName?$aliasName.".":"";

        foreach ($info as $key => $item)
        {
            $key = explode('.', $key);
            $endk = end($key);
            
            $key = count($key)>1?implode('.', $key):$aliasName . end($key);

            $_endk = lcfirst(\Doctrine\Common\Util\Inflector::classify($endk));

            if ($this->_class->hasField($_endk) || $this->_class->hasAssociation($_endk)||$this->_class->hasField($endk) || $this->_class->hasAssociation($endk))
            {
                if(is_array($item))
                    $param = self::formulaFunArray($key, $item, $flag, $aliasName);
                else
                    $param = self::formulaFunString($key, $item, $flag, $aliasName);
            }
        }
        
        
        //过淲假删除数据
        if ($this->_class->hasField('is_delete') || $this->_class->hasAssociation('is_delete'))
        {
            if($flag==1)
                $this->_qb->andWhere($aliasName.'is_delete = 0');
            else
                $param .= ($param?" AND ":"").$aliasName."is_delete=0";
        }
        return true;
    }
    
    protected function formulaFunArray($key, array $item, $flag, $aliasName)
    {
        $param = "";

        $anXattr = array('andX'=>'AND', 'orX'=>'OR');
        foreach($item as $kk=>$vv)
        {
            $kk = trim($kk);
            $isNumeric = false;
            if(!is_array($vv)&&!is_numeric($vv))
            {
                if($vv==='_null')
                    $kk = 'isNull';
            }

            switch(trim($kk))
            {
                case 'in':
                case 'notIn':
                    if($flag==1)
                        $this->_qb->andWhere($this->_qb->expr()->$kk($key, is_array($vv)?$vv:explode(',',$vv)));
                    else
                        $param .= ($param?" AND ":"").$this->_qb->expr()->$kk($key, is_array($vv)?$vv:explode(',',$vv));
                    break;
                case 'andX':
                case 'orX':
                    $sql = "";
                    foreach($vv as $vitem)
                    {
                        if(!is_array($vitem))
                            continue;
                        foreach($vitem as $ki=>$vi)
                        {
                            $kkey = 'eq';
                            if(is_array($vi))
                            {
                                $kkey = key($vi);
                                $vi = end($vi);
                            }

                            $ki = explode('.', $ki);
                            $iik = end($ki);
                            $endk = lcfirst(\Doctrine\Common\Util\Inflector::classify($iik));
                            
                            if ($this->_class->hasField($iik) || $this->_class->hasAssociation($iik)||$this->_class->hasField($endk) || $this->_class->hasAssociation($endk))
                            {
                                $ki = count($ki)>1?implode('.', $ki):$aliasName . end($ki);
                                $sql .= ($sql?" ".$anXattr[$kk]." ":"").$this->_qb->expr()->$kkey($ki, is_array($vi)?$vi:(is_numeric($vi)?$vi:"'".$vi."'"));
                            }
                        }
                    }

                    if(empty($sql))
                        continue;

                    if($flag==1)
                        $this->_qb->andWhere($sql);
                    else
                        $param .= ($param?" AND ":"")."({$sql})";

                    break;
                case 'isNull':
                    if($flag==1)
                        $this->_qb->andWhere($this->_qb->expr()->$kk($key));
                    else
                        $param .= ($param?" AND ":"").$this->_qb->expr()->$kk($key);
                    break;
                case 'find':
                    $sql = " FIND_IN_SET({$vv}, {$key})>0";

                    if($flag==1)
                        $this->_qb->andWhere($sql);
                    else
                        $param .= ($param?" AND ":"").$sql;

                    break;
                default:
                    if($flag==1)
                        $this->_qb->andWhere($this->_qb->expr()->$kk($key, is_array($vv)?$vv:(is_numeric($vv)||$isNumeric?$vv:"'".$vv."'")));
                    else
                        $param .= ($param?" AND ":"").$this->_qb->expr()->$kk($key, is_numeric($vv)||$isNumeric?$vv:"'".$vv."'");
                    break;
            }
        }
        
        return $param;
    }
    
    protected function formulaFunString($key, $item, $flag, $aliasName)
    {
        $param = "";

        if($item==='_null')
        {
            if($flag==1)
                $this->_qb->andWhere($this->_qb->expr()->isNull($key));
            else
                $param .= ($param?" AND ":"").$this->_qb->expr()->isNull($key);
        }else{
            if($flag==1)
                $this->_qb->andWhere($this->_qb->expr()->eq($key, is_numeric($item)?$item:"'".$item."'"));
            else
                $param .= ($param?" AND ":"").$this->_qb->expr()->eq($key, is_numeric($item)?$item:"'".$item."'");
        }
        return $param;
    }
    
    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $_multi = isset($criteria['_multi'])?$criteria['_multi']:true;
         
        unset($criteria['_multi']);
        
        $orderBy = isset($criteria['orderBy'])?$criteria['orderBy']:$orderBy;
        
        //排序
        if(is_array($orderBy))
        {
            $order = "";
            foreach($orderBy as $fieldName => $orientation)
            {
                $_fieldName = lcfirst(\Doctrine\Common\Util\Inflector::classify($fieldName));                
                if ($this->_class->hasField($fieldName) || $this->_class->hasAssociation($fieldName)||$this->_class->hasField($_fieldName) || $this->_class->hasAssociation($_fieldName))
                    $order .= ($order?",":"").$fieldName."|".$orientation;
            }
        
            $criteria['order'] = isset($criteria['order'])&&$criteria['order']?",":"".$order;            
        }
        
        $criteria['pageSize']  = isset($criteria['pageSize'])?$criteria['pageSize']:$limit;
        $criteria['pageIndex'] = isset($criteria['pageIndex'])?$criteria['pageIndex']:$offset;
        $criteria['groupBy'] = isset($criteria['groupBy'])?$criteria['groupBy']:null;

        //区域查询
        $areasub = $this->get('request')->getSession()->get('areasub');
        if($areasub && !isset($criteria['area']))
            $criteria['area']['in'] = implode(',', $areasub);
        
        $this->mapRequest($criteria);
        $this->_qb = parent::createQueryBuilder('p');
        
        $this->formulaFun($criteria, 'p');

        return self::getResult('p', $_multi);
    }
    
    /**
     * SQL参数
     * @param array $params
     */
    protected function mapRequest(array &$params)
    {
        //true为数组结果集，false为对象结果集
        if(isset($params['findType'])&&(bool)$params['findType']==true)
            $this->hydrationMode = 2;
    
        if(isset($params['useCache'])&&(bool)$params['useCache']==false)
            $this->useCache = false;
    
        //分页参数
        $this->pageIndex = isset($params['pageIndex'])?(int)$params['pageIndex']:$this->pageIndex;
        $this->pageSize = isset($params['pageSize'])?(int)$params['pageSize']:$this->pageSize;

        // Order By
        if (isset($params['orderBy']))
        {
            switch (strtoupper($params['orderBy']))
            {
                case 'ASC':
                    $this->orderBy = 'ASC';
                    break;
                case 'DESC':
                    $this->orderBy = 'DESC';
                    break;
            }
        }
        
        // group By
        if (isset($params['groupBy'])&&$params['groupBy'])
        {    
            $groups = explode(',', $params['groupBy']);
    
            $this->groups = array();
    
            foreach($groups as $group)
            {
                $groupField = explode('.',$group);
                $_groupField = lcfirst(\Doctrine\Common\Util\Inflector::classify(end($groupField)));
                
                if ($this->_class->hasField($groupField) || $this->_class->hasAssociation($groupField)||$this->_class->hasField($_groupField) || $this->_class->hasAssociation($_groupField))
                    $this->groups[] = $group;
            }
            
            unset($groups);
            unset($groupField);
        }
    
        // Order
        if(isset($params['order'])&&$params['order'])
        {    
            $orders = explode(',', $params['order']);
    
            if(end($orders)==$params['order'])
                $orders = explode(' and ', $params['order']);
    
            $this->order = array();
            
            foreach($orders as $order)
            {
                $order = preg_split("/[\s|]+/", $order);
    
                $orderField = explode('.',$order[0]);
                
                $_orderField = lcfirst(\Doctrine\Common\Util\Inflector::classify(end($orderField)));

                if ($this->_class->hasField(end($orderField)) || $this->_class->hasAssociation(end($orderField))||$this->_class->hasField($_orderField) || $this->_class->hasAssociation($_orderField))
                {
                    if(count($order)>=2)
                        $this->order[$order[0]] = $order[1];
                    else
                        $this->order[$order[0]] = $this->orderBy;
                }
            }
            
            unset($order);
            unset($orders);
            unset($orderField);
        }
    
        $this->pageSkip = ($this->pageIndex - 1) * $this->pageSize;
    
        unset($params['order']);
        unset($params['orderBy']);
        unset($params['groupBy']);
        unset($params['findType']);
        unset($params['useCache']);
        unset($params['pageSize']);
        unset($params['pageIndex']);
    }
    
    protected function getResult($aliasName='p',$multi=true)
    {    
        //排序
        foreach($this->order as $k=>$v)
        {
            $fieldName = lcfirst(\Doctrine\Common\Util\Inflector::classify($k));
            
            if ($this->_class->hasField($k) || $this->_class->hasAssociation($k)||$this->_class->hasField($fieldName) || $this->_class->hasAssociation($fieldName))
                $this->_qb->addOrderBy($aliasName.'.'.$k, $v);
        }
    
        //分组
        foreach($this->groups as $groupName)
        {
            $fieldName = lcfirst(\Doctrine\Common\Util\Inflector::classify($groupName));
            
            if ($this->_class->hasField($k) || $this->_class->hasAssociation($k)||$this->_class->hasField($fieldName) || $this->_class->hasAssociation($fieldName))
                $this->_qb->addGroupBy($aliasName.'.'.$groupName);
        }
    
        //分页
        $this->_qb->setFirstResult($this->pageSkip)->setMaxResults($this->pageSize);
    
        //计算总条数
         
        if($multi)
            $paginator = new Paginator($this->_qb, false);
    
        $em = $this->_qb->getQuery();
    
        //判断是否启用缓存
        if($this->useCache)
        {
            $em->useQueryCache(true);
            $em->useResultCache(true, 1200);
        }
    
        //获得查询结果集
        $result = array();
         
        $result['pageSize'] = $this->pageSize;
        $result['pageIndex'] = $this->pageIndex;
        $result['rows'] = $em->getResult($this->hydrationMode);
         
        //计算总数
        $result['pageCount'] = $multi?$paginator->count():count($result['rows']);

        krsort($result);

        //返回结果集
        return $result;
    }
    
    /**
     * 获取某个父节点以及其所有子节点
     * @param int $id
     * @param array $params
     */
    public function getBinaryTreeSub($id=0, $params=array(), $orderBy=array())
    {
        
        if($id<=0)
        {
            $info = self::findBy($params, $orderBy);

            if(empty($info))
                return array();
            $tmp = array();

            return $this->get('core.common')->getTree($info,$id, $tmp);
        }
        
        $result = array();
        $info = self::findOneBy(array_merge(array('id'=>$id), $params));
        
        if(!is_object($info))
            return array();
        
        $map = array();
        $map['leftnode']['gte'] = $info->getLeftNode();
        $map['rightnode']['lte'] = $info->getRightNode();
        
        //if(!isset($params['_multinode']))
        //    $map['rightnode']['diffX']['leftnode'] = 1;

        unset($params['_multinode']);
        
        $result['rows'] = self::findBy(array_merge($map, $params));
        
        $result['pageCount'] = count($result['data']);
        
        krsort($result);
        
        return $result;
    }
    
    /**
     * 数量统计
     * @param array $criteria
     * @param string $groupBy
     */
    public function count(array $criteria, $groupBy=null)
    {
        //获取表结构
        $metadata = $this->getClass();
    
        $this->_qb = parent::createQueryBuilder('p');
    
        self::formulaFun($criteria, 'p');
    
        if(is_array($groupBy))
        {
            foreach($groupBy as $groupName)
            {
                $this->_qb->addGroupBy('p.'.$groupName);
            }
        }
    
        if(is_string($groupBy)&&isset($metadata->fieldNames[$groupName]))
            $this->_qb->addGroupBy('p.'.$groupName);
    
        //计算总数
        $paginator = new Paginator($this->_qb, false);
    
        return $paginator->count();
    }
    
    /**
     * 获得元数据
     * @param string $class
     * @return object
     */
    final public function getClass($class=null)
    {
        return $this->_em->getClassMetadata($class?$class:$this->_entityName);
    }
    
    /**
     * 获取类名
     * @param string $classname
     * @return string|unknown
     */
    public function get_class_name($classname=null)
    {
        $classname = is_string($classname)?$classname:get_class($this);

        $pos = strrpos($classname, '\\');
    
        return $pos?ucfirst(substr($classname, $pos + 1)):'';
    }    
    
    
    /**
     * 获得服务
     * @param string $id
     * @throws \InvalidArgumentException
     */
    protected function get($id)
    {
        /**
         * 兼容3.0之前的版本request服务
         */
        if($id=='request')
            return $this->container->get('request_stack')->getCurrentRequest();
    
        if (!$this->container->has($id))
            throw new \InvalidArgumentException("[".$id."]服务未注册。");
    
        return $this->container->get($id);
    }
}