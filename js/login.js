window.onload = function(){
	code();
	//登陆验证
	var fm = document.getElementsByTagName('form')[0];
	
	fm.onsubmit = function(){
		if(fm.username.value.length<2 || fm.username.value.length>20){
			alert('昵称不得小于2位或大于20位');
			fm.username.value="";//清空
			fm.username.focus();//将焦点聚集到表单
			return false;
		}
		if(/[<>\'\"\ \  ]/.test(fm.username.value)){
			alert('昵称不得包含敏感字符');
			fm.username.value="";
			fm.username.focus();
			return false;
		}
		//密码验证
		if(fm.password.value.length<6){
			alert('密码不得小于6位');
			fm.password.value="";//清空
			fm.password.focus();//将焦点聚集到表单
			return false;
		}
		
		//验证码
		if(fm.code.value.length != 4){
			alert('验证码必须是4位');
			fm.code.value="";//清空
			fm.code.focus();//将焦点聚集到表单
			return false;
		}

	};
};
