<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>php-ajax无刷新上传(带进度条)demo</title>
<meta name="description" content="" />
<script type="text/javascript" src="js/jquery-3.0.0.min.js" ></script>
<script type='text/javascript' src='js/jquery.form.js'></script>
<link href="css/load.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div style="width:500px;margin:10px auto; border:solid 1px #ddd; overflow:hidden; ">
  <form id='myupload' action='upload.php' method='post' enctype='multipart/form-data'>
    <input type="file" id="uploadphoto" name="uploadfile" value="请点击上传图片"  style="display:none;" />
  </form>
  <div class="imglist"><img src="img/face.jpg" /> </div>
  <p class="res"></p>
  <div class="progress">
    <div class="progress-bar progress-bar-striped" ><span class="percent">50%</span></div>
  </div>
  <a href="javascript:void(0);" onclick="uploadphoto.click()" class="uploadbtn">点击上传文件</a>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
   var progress = $(".progress"); 
   var progress_bar = $(".progress-bar");
   var percent = $('.percent');
   $("#uploadphoto").change(function(){
  	 $("#myupload").ajaxSubmit({ 
  		dataType:  'json', //数据格式为json 
  		beforeSend: function() { //开始上传 
  			progress.show();
  			var percentVal = '0%';
  			progress_bar.width(percentVal);
  			percent.html(percentVal);
  		}, 
  		uploadProgress: function(event, position, total, percentComplete) { 
  			var percentVal = percentComplete + '%'; //获得进度 
  			progress_bar.width(percentVal); //上传进度条宽度变宽 
  			percent.html(percentVal); //显示上传进度百分比 
  		}, 
  		success: function(data) {
			 
			if(data.status == 1){
				var src = data.url;  
//				var attstr= '<img src="'+src+'">';  
//				$(".imglist").append(attstr);
				$(".imglist img").attr('src',src);
				
			}else{
				$(".res").html(data.content);
			}
  			progress.hide();		
  		}, 
  		error:function(xhr){ //上传失败 
  		   alert("上传失败"); 
  		   progress.hide(); 
  		} 
  	}); 
   });

});
</script>
</body>
</html>