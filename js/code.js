
$(function(){
	var code = $('.yzm');
	if(code != null){
		code.click(function(){
			this.src='code.php?tm='+Math.random();
		})
	}
})
