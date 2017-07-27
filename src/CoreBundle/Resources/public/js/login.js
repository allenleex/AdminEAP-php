/**
 * Created with JetBrains WebStorm.
 * User: Anday
 * Date: 17-07-04
 * Time: 上午11:24
 * To change this template use File | Settings | File Templates.
 */
define(function (require, exports, module) {
	var self;
    (function(out){
        module.exports=out;
    }) ({
         init:function(page,par){
             //this[page](par);

            //初始化加載的腳本
             try{
                self = this;
                self[page](par);
             }catch(e) {
            	 alert("JS脚本错误！","error");
             }
         }

        //登陸界面Js
        ,main:function(){
        	$("body").fadeIn();
        	$(".container").fadeIn(1500);
        	//alert('login');
        }
    })

});