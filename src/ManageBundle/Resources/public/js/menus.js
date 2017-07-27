/**
 * 菜单管理JS
 */
(function ($, window, document, undefined) {
	'use strict';
	var pluginName = 'menus';
	
	$.fn[pluginName] = function (options) {
        var self = $(this);
        if (this == null)
            return null;
        
      //初始化加載的腳本
		try{
			return new Menus(this, $.extend(true, {}, options));
		}catch(e) {
			modals.error("JS脚本错误！["+e+"]","error");
		}
        
    }
	
	var Menus = function (element, options) {
		//this.formFun = $('#function-form').form();
		this.$element = $(element);
        this.options = options;
        this.winId = this.options.winId || "menusWin";
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
        this.treeurl = baseUrl+"/getTreeData";
        this.getUrl = baseUrl+"/getinfo";
        this.check = baseUrl+"/check";
        
        
        this.form = $('#function-form').form();
        
		this.init();
	}
	
	//初始化
	Menus.prototype.init = function ()
	{
        this.initTree(0);
        this.initBtnCheck();
    }
	
	Menus.prototype.initBtnCheck = function ()
	{
		var form = this.form;
		var saveurl = this.saveurl;
		
		var _self = this;

		//初始化校验
		$('#function-form').bootstrapValidator({
			message : '请输入有效值',
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			submitHandler : function(validator, functionform, submitButton) {
				modals.confirm('确认保存？', function() {
					//Save Data，对应'submit-提交'
					var params = form.getFormSimpleData();
					ajaxPost(saveurl, params, function(data, status) {
						if (data.status) {
							//var id=$("input[name='id']").val();
							var selectedArr=$("#tree").data("treeview").getSelected();
							var selectedNodeId=selectedArr.length>0?selectedArr[0].nodeId:0;
							_self.initTree(selectedNodeId);
						}
					});
				});
			},
			fields : {
				name : {
					validators : {
						notEmpty : {
							message : '请输入标识'
						},
				        remote:{
				        	url: _self.check,
				        	data: function(validator) {
	                            return {
	                                fieldName:'name',
	                                fieldValue:$('#name').val(),
	                                id:$('#id').val()
	                            };
	                        },
				        	message:'该标识已被使用'
				        }
					}
				},
				label : {
					validators : {
						notEmpty : {
							message : '请输入名称'
						}
				},
				levelCode : {
					validators : {
						notEmpty : {
							message : '请输入层级编码'
						}
					}
				},
				functype:{
					validators : {
						notEmpty : {
							message : '请选择菜单类型'
						}
					}
				},
				deleted : {
					validators : {
						notEmpty : {
							message : '请选择是否可用'
						}
					}
				}
			}
		});
		form.initComponent();
		//按钮事件
		var btntype=null;
		$('button[data-btn-type]').click(function() {
			var action = $(this).attr('data-btn-type');
			var selectedArr=$("#tree").data("treeview").getSelected();
			var selectedNode=selectedArr.length>0?selectedArr[0]:null;
			switch (action) {
			case 'addRoot':
				_self.formWritable(action);
				form.clearForm();
				$("#icon_i").removeClass();
				//填充上级菜单和层级编码
				_self.fillParentAndLevelCode(null);
				btntype='add';
				break;
			case 'add':
				if(!selectedNode){
					modals.info('请先选择上级菜单');
					return false;
				}
				_self.formWritable(action);
				form.clearForm();
				$("#icon_i").removeClass();
				//填充上级菜单和层级编码
				_self.fillParentAndLevelCode(selectedNode);
				btntype='add';
				break;
			case 'edit':
				if(!selectedNode){
					modals.info('请先选择要编辑的节点');
					return false;
				}
				if(btntype=='add'){
					_self.fillDictForm(selectedNode);
				}
				_self.formWritable(action);
				btntype='edit';
				break;
			case 'delete':
				if(!selectedNode){
					modals.info('请先选择要删除的节点');
					return false;
				}
				if(btntype=='add')
					_self.fillDictForm(selectedNode);
				_self.formReadonly();
				$(".box-header button[data-btn-type='delete']").removeClass("btn-default").addClass("btn-primary");
			    if(selectedNode.nodes){
			    	modals.info('该节点含有子节点，请先删除子节点');
			    	return false;
			    }
			    modals.confirm('是否删除该节点',function(){
			    	ajaxPost(_self.deleteurl+"?id="+selectedNode.id,null,function(data){
			    		if(data.status){
			    		   modals.correct('删除成功');
			    		}else{
			    			modals.info(data.info);
			    		}
			    		//定位
			    		var brothers=$("#tree").data("treeview").getSiblings(selectedNode);
			    		if(brothers.length>0)
			    			_self.initTree(brothers[brothers.length-1].nodeId);
			    		else{
			    		   var parent=$("#tree").data("treeview").getParent(selectedNode);
			    		   _self.initTree(parent?parent.nodeId:0);
			    		}
			    	});
			    });
				break;
			case 'cancel':
				if(btntype=='add')
					_self.fillDictForm(selectedNode);
				_self.formReadonly();
				break;
			case 'selectIcon':
				var disabled=$(this).hasClass("disabled");
		        if(disabled)
		        	break;
				var iconName;
				if($("#icon").val())
				   iconName=encodeURIComponent($("#icon").val());
				modals.openWin({
                	winId:winId,
                	title:'图标选择器（双击选择）',
                	width:'1000px',
                	url:basePath+"/icon/nodecorator/select?iconName="+iconName
                });
				break;
			}
		});
	}
	
	//初始化
	Menus.prototype.initTree = function (selectNodeId)
	{
		var _self = this;
		var treeData = null;
		ajaxPost(this.treeurl, null, function(data) {
			treeData = data;
		});
		$("#tree").treeview({
			data : treeData,
			showBorder : true,
			expandIcon : "glyphicon glyphicon-stop",
			collapseIcon : "glyphicon glyphicon-unchecked",
			levels : 1,
			onNodeSelected : function(event, data) {
				/*   alert("i am selected");
				  alert(data.nodeId); */
				_self.fillDictForm(data);
				_self.formReadonly();
				//console.log(JSON.stringify(data));
			}
		});
		if(treeData.length==0)
			return;
		//默认选中第一个节点
		selectNodeId=selectNodeId||0;
		$("#tree").data('treeview').selectNode(selectNodeId);
		$("#tree").data('treeview').expandNode(selectNodeId);
		$("#tree").data('treeview').revealNode(selectNodeId);
    }
	
	Menus.prototype.fillParentAndLevelCode = function (selectedNode)
	{
		$("input[name='parentName']").val(selectedNode?selectedNode.text:'系统菜单');
	    $("input[name='deleted'][value='0']").prop("checked","checked");
	    if(selectedNode){
	    	$("input[name='pid']").val(selectedNode.id);
			var nodes=selectedNode.nodes;
			var levelCode=nodes?nodes[nodes.length-1].levelCode:null;
			$("input[name='levelCode']").val(getNextCode(selectedNode.levelCode,levelCode,6));
	    }else{
			var parentNode=$("#tree").data("treeview").getNode(0);
			var levelCode = "000000";
			if (parentNode) {
				var brothers = $("#tree").data("treeview").getSiblings(0);
				levelCode = brothers[brothers.length - 1].levelCode;
			}
			$("input[name='levelCode']").val(getNextCode("", levelCode, 6));
	    }
	}
	
	//填充form
	Menus.prototype.fillDictForm = function (node)
	{
		var form = this.form;
		var _self = this;
		form.clearForm();
		ajaxPost(this.getUrl+"?id="+node.id,null,function(data){
			form.initFormData(data);
			_self.fillBackIconName(data.icon);
		})
	}
	
	//设置form为只读
	Menus.prototype.formReadonly = function ()
	{
		//所有文本框只读
		$("input[name],textarea[name]").attr("readonly","readonly");
		//隐藏取消、保存按钮
		$("#function-form .box-footer").hide();
		//还原新增、编辑、删除按钮样式
		$(".box-header button").removeClass("btn-primary").addClass("btn-default");
		//选择图标按钮只读
		$("#selectIcon").addClass("disabled");
		//还原校验框
		if($("function-form").data('bootstrapValidator'))
			$("function-form").data('bootstrapValidator').resetForm();
	}
	
	Menus.prototype.formWritable = function(action)
	{
		$("input[name],textarea[name]").removeAttr("readonly");
		$("#function-form .box-footer").show();
		$(".box-header button").removeClass("btn-primary").addClass("btn-default");
		$("#selectIcon").removeClass("disabled");
		if(action)
			$(".box-header button[data-btn-type='"+action+"']").removeClass("btn-default").addClass("btn-primary");
	}
	
	//回填图标
	Menus.prototype.fillBackIconName = function(icon_name)
	{
		$("#icon").val(icon_name);
		$("#icon_i").removeClass().addClass("form-control-feedback").addClass(icon_name);
	}
	
	Menus.prototype.initEdit = function () {
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
	Menus.prototype.initEditAttr = function () {
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