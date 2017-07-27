<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月19日
*/
namespace ManageBundle\Controller;

class SetuserController extends Controller
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
    
    public function editAction()
    {
        $map = array();
        $map['id'] = (int)$this->get('request')->get('id',0);
        $this->parameters['info'] = $this->get('db.users')->findOneBy($map);
        return parent::render();
    }
    
    public function saveAction()
    {
        return parent::success('操作成功');
    }
    
    public function avatarAction()
    {
        return parent::render();
    }
    
    public function avatarUploadAction()
    {
        $result = array();
        $result['success'] = false;
        $successNum = 0;
        //定义一个变量用以储存当前头像的序号
        $avatarNumber = 1;
        $i = 0;
        $msg = '';
        //上传目录
        $dir = "F:/uploadss";
        
        //遍历所有文件域
        foreach(array_keys($_FILES) as $key)
        {
        
        //while (list($key, $val) = each($_FILES))
        //{
            if ( $_FILES[$key]['error'] > 0)
            {
                $msg .= $_FILES[$key]['error'];
            }
            else
            {
                $fileName = date("YmdHis").'_'.floor(microtime() * 1000).'_'.self::createRandomCode(8);
                //处理原始图片（默认的 file 域的名称是__source，可在插件配置参数中自定义。参数名：src_field_name）
                //如果在插件中定义可以上传原始图片的话，可在此处理，否则可以忽略。
                if ($key == '__source')
                {
                    //当前头像基于原图的初始化参数，用于修改头像时保证界面的视图跟保存头像时一致。帮助提升用户体验度。修改头像时设置默认加载的原图的url为此图片的url+该参数即可。
                    $initParams = $_POST["__initParams"];
                    $virtualPath = "$dir/php_source_$fileName.jpg";
                    $result['sourceUrl'] = '/' . $virtualPath.$initParams;
                    move_uploaded_file($_FILES[$key]["tmp_name"], $virtualPath);
                    /*
                     可在此将 $result['sourceUrl'] 储存到数据库
                    */
                    $successNum++;
                }
                //处理头像图片(默认的 file 域的名称：__avatar1,2,3...，可在插件配置参数中自定义，参数名：avatar_field_names)
                else if (strpos($key, '__avatar') === 0)
                {
                    $virtualPath = "$dir/php_avatar" . $avatarNumber . "_$fileName.jpg";
                    $result['avatarUrls'][$i] = '/' . $virtualPath;
                    move_uploaded_file($_FILES[$key]["tmp_name"], $virtualPath);
                    /*
                     可在此将 $result['avatarUrls'][$i] 储存到数据库
                    */
                    $successNum++;
                    $i++;
                }
                /*
                 else
                 {
                                                            如下代码在上传接口upload.php中定义了一个user=xxx的参数：
                 var swf = new fullAvatarEditor("swf", {
                 id: "swf",
                 upload_url: "Upload.php?user=xxx"
                 });
                                                            在此即可用$_POST["user"]获取xxx。
                 }
                 */
            }
        }
        $result['msg'] = $msg;
        if ($successNum > 0)
        {
            $result['success'] = true;
            return parent::success('上传成功', '', $result, true);
        }
        return parent::error($msg, '', true);
        //返回图片的保存结果（返回内容为json字符串）
        print json_encode($result);
    }
    
    /**************************************************************
     *  生成指定长度的随机码。
     *  @param int $length 随机码的长度。
     *  @access public
     **************************************************************/
    public function createRandomCode($length)
    {
        $randomCode = "";
        $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++)
        {
            $randomCode .= $randomChars { mt_rand(0, 35) };
        }
        return $randomCode;
    }
    
    private function getColumnList()
    {
        $columnList = array();
        $columnList[0]['key'] = 'rowIndex';
        $columnList[0]['id'] = '';
        $columnList[0]['header'] = '序号';
        $columnList[0]['type'] = 'ro';
        $columnList[0]['classType'] = '';
        $columnList[0]['align'] = 'center';
        $columnList[0]['allowSort'] = false;
        $columnList[0]['allowSearch'] = false;
        $columnList[0]['hidden'] = false;
        $columnList[0]['enableTooltip'] = false;
        $columnList[0]['color'] = '';
        $columnList[0]['operator'] = 'eq';
        $columnList[0]['width'] = '50';
        $columnList[0]['dateFormat'] = '';
        $columnList[0]['numberFormat'] = '';
        $columnList[0]['fnRender'] = '';
        $columnList[0]['isServerCondition'] = false;
        $columnList[0]['value'] = '';
        $columnList[0]['isExport'] = true;
        $columnList[0]['suffix'] = null;
        $columnList[0]['dict'] = null;
        $columnList[0]['maxLen'] = null;
        $columnList[0]['tooltip'] = null;
        $columnList[0]['isJustExport'] = false;
        $columnList[0]['subHeader'] = '#rspan';
        $columnList[0]['render'] = null;
        $columnList[0]['isQuote'] = true;
        $columnList[0]['isImport'] = true;
        $columnList[0]['index'] = null;
        $columnList[0]['foreignClass'] = null;
        $columnList[0]['isShow'] = null;
        $columnList[0]['operatorObject'] = array('%0 = %1');
        
        $columnList[1]['key'] = 'id';
        $columnList[1]['id'] = '';
        $columnList[1]['header'] = 'id';
        $columnList[1]['type'] = 'ro';
        $columnList[1]['classType'] = '';
        $columnList[1]['align'] = 'center';
        $columnList[1]['allowSort'] = false;
        $columnList[1]['allowSearch'] = false;
        $columnList[1]['hidden'] = true;
        $columnList[1]['enableTooltip'] = false;
        $columnList[1]['color'] = '';
        $columnList[1]['operator'] = 'eq';
        $columnList[1]['width'] = '50';
        $columnList[1]['dateFormat'] = '';
        $columnList[1]['numberFormat'] = '';
        $columnList[1]['fnRender'] = '';
        $columnList[1]['isServerCondition'] = false;
        $columnList[1]['value'] = '';
        $columnList[1]['isExport'] = true;
        $columnList[1]['suffix'] = null;
        $columnList[1]['dict'] = null;
        $columnList[1]['maxLen'] = null;
        $columnList[1]['tooltip'] = null;
        $columnList[1]['isJustExport'] = false;
        $columnList[1]['subHeader'] = '#rspan';
        $columnList[1]['render'] = null;
        $columnList[1]['isQuote'] = true;
        $columnList[1]['isImport'] = true;
        $columnList[1]['index'] = null;
        $columnList[1]['foreignClass'] = null;
        $columnList[1]['isShow'] = null;
        $columnList[1]['operatorObject'] = array('%0 = %1');
        
        $columnList[2]['key'] = 'username';
        $columnList[2]['id'] = '';
        $columnList[2]['header'] = '用户名';
        $columnList[2]['type'] = 'ro';
        $columnList[2]['classType'] = '';
        $columnList[2]['align'] = 'center';
        $columnList[2]['allowSort'] = true;
        $columnList[2]['allowSearch'] = false;
        $columnList[2]['hidden'] = false;
        $columnList[2]['enableTooltip'] = false;
        $columnList[2]['color'] = '';
        $columnList[2]['operator'] = 'eq';
        $columnList[2]['width'] = '50';
        $columnList[2]['dateFormat'] = '';
        $columnList[2]['numberFormat'] = '';
        $columnList[2]['fnRender'] = '';
        $columnList[2]['isServerCondition'] = false;
        $columnList[2]['value'] = '';
        $columnList[2]['isExport'] = true;
        $columnList[2]['suffix'] = null;
        $columnList[2]['dict'] = null;
        $columnList[2]['maxLen'] = null;
        $columnList[2]['tooltip'] = null;
        $columnList[2]['isJustExport'] = false;
        $columnList[2]['subHeader'] = '#rspan';
        $columnList[2]['render'] = null;
        $columnList[2]['isQuote'] = true;
        $columnList[2]['isImport'] = true;
        $columnList[2]['index'] = null;
        $columnList[2]['foreignClass'] = null;
        $columnList[2]['isShow'] = null;
        $columnList[2]['operatorObject'] = array('%0 LIKE %1');
        
        $columnList[3]['key'] = 'email';
        $columnList[3]['id'] = '';
        $columnList[3]['header'] = '邮箱';
        $columnList[3]['type'] = 'ro';
        $columnList[3]['classType'] = '';
        $columnList[3]['align'] = 'center';
        $columnList[3]['allowSort'] = true;
        $columnList[3]['allowSearch'] = false;
        $columnList[3]['hidden'] = false;
        $columnList[3]['enableTooltip'] = false;
        $columnList[3]['color'] = '';
        $columnList[3]['operator'] = 'eq';
        $columnList[3]['width'] = '50';
        $columnList[3]['dateFormat'] = '';
        $columnList[3]['numberFormat'] = '';
        $columnList[3]['fnRender'] = '';
        $columnList[3]['isServerCondition'] = false;
        $columnList[3]['value'] = '';
        $columnList[3]['isExport'] = true;
        $columnList[3]['suffix'] = null;
        $columnList[3]['dict'] = null;
        $columnList[3]['maxLen'] = null;
        $columnList[3]['tooltip'] = null;
        $columnList[3]['isJustExport'] = false;
        $columnList[3]['subHeader'] = '#rspan';
        $columnList[3]['render'] = null;
        $columnList[3]['isQuote'] = true;
        $columnList[3]['isImport'] = true;
        $columnList[3]['index'] = null;
        $columnList[3]['foreignClass'] = null;
        $columnList[3]['isShow'] = null;
        $columnList[3]['operatorObject'] = array('%0 LIKE %1');
        
        $columnList[4]['key'] = 'tel';
        $columnList[4]['id'] = '';
        $columnList[4]['header'] = '手机';
        $columnList[4]['type'] = 'ro';
        $columnList[4]['classType'] = '';
        $columnList[4]['align'] = 'center';
        $columnList[4]['allowSort'] = true;
        $columnList[4]['allowSearch'] = false;
        $columnList[4]['hidden'] = false;
        $columnList[4]['enableTooltip'] = false;
        $columnList[4]['color'] = '';
        $columnList[4]['operator'] = 'eq';
        $columnList[4]['width'] = '50';
        $columnList[4]['dateFormat'] = '';
        $columnList[4]['numberFormat'] = '';
        $columnList[4]['fnRender'] = '';
        $columnList[4]['isServerCondition'] = false;
        $columnList[4]['value'] = '';
        $columnList[4]['isExport'] = true;
        $columnList[4]['suffix'] = null;
        $columnList[4]['dict'] = null;
        $columnList[4]['maxLen'] = null;
        $columnList[4]['tooltip'] = null;
        $columnList[4]['isJustExport'] = false;
        $columnList[4]['subHeader'] = '#rspan';
        $columnList[4]['render'] = null;
        $columnList[4]['isQuote'] = true;
        $columnList[4]['isImport'] = true;
        $columnList[4]['index'] = null;
        $columnList[4]['foreignClass'] = null;
        $columnList[4]['isShow'] = null;
        $columnList[4]['operatorObject'] = array('%0 LIKE %1');
        
        $columnList[5]['key'] = 'locale';
        $columnList[5]['id'] = '';
        $columnList[5]['header'] = '语言';
        $columnList[5]['type'] = 'ro';
        $columnList[5]['classType'] = '';
        $columnList[5]['align'] = 'center';
        $columnList[5]['allowSort'] = false;
        $columnList[5]['allowSearch'] = false;
        $columnList[5]['hidden'] = false;
        $columnList[5]['enableTooltip'] = false;
        $columnList[5]['color'] = '';
        $columnList[5]['operator'] = 'eq';
        $columnList[5]['width'] = '50';
        $columnList[5]['dateFormat'] = '';
        $columnList[5]['numberFormat'] = '';
        $columnList[5]['fnRender'] = '';
        $columnList[5]['isServerCondition'] = false;
        $columnList[5]['value'] = '';
        $columnList[5]['isExport'] = true;
        $columnList[5]['suffix'] = null;
        $columnList[5]['dict'] = null;
        $columnList[5]['maxLen'] = null;
        $columnList[5]['tooltip'] = null;
        $columnList[5]['isJustExport'] = false;
        $columnList[5]['subHeader'] = '#rspan';
        $columnList[5]['render'] = null;
        $columnList[5]['isQuote'] = true;
        $columnList[5]['isImport'] = true;
        $columnList[5]['index'] = null;
        $columnList[5]['foreignClass'] = null;
        $columnList[5]['isShow'] = null;
        $columnList[5]['operatorObject'] = array('%0 LIKE %1');
        
        
        $columnList[6]['key'] = 'createTime';
        $columnList[6]['id'] = '';
        $columnList[6]['header'] = '创建时间';
        $columnList[6]['type'] = 'ro';
        $columnList[6]['classType'] = '';
        $columnList[6]['align'] = 'center';
        $columnList[6]['allowSort'] = true;
        $columnList[6]['allowSearch'] = false;
        $columnList[6]['hidden'] = false;
        $columnList[6]['enableTooltip'] = false;
        $columnList[6]['color'] = '';
        $columnList[6]['operator'] = 'eq';
        $columnList[6]['width'] = '50';
        $columnList[6]['dateFormat'] = 'yyyy-mm-dd h:m';
        $columnList[6]['numberFormat'] = '';
        $columnList[6]['fnRender'] = '';
        $columnList[6]['isServerCondition'] = false;
        $columnList[6]['value'] = '';
        $columnList[6]['isExport'] = true;
        $columnList[6]['suffix'] = null;
        $columnList[6]['dict'] = null;
        $columnList[6]['maxLen'] = null;
        $columnList[6]['tooltip'] = null;
        $columnList[6]['isJustExport'] = false;
        $columnList[6]['subHeader'] = '#rspan';
        $columnList[6]['render'] = null;
        $columnList[6]['isQuote'] = true;
        $columnList[6]['isImport'] = true;
        $columnList[6]['index'] = null;
        $columnList[6]['foreignClass'] = null;
        $columnList[6]['isShow'] = null;
        $columnList[6]['operatorObject'] = array('%0 LIKE %1');
        
        $columnList[7]['key'] = 'isActive';
        $columnList[7]['id'] = '';
        $columnList[7]['header'] = '是否有效';
        $columnList[7]['type'] = 'ro';
        $columnList[7]['classType'] = '';
        $columnList[7]['align'] = 'center';
        $columnList[7]['allowSort'] = true;
        $columnList[7]['allowSearch'] = false;
        $columnList[7]['hidden'] = false;
        $columnList[7]['enableTooltip'] = false;
        $columnList[7]['color'] = '';
        $columnList[7]['operator'] = 'eq';
        $columnList[7]['width'] = '50';
        $columnList[7]['dateFormat'] = '';
        $columnList[7]['numberFormat'] = '';
        $columnList[7]['fnRender'] = '';
        $columnList[7]['isServerCondition'] = false;
        $columnList[7]['value'] = '';
        $columnList[7]['isExport'] = true;
        $columnList[7]['suffix'] = null;
        $columnList[7]['dict'] = null;
        $columnList[7]['maxLen'] = null;
        $columnList[7]['tooltip'] = null;
        $columnList[7]['isJustExport'] = false;
        $columnList[7]['subHeader'] = '#rspan';
        $columnList[7]['render'] = null;
        $columnList[7]['isQuote'] = true;
        $columnList[7]['isImport'] = true;
        $columnList[7]['index'] = null;
        $columnList[7]['foreignClass'] = null;
        $columnList[7]['isShow'] = null;
        $columnList[7]['operatorObject'] = array('%0 LIKE %1');
        
        return $columnList;
    }
}