<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月3日
*/
namespace CoreBundle\Functions;

use CoreBundle\Services\ServiceBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Common extends ServiceBase
{
    /**
     * 容器
     * @var object
     */
    protected $container;
    
    /**
     * 表前缀
     * @var string
     */
    protected $prefix;
    
    /**
     * 默认bundle
     */
    protected $bundle;
    
    /**
     * 加密串
     */
    protected $encodekey = 'n7eaojb';
    
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->prefix = "cms_";
    }
    
    /**
     * 获取用户所属数据库
     * @return string
     */
    public function getDefaultEntity()
    {
        //取默认参数
        $defaultEntityManager = lcfirst(self::ucWords(self::C('doctrine.default_entity_manager')));
    
        $multidb = (int)self::C('multidb');
    
        //不启用多库
        if($multidb==0)
            return $defaultEntityManager;
    
        $bundle = self::getBundleName();
    
        if($bundle=='Symfony:Bundle:FrameworkBundle')
            return $defaultEntityManager;
    
        //判断是否嵌入Bundle后缀
        if (preg_match('/Bundle$/', $bundle))
            $bundle = str_replace ( 'Bundle', "", $bundle );
    
        return $bundle?lcfirst($bundle):$defaultEntityManager;;
    }
    
    public function getUserBundle()
    {
        //取默认参数
        $defaultEntityManager = self::ucWords(self::C('doctrine.default_entity_manager'));
    
        //判断是否嵌入Bundle后缀
        if (!preg_match('/Bundle$/', $defaultEntityManager))
            $defaultEntityManager = $defaultEntityManager."Bundle";
    
        return $defaultEntityManager;
    }
    
    /**
     * 嵌入表前缀
     * @param string $name
     * @return string
     */
    public function prefixName($name)
    {
        //判断是否嵌入过表前缀
        if (false === strpos($name, $this->prefix)) {
            $name = $this->prefix . $name;
        }
    
        return $name;
    }
    
    /**
     * 过滤表前缀
     * @param string $name
     * @return mixed
     */
    public function unprefixName($name)
    {
        //判断是否嵌入过表前缀
        if (false !== strpos($name, $this->prefix)){
            $name = str_replace(array($this->prefix),"",$name);
        }
        return $name;
    }
    
    /**
     * 嵌入Bundle前缀
     * @param string $name
     * @return string
     */
    public function prefixEntityName($name, $bundle="")
    {
        $name = self::ucWords($name);
        $bundle = $bundle?($bundle.":"):self::getUserBundle().":";
        //判断是否嵌入过Bundle前缀
        if (false === strpos($name, $bundle)) {
            $name = $bundle.$name;
        }
        return $name;
    }
    
    /**
     * 过滤Bundle前缀
     * @param string $name
     * @return string
     */
    public function unprefixEntityName($name, $bundle="")
    {
        $bundle = $bundle?($bundle.":"):self::getUserBundle().":";
    
        //判断是否嵌入过Bundle前缀
        if (false !== strpos($name, $bundle))
            $name = str_replace(array($bundle),"",$name);
    
        return $name;
    }
    
    /**
     * 获取默认Bundle名称
     * @return mixed
     */
    public function getDefaultBundle()
    {
        return self::getUserBundle();
    }
    
    /**
     * 获取表前缀
     * @return string
     */
    public function getTblprefix()
    {
        return $this->prefix;
    }
    
    /**
     * 判断是否为手机
     * @return boolean
     */
    public function isMobile($phone)
    {
        $str = array();
        //手机号码验证
        $partern = '/^\d{11,13}$/i';
        preg_match($partern, $phone, $str);
    
        return empty($str)?false:true;
    }
    
    /**
     * 判断是否为手机浏览器
     * @return boolean
     */
    public function isMobileClient()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) return true;
    
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息,找不到为flase,否则为true
        if (isset ($_SERVER['HTTP_VIA'])) return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) return true;
        }
    
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * 获得当前路由的bundle名称
     */
    public function getBundleName($flag=false)
    {
        $controller = $this->get('request')->get('_controller');
    
        //去掉反斜杠
        $pattern = array();
        $pattern[0] = "/\\\\/";
        $pattern[1] = "/\//";
        $controller = preg_replace($pattern,":",$controller);
    
        //正则匹配取Bundle之前的字符串
        $pattern = "/(.*)Bundle:/";
        $matches = array();
    
        if(preg_match($pattern, $controller, $matches))
            return $flag?strtolower($matches[1]):$matches[1]."Bundle";
    
        return "";
    }
    
    /**
     * 获得当前路由的控制器名称
     */
    public function getControllerName($controller=null)
    {
        $controller = $controller?$controller:$this->get('request')->get('_controller');
    
        $pattern = "#Controller\\\\([a-zA-Z0-9]*)Controller#";
    
        $matches = array();
    
        if(preg_match($pattern, $controller, $matches))
            return strtolower($matches[1]);
    
        $matches = explode(":", $controller);
    
        return strtolower($matches[1]);
    }
    
    /**
     * 获得当前路由的动作名称
     */
    public function getActionName($controller=null)
    {
        $controller = $controller?$controller:$this->get('request')->get('_controller');
    
        $pattern = "#::([a-zA-Z0-9]*)Action#";
    
        $matches = array();
    
        if(preg_match($pattern, $controller, $matches))
            return strtolower($matches[1]);
    
        $matches = explode(":", $controller);
    
        //去掉Action后缀
        if(isset($matches[2]))
            return preg_replace('/Action$/', '', $matches[2]);
    
        //去掉Action后缀
        if(isset($matches[1]))
            return preg_replace('/Action$/', '', $matches[1]);
    
        return "";
    }
    
    /**
     * 获得所有的已加载Bundle
     */
    public function getBundles($str='08cms')
    {
        $data = array();
    
        $bundles = self::getParameter('kernel.bundles');
    
        foreach($bundles as $k=>$bundle)
        {
            $info = new $bundle();
            if(method_exists($info, 'getCompany')&&$str==$info->getCompany())
                $data[$k] = $bundle;
        }
        return $data;
    }
    
    /**
     * 获得参数值
     * @param string $name  参数名称
     */
    public function getParameter($name)
    {
        return $this->container->getParameter($name);
    }
    
    /**
     * 数据输出
     * ajax请求默认输出去json格式
     * 非ajax请求有跳转的跳转，无跳转的直接到错误模版输出
     * @param string $message
     * @param int $status
     * @param string $jumpUrl
     * @param bool $ajax
     * @return array()
     */
    public function showMessage($message, $status=false, array $newdata=array(), $jumpUrl='', $ajax=false)
    {
        $data			= array();
        $data['info']	= $message;
        $data['status']	= $status;
        $data['url']    = $jumpUrl;
        //$data['jumpUrl']= $jumpUrl;
        $data['waitSecond']= 5;
    
        //参数合并
        $data = array_merge($data,$newdata);
    
        //AJAX提交
        if(true === $ajax || self::isAjax())
            return self::ajaxReturn($data, 'json');
    
        //非Ajax输出模版
        if($status)
            return $this->get('templating')->renderResponse('CoreBundle:Dispatch:success.html.twig', $data);
        else
            return $this->get('templating')->renderResponse('CoreBundle:Dispatch:error.html.twig', $data);
    }
    
    /**
     * ajax输出数据
     * @param string $data
     * @param string $type
     */
    public function ajaxReturn($data,$type='')
    {
        $type = $this->get('request')->get('datatype', $type);
    
        if(empty($type))
            $type = self::isAjax()?'json':'EVAL';
    
        $data = $this->get('serializer')->normalize($data);
    
        switch (strtoupper($type)){
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                //die(preg_replace("#\\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($data)));
                die(json_encode($data));
                break;
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                $jsonp = new JsonResponse($data);
                $jsonp->setCallback('n08cms');
                return $jsonp;
                break;
            case 'EVAL' :
                // 返回可执行的js脚本
                die($data);
                break;
            default     :
                // 用于扩展其他返回格式数据
                die($data);
                break;
        }
    }
    
    /**
     * 判断请求是否为ajax
     * @return boolean
     */
    public function isAjax()
    {
        //jQuery 发出 ajax 请求
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest")
            return true;
    
        //原生 JavaScript 发出 ajax 请求
        if (isset($_SERVER['HTTP_REQUEST_TYPE']) && $_SERVER['HTTP_REQUEST_TYPE'] == "ajax")
            return true;
    
        $type = $this->get('request')->get('datatype', '');
    
        return $type?$type:false;
    }
    
    /**
     * 生成唯一标识
     */
    public function createIdentifier()
    {
        return md5(uniqid(md5(microtime(true)),true));
    }
    
    /**
     * 根据ID计算文件夹目录结构
     * @param int $id
     * @return string
     */
    public function getFileDir($id)
    {
        $_id = $id;
        if((int)$id>0){
            $id = sprintf("%09d", $id);
            return substr($id, 0, 3) . DIRECTORY_SEPARATOR . substr($id, 3, 2) . DIRECTORY_SEPARATOR . substr($id, 5, 2).DIRECTORY_SEPARATOR.$_id;
        }
    
        throw new \InvalidArgumentException("ID必须为数字");
    }
    
    /**
     * 根据ID计算文件夹子目录结构
     * @param int $id
     * @return string
     */
    public function getFileSubDir($id)
    {
        if((int)$id>0)
        {
            $id = sprintf("%09d", $id);
            return substr($id, 0, 3) . DIRECTORY_SEPARATOR . substr($id, 3, 3);
        }
    
        throw new \InvalidArgumentException("ID必须为数字");
    }
    
    public function C($name)
    {
        return $this->container->getParameter($name);
    }
    
    /**
     * 全局缓存设置和读取
     * @param string $name 缓存名称
     * @param mixed $value 缓存值
     * @param integer $expire 缓存有效期（秒）
     * @param string $type 缓存类型
     * @param array $options 缓存参数
     * @return mixed
     */
    public function S($name='', $value='', $expire=null, $type='',$options=null)
    {
        
    }
    
    /**
     * 获取site绝对路径
     */
    public function getSiteRoot()
    {
        $root_dir = dirname(self::C('kernel.root_dir'));
        return $root_dir.DIRECTORY_SEPARATOR;
    }
    
    /**
     * 获得路径，基于Bundle名
     * @param string $bundlename
     */
    public function getBundlePath($bundlename, $type = '08cms')
    {
        $bundlePath = "";
        $bundles = self::getBundles($type);
        if(!isset($bundles[$bundlename])) return $bundlePath;
    
        $bundleInfo = new $bundles[$bundlename]();
    
        return $bundleInfo->getPath().DIRECTORY_SEPARATOR;
    }
    
    /**
     * 获得命名空间，基于Bundle名
     * @param string $bundlename
     * @return string
     */
    public function getBundleNamespace($bundlename)
    {
        $bundlename = self::ucWords($bundlename);
    
        //判断是否嵌入Bundle后缀
        if (!preg_match('/Bundle$/', $bundlename))
            $bundlename = $bundlename."Bundle";
    
        $bundlePath = "";
        $bundles = self::getBundles();
    
        if(!isset($bundles[$bundlename]))
            return $bundlePath;
    
        $bundleInfo = new $bundles[$bundlename]();
    
        return $bundleInfo->getNamespace();
    }
    
    /**
     * psr-0命名规则
     * @param string $str
     * @return string
     */
    public function ucWords($str)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', $str);
        return $str;
    }
    
    /**
     * 处理元数据
     * @param object $info
     * @param array $data
     */
    public function handleMetadata($info, array $data, $metadata='')
    {
        if(isset($info->entity)&&is_object($info->entity))
        {
            foreach($info->column as $k=>$v)
            {
                $type = isset($info->fieldMapps[$k]['type'])?$info->fieldMapps[$k]['type']:'string';
    
                $options = $info->fieldMapps[$k]['options'];
                $default = isset($options['default'])?$options['default']:'';
    
                if(isset($data[$v])&&is_array($data[$v]))
                    $data[$v] = implode(',',$data[$v]);
    
                switch($type)
                {
                    case 'integer':
                    case 'boolean':
                        $typeVal = isset($data[$v])?(int)trim($data[$v]):(int)$default;
                        break;
                    case 'date':
                    case 'time':
                    case 'datetime':
                        $typeVal = new \DateTime(isset($data[$v])&&$data[$v]?trim($data[$v]):"");
                        break;
                    default :
                        $typeVal = isset($data[$v])?trim($data[$v]):$default;
                        break;
                }
                $info->entity->{"set" . self::ucWords($v)}($typeVal);
            }
        }elseif(is_object($info)){
            foreach($data as $key=>$val)
            {
                if(is_array($val))
                    $val = implode(',', $val);
    
                if(method_exists($info, "set".self::ucWords($key)))
                {
                    $type = 'string';
                    if(is_object($metadata))
                        $type = isset($metadata->fieldMapps[$key]['type'])?$metadata->fieldMapps[$key]['type']:$type;
    
                    switch($type)
                    {
                        case 'integer':
                        case 'boolean':
                            $val = (int)$val;
                            break;
                        case 'float':
                            $val = floatval($val);
                            break;
                        case 'date':
                        case 'time':
                        case 'datetime':
                            $val = new \DateTime($val?trim($val):"");
                            break;
                        default :
                            $val = trim($val);
                            break;
                    }
                    $info->{"set".self::ucWords($key)}($val);
                }
            }
            if(method_exists($info, "setAttributes"))
                $info->setAttributes('');
        }
    }
}