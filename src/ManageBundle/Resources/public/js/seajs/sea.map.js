(function(){
	//取配置对象及缓存版本
	var map = document.getElementById("jsConfig")
		,v = (map&&map.src||"").split("?")
		,v = v.length>0?v[1]||"":""
	var cfg = {
			//文件目录bundles/
			base: jsbase,
			//js文件绝对路径
			alias: {
				//jquery路径				
				"jquery"			: "core/js/jquery/jquery-1.11.1.min.js"
				,"bootstrap"		: "core/js/bootstrap/bootstrap.min.js"
				,"bootstrapcss"		: "core/css/bootstrap.min.css"
				,"bootstrap-theme" 	: "core/css/bootstrap-theme.min.css"
				,"fawesomecss"		: "core/css/font-awesome.min.css"
			},
			
			// 预加载项
			preload: ["jquery"
			          , "bootstrap"
			          , "bootstrapcss"
			          , "bootstrap-theme"
			          , "fawesomecss"],
			
			// 文件编码
			charset: 'UTF-8'
		}
	//转换网址
	for(var c in cfg.alias){
		cfg.alias[c] += v&&("?"+v);
	}

	try{
		//配置系统
		seajs.config(cfg);
	}catch(e){};
})();
