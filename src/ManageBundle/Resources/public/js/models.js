/**
 * 模型管理JS
 */
(function ($, window, document, undefined) {
	'use strict';
	var pluginName = 'models';
	
	$.fn[pluginName] = function (options) {
        var self = $(this);
        if (this == null)
            return null;
        
      //初始化加載的腳本
		try{
			return new Models(this, $.extend(true, {}, options));
		}catch(e) {
			modals.error("JS脚本错误！["+e+"]","error");
		}
        
    }
	
	var Models = function (element, options) {
        this.$element = $(element);
        this.options = options;
        this.winId = this.options.winId || "modelsWin";
        var b = options['b']||'';
        var c = options['c']||'';
        if(!b||!c)
        {
        	modals.error('未定义 b or c 参数');
        	return false;
        }
        
        var baseUrl = basePath+"/"+b+"/"+c;
        this.editurl = baseUrl+"/edit";
        this.saveurl = baseUrl+"/save";
        this.delurl = baseUrl+"/delete";
        this.createurl = baseUrl+"/create";
        
        var modelsTable, modelsAttrTable;
        
        var models_config={
				rowClick:function(row,isSelected){  
					$("#modelId").val(isSelected?row.id:0);
					$("#modelName").remove();
					if(isSelected)
					   $("#searchDiv_modelsattr").prepend("<h5 id='modelName' class='pull-left'>【"+row.name+"】 "+row.title+"</h5>");
					modelsAttrTable.reloadData();   
				}
			}
        
        modelsTable = new CommonTable("models_table", "models_list", "searchDiv", models_config);
        
        //默认选中第一行 
		setTimeout(function(){modelsTable.selectFirstRow(true)},20);
        
        var config={
    			lengthChange:false,
    			pagingType:'simple_numbers'
    		}   		
        
        modelsAttrTable = new CommonTable("modelattr_table","modelattr_list","searchDiv_modelsattr",config);
        
        this.modelsTable = modelsTable;
        this.modelsAttrTable = modelsAttrTable;
        
        this.init();
    }
	
	//初始化
	Models.prototype.init = function () {
		//按钮
        this.initBtnCheck();
    }
	
	/**
     * 页面增加BaseEntity中的属性
     * 通过是否baseentity配置，baseentity 不配置或为true
     */
	Models.prototype.initBtnCheck = function () {
        var form = this.$element;
        var winId = this.winId;
        var modelsTable = this.modelsTable;
        var modelsAttrTable = this.modelsAttrTable;
        var delurl = this.delurl;        
        var editurl = this.editurl;
        var createurl = this.createurl;

        if ($('button[data-btn-type]').length > 0) {
        	$('button[data-btn-type]').off().on('click',function(){
        		var action = $(this).attr('data-btn-type');
                switch (action) {
	    			case 'add':
    					modals.openWin({
	                       	winId:winId,
	                       	title:'新增模型',
	                       	width:'900px',
	                       	url: editurl
	                       	/*, hideFunc:function(){
	                       		modals.info("hide me");
	                       	},
	                       	showFunc:function(){
	                       		modals.info("show me");
	                       	} */
    					});                        
	    				break;
	    			case 'edit':
	                    var tableRow = modelsTable.getSelectedRowData()||{};
	                    var rowId = tableRow['id']||0;
	    				if(!rowId){
	    					modals.info('请选择要编辑的行');
	    					return false;
	    				}
	    				modals.openWin({
	                       	winId:winId,
	                       	title:'编辑模型【'+modelsTable.getSelectedRowData().name+'】',
	                       	width:'900px',
	                       	url:editurl+"?id="+rowId,
	                       });
	    			   break;
	    			case 'delete':
	                    var tableRow = modelsTable.getSelectedRowData()||{};
	                    var rowId = tableRow['id']||0;
	    				if(!rowId){
	    					modals.info('请选择要删除的行');
	    					return false;
	    				}
	    				modals.confirm("是否要删除该行数据？",function(){
	    					ajaxPost(delurl,{'id':rowId},function(data){
	    						if(data.status){
	    							//modals.correct("已删除该数据");
	    							modelsTable.reloadRowData();
	    						}else{
	    							modals.error(data.info);
	    						}
	    					});
	    				})
	    				break;
	    			case 'create':
	                    var tableRow = modelsTable.getSelectedRowData()||{};
	                    var rowId = tableRow['id']||0;
	    				if(!rowId){
	    					modals.info('请选择要生成的行');
	    					return false;
	    				}
	    				modals.confirm("是否要生成该行数据？",function(){
	    					ajaxPost(createurl,{'id':rowId},function(data){
	    						if(data.status){
	    							modals.info(data.info);
	    						}else{
	    							modals.error(data.info);
	    						}
	    					});
	    				})
	    				break;
	    			case 'addattr':
    					modals.openWin({
	                       	winId:winId,
	                       	title:'新增模型',
	                       	width:'900px',
	                       	url:editurl+'attr'
	                       	/*, hideFunc:function(){
	                       		modals.info("hide me");
	                       	},
	                       	showFunc:function(){
	                       		modals.info("show me");
	                       	} */
    					});                        
	    				break;
	    			case 'editattr':
	                    var tableRow = modelsAttrTable.getSelectedRowData()||{};
	                    var rowId = tableRow['id']||0;
	    				if(!rowId){
	    					modals.info('请选择要编辑的行');
	    					return false;
	    				}
	    				modals.openWin({
	                       	winId:winId,
	                       	title:'编辑模型字段【'+modelsAttrTable.getSelectedRowData().name+'】',
	                       	width:'900px',
	                       	url:editurl+'attr?id='+rowId,
	                       });
	    			   break;
	    			case 'deleteattr':
	                    var tableRow = modelsAttrTable.getSelectedRowData()||{};
	                    var rowId = tableRow['id']||0;
	    				if(!rowId){
	    					modals.info('请选择要删除的行');
	    					return false;
	    				}
	    				modals.confirm("是否要删除该行数据？",function(){
	    					ajaxPost(delurl+'attr',{'id':rowId},function(data){
	    						if(data.success){
	    							//modals.correct("已删除该数据");
	    							modelsAttrTable.reloadRowData();
	    						}else{
	    							modals.error(data.info);
	    						}
	    					});
	    				})
	    				break;
    			}
        	});
        }
    }
	
	Models.prototype.initEdit = function () {
		//初始化控件
		var form=$("#user-form").form();
		
		var winId = this.winId;
		
		var userTable = this.modelsTable;
		
		var saveurl = this.saveurl; 
		
		//数据校验
		$("#user-form").bootstrapValidator({
			message : '请输入有效值',
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			submitHandler : function(validator, userform, submitButton) {
				modals.confirm('确认保存？', function() {
					//Save Data，对应'submit-提交'
					var params = form.getFormSimpleData();
					ajaxPost(saveurl, params, function(data, status) {
						if(data.status){
                            modals.hideWin(winId); 
                            userTable.reloadData(); 
						}else{
							modals.error(data.info);
						}
					});
				});
			},
			fields : {
				name : {
					validators : {
						notEmpty : {
							message : '请输入英文标识'
						}
					}
				},
				title : {
					validators : {
						notEmpty : {
							message : '请输入中文标识'
						}
					}
				},
				service : {
					validators : {
						notEmpty : {
							message : '请输入所属服务'
						}
//						,date : {
//							format : $(this).data("format"),
//							message : '请输入有效日期'
//						} 
					}
				}
			}
		});
		
		form.initComponent();
	}
	Models.prototype.initEditAttr = function () {
		//初始化控件
		var form=$("#user-form").form();
		
		var winId = this.winId;
		
		var userTable = this.modelsAttrTable;
		var modelsTable = this.modelsTable;
		var saveurl = this.saveurl; 
		
		//数据校验
		$("#user-form").bootstrapValidator({
			message : '请输入有效值',
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			submitHandler : function(validator, userform, submitButton) {
				var tableRow = modelsTable.getSelectedRowData()||{};
                var rowId = tableRow['id']||0;
                
                if(rowId<=0){
                	modals.error('请选择模型');
                	return false;
                }
                
				modals.confirm('确认保存？', function() {
					//Save Data，对应'submit-提交'
					var params = form.getFormSimpleData();
					params['model_id'] = rowId;
					ajaxPost(saveurl+"attr", params, function(data, status) {
						if(data.status){
                            modals.hideWin(winId); 
                            userTable.reloadData(); 
						}else{
							modals.error(data.info);
						}
					});
				});
			},
			fields : {
				name : {
					validators : {
						notEmpty : {
							message : '请输入英文标识'
						}
					}
				},
				title : {
					validators : {
						notEmpty : {
							message : '请输入中文标识'
						}
					}
				},
				service : {
					validators : {
						notEmpty : {
							message : '请输入所属服务'
						}
//						,date : {
//							format : $(this).data("format"),
//							message : '请输入有效日期'
//						} 
					}
				}
			}
		});
		
		form.initComponent();
	}
})(jQuery, window, document);