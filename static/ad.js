	function ref(){
		if(t>1){
			t=t-1;
			$("#time").html(t);
		}else if(t==0){
			var url=$("#url_value").attr("href");
			window.location.href=url;
		}
	}
	var t=5;//设置跳转后的时间
	setInterval("ref()",1000);
