<?php
    /*
     * runtime()用来获取执行耗时
     */
    function runtime(){
        $_mtime = explode(' ',microtime());
        return $_mtime[1] + $_mtime[0];
    }
	/*
	 * _alert_back表示js弹窗
	 */
	function _alert_back($_info){
		echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
		exit();
	}
	
	
	function _alert_close($_info){
		echo "<script type='text/javascript'>alert('".$_info."');window.close();</script>";
		exit();
	}
	
	function _check_code($_first_code,$_end_code){
		if($_first_code != $_end_code){
			_alert_back('验证码不正确！');
		}
	}
	
	
	function _sha1_uniqid(){
		return sha1(uniqid(rand(),TRUE));
	}
	
	function _location($_info,$_url){
		if(!empty($_info)){
			echo "<script type='text/javascript'>alert('".$_info."');location.href='$_url';</script>";
			exit();
		}else{
			header('location:'.$_url);
		}
		
	}
	
	/*
	 * 删除cookies
	 */
	function _unsetcookies(){
		setcookie('username','',time()-1);
		setcookie('uniqid','',time()-1);
		session_destroy();
		_location(null, 'index.php');
	}
	
	/*
	 * _login_state登录状态的判断
	 */
	function _login_state(){
		if(isset($_COOKIE['username'])){
			_alert_back('登录状态无法进行本操作');
		}
	}
	
	
	
	function _page($_sql,$_size){
		global $_page,$_pagesize,$_pagenum,$_pageabsolute,$_num;
		if(isset($_GET['page'])){
			$_page = $_GET['page'];
			if(empty($_page) || $_page<=0 || !is_numeric($_page)){
				$_page = 1;
			}else{
				$_page = intval($_page);//intval取得一个小数的整数部分
			}
		}else{
			$_page=1;
		}
		
		//首页得到所有的数据总和
		$_pagesize = $_size;
		$_num = _num_rows(_query($_sql));
		
		if($_num == 0){
			$_pageabsolute=1;
		}else{
			$_pageabsolute = ceil($_num/$_pagesize);
		}
		if($_page>$_pageabsolute){
			$_page = $_pageabsolute;
		}
		$_pagenum = ($_page - 1)*$_pagesize;
	
	}
	
	
	
	/*
	 * 分页函数，返回分页
	 */
	function _paging($_type){
		global $_page,$_pageabsolute,$_num,$_id;
		if($_type==1){
			echo '<div id="page_num">';
        	echo '<ul>'	;
			for($i=0;$i<$_pageabsolute;$i++){
				if($_page == ($i+1)){
					echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
				}else{
					echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
				}
				
			}
        	echo '</ul>';
        	echo '</div>';
		}elseif($_type == 2){
			echo '<div id="page_text">';
        	echo '<ul>'	;
        	echo '<li>'.$_page.'/'.$_pageabsolute.'页 &nbsp;|&nbsp;</li>';		
        	echo '<li>共有<strong>'.$_num.'</strong>条数据	&nbsp;|&nbsp;</li>';
        			
			if($_page == 1){
				echo '<li>首页 &nbsp;|&nbsp;</li>';
				echo '<li>上一页 &nbsp;|&nbsp;</li>';
			}else{
				echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'">首页 </a>&nbsp;|&nbsp;</li>';
				echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.($_page-1).'">上一页</a>&nbsp;|&nbsp;</li>';
			}
			if($_page == $_pageabsolute){
				echo '<li>下一页 &nbsp;|&nbsp;</li>';
				echo '<li>尾页 &nbsp;|&nbsp;</li>';
			}else{
				echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.($_page+1).'">下一页 </a>&nbsp;|&nbsp;</li>';
				echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
			}
        			
        	echo '</ul>';	
        	echo '</div>';
		}else{
			_paging(2);
		}
	}
	
	/*
	 * _html()函数表示对字符串进行html过滤显示，如果是数组按数组的方式过滤，
	 * 如果是单独的字符串，那么久按单独的字符串过滤
	 */
	function _html($_string){
		if(is_array($_string)){
			foreach($_string as $key => $_value){
				$_string[$key] = htmlspecialchars($_value);
			}
		}else{
			$_string = htmlspecialchars($_string);
		}
		return $_string;
	}
	
	/*
	 * 判断唯一标识符异常
	 */
	
	function _uniqid($_mysql_uniqid,$_cookie_uniqid){
		if($_mysql_uniqid != $_cookie_uniqid){
			_alert_back("唯一标识符异常");
		}
	}
	
	/*
	 * _title()标题截取函数
	 */
	function _title($_string,$_strlen){
		if(mb_strlen($_string,'utf-8')>$_strlen){
			$_string = mb_substr($_string, 0,$_strlen,'utf-8').'...';
		}
		return $_string;
	}
	
	
	function _get_xml($_xmlfile){
		
		$_html = array();
		if(file_exists($_xmlfile)){
			$_xml = file_get_contents($_xmlfile);
			preg_match_all('/<vip>(.*)<\/vip>/s', $_xml,$_dom);
			foreach($_dom[1] as $_value){
				preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
				preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
				preg_match_all('/<sex>(.*)<\/sex>/s',$_value,$_sex);
				preg_match_all('/<face>(.*)<\/face>/s',$_value,$_face);
				preg_match_all('/<email>(.*)<\/email>/s',$_value,$_email);
				preg_match_all('/<url>(.*)<\/url>/s',$_value,$_url);
				
				$_html['id'] = $_id[1][0];
				$_html['username'] = $_username[1][0];
				$_html['sex'] = $_sex[1][0];
				$_html['face'] = $_face[1][0];
				$_html['email'] = $_email[1][0];
				$_html['url'] = $_url[1][0];
			}
		}else{
			echo '文件不存在！';
		}
		return $_html;
	}
	
	
	
	function _set_xml($_xmlfile,$_clean){
		$_fp=@fopen('new.xml', 'w');
		if(!$_fp){
			exit('系统错误，文件不存在！');
		}
		flock($_fp, LOCK_EX);
		$_string = "<?xml version=\"1.0\" encoding=\"utf8\"?>\r\n";
		fwrite($_fp, $_string,strlen($_string));
		$_string="<vip>\r\n";
		fwrite($_fp, $_string,strlen($_string));
		
		$_string="\t<username>{$_clean['username']}</username>\r\n";
		fwrite($_fp, $_string,strlen($_string));
		
		$_string="\t<face>{$_clean['face']}</face>\r\n";
		fwrite($_fp, $_string,strlen($_string));
		
		$_string="</vip>\r\n";
		fwrite($_fp, $_string,strlen($_string));
		
		flock($_fp, LOCK_UN);
		fclose($_fp);
	}
	
	
	function _ubb($_string){
		$_string = nl2br($_string);
		$_string = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U', '<span style="font-size:\1px">\2</span>', $_string);
		$_string = preg_replace('/\[b\](.*)\[\/b\]/U', '<strong>\1</strong>', $_string);
		$_string = preg_replace('/\[i\](.*)\[\/i\]/U', '<i>\1</i>', $_string);
		$_string = preg_replace('/\[u\](.*)\[\/u\]/U', '<span style="text-decoration: underline;">\1</span>', $_string);
		$_string = preg_replace('/\[color=(.*)\](.*)\[\/color\]/U', '<span style="color:\1">\2</span>', $_string);
		$_string = preg_replace('/\[email\](.*)\[\/email\]/U', '<a href="mailto:\1">\2</a>', $_string);
		$_string = preg_replace('/\[img\](.*)\[\/img\]/U', '<img src="\1" />', $_string);
		return $_string;
	}
	
?>






