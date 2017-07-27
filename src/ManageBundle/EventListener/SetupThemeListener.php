<?php
/**
 * SetupThemeListener.php
 * publisher
 * Date: 01.05.14
 */

namespace ManageBundle\EventListener;


use Avanzu\AdminThemeBundle\Theme\ThemeManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class SetupThemeListener {

    /**
     * @var ThemeManager
     */
    protected $manager;

    protected $cssBase;

    protected $lteAdmin;

    function __construct($manager, $cssBase = null, $lteAdmin = null)
    {
        $this->cssBase  = $cssBase?:'bundles/';
        $this->lteAdmin = $lteAdmin?:'core/';
        $this->manager  = $manager;
    }


    public function onKernelController(FilterControllerEvent $event) {

        $css = rtrim($this->cssBase, '/').'/'.trim($this->lteAdmin, '/');
        $mng = $this->manager;

        $mng->registerStyle('icheck', $css.'/adminlte/plugins/jQueryUI/jquery-ui.css');
        $mng->registerStyle('bootstrap-validator', $css.'/adminlte/plugins/bootstrap-validator/dist/css/bootstrap-validator.css');
        $mng->registerStyle('select2', $css.'/adminlte/plugins/select2/select2.min.css');
        $mng->registerStyle('bootstrap-treeview', $css.'/adminlte/plugins/bootstrap-treeview/bootstrap-treeview.min.css');
        $mng->registerStyle('bootstrap-select', $css.'/adminlte/plugins/datatables/select.bootstrap.min.css');

        $mng->registerScript('base', $css.'/common/js/base.js');
        $mng->registerScript('base-modal', $css.'/common/js/base-modal.js');
        $mng->registerScript('base-form', $css.'/common/js/base-form.js');
        $mng->registerScript('base-datasource', $css.'/common/js/base-datasource.js');
        $mng->registerScript('base-org', $css.'/common/js/base-org.js');
        $mng->registerScript('data-tables', $css.'/common/js/dataTables.js');
        $mng->registerScript('select2', $css.'/adminlte/plugins/select2/select2.full.min.js');
        $mng->registerScript('bootstrap-validator', $css.'/adminlte/plugins/bootstrap-validator/dist/js/bootstrap-validator.js');
        $mng->registerScript('bootstrap-treeview', $css.'/adminlte/plugins/bootstrap-treeview/bootstrap-treeview.min.js');

//         $mng->registerStyle('base', $css.'/common/css/base.css');
//         $mng->registerStyle('bootstrap', $css.'/adminlte/bootstrap/css/bootstrap.min.css');
//         $mng->registerStyle('fontawesome', $css.'/common/libs/font-awesome/css/font-awesome.min.css', array('bootstrap'));
//         $mng->registerStyle('bootstrap-slider', $css.'adminlte/plugins/bootstrap-slider/slider.css', array('bootstrap'));
//         $mng->registerStyle('datatables', $css.'/adminlte/plugins/datatables/dataTables.bootstrap.min.css', array('bootstrap'));
//         $mng->registerStyle('bootstrap-select', $css.'/adminlte/plugins/datatables/select.bootstrap.min.css', array('bootstrap'));
//         $mng->registerStyle('bootstrap-validator', $css.'/adminlte/plugins/bootstrap-validator/dist/css/bootstrap-validator.css', array('bootstrap'));
//         $mng->registerStyle('icheck', $css.'/adminlte/plugins/iCheck/all.css');
//         $mng->registerStyle('datepicker3', $css.'/adminlte/plugins/datepicker/datepicker3.css');
//         $mng->registerStyle('select2', $css.'/adminlte/plugins/select2/select2.min.css');
//         $mng->registerStyle('bootstrap-treeview', $css.'/adminlte/plugins/bootstrap-treeview/bootstrap-treeview.min.css');
//         $mng->registerStyle('ionicons', $css.'/common/libs/ionicons/css/ionicons.min.css');
//         $mng->registerStyle('admin-lte', $css.'/adminlte/dist/css/AdminLTE.min.css', array('bootstrap-slider', 'fontawesome', 'ionicons','datatables'));
//         $mng->registerStyle('all-skins', $css.'/adminlte/dist/css/skins/_all-skins.css', array('admin-lte'));

//         $mng->registerScript('jQuery', $css.'/adminlte/plugins/jQuery/jQuery-2.2.0.min.js');
//         $mng->registerScript('json2', $css.'/common/json/json2.js');
//         $mng->registerScript('bootstrap', $css.'/adminlte/bootstrap/js/bootstrap.min.js', array('jQuery'));
//         $mng->registerScript('fastclick', $css.'/adminlte/plugins/fastclick/fastclick.js', array('bootstrap'));
//         $mng->registerScript('jq.dataTables', $css.'/adminlte/plugins/datatables/jquery.dataTables.js', array('bootstrap'));
//         $mng->registerScript('dataTables-bootstrap', $css.'/adminlte/plugins/datatables/dataTables.bootstrap.min.js', array('bootstrap'));
//         $mng->registerScript('dataTables', $css.'/common/js/dataTables.js', array('bootstrap'));
//         $mng->registerScript('bootstrap-validator', $css.'/adminlte/plugins/bootstrap-validator/dist/js/bootstrap-validator.js', array('bootstrap'));
//         $mng->registerScript('icheck', $css.'/adminlte/plugins/iCheck/icheck.min.js', array('bootstrap'));
//         $mng->registerScript('datepicker', $css.'/adminlte/plugins/datepicker/bootstrap-datepicker.js', array('bootstrap'));
//         $mng->registerScript('bootstrap-treeview', $css.'/adminlte/plugins/bootstrap-treeview/bootstrap-treeview.min.js', array('bootstrap'));
//         $mng->registerScript('demo', $css.'/adminlte/dist/js/demo.js', array('bootstrap'));
//         $mng->registerScript('select2', $css.'/adminlte/plugins/select2/select2.full.min.js', array('bootstrap'));
//         $mng->registerScript('app', $css.'/adminlte/dist/js/app.min.js', array('bootstrap'));
//         $mng->registerScript('base', $css.'/common/js/base.js', array('jQuery', 'bootstrap'));
//         $mng->registerScript('modal', $css.'/common/js/base-modal.js', array('base'));
//         $mng->registerScript('form', $css.'/common/js/base-form.js', array('base'));
//         $mng->registerScript('datasource', $css.'/common/js/base-datasource.js', array('base'));
    }
}