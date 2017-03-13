
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
	<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<title>onedrive_share</title>
	<style type="text/css">
		img{
			max-width:66%;
		}
		body{
			
			background-color: #FCFAFA;
			background-repeat: no-repeat;
			background-position: top;
		}
	</style>
</head>
<?php 
	define('PASS', '123');//为空则不验证
	define('SIZE', 10000000);//结算单位B
	session_start();
	if(defined("PASS")){
		if(!isset($_SESSION['user'])){
			if(isset($_POST['PASS'])&&$_POST['PASS']==PASS){
				$_SESSION['user']='user';
			}else{
?>
	<div class="container">
		<div class="col-md-6 col-md-offset-2" style="margin-top:200px;background-color: #FFFFFF;border-radius: 10px; padding: 20px;">
			<h3 class="text-center">onedrive_share</h3>
			<form method="post" action="">
				<div class="input-group">
					<input type="password" name="PASS" class="form-control">
					<div class="input-group-btn">
						<button class="btn btn-success">登入</button>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php
					return;
			}		
		}
	}





?>

<body>
	<div class="container">
		<div class="col-md-8 col-md-offset-2" style="padding: 40px;margin-top:200px;border-radius: 10px;background-color: #FFFFFF" >
			<h3 class="text-center">onedrive_share</h3>
			<form action="" method="post" enctype="multipart/form-data" >
				<div class="input-group">
					<input type="file" name="file" class="form-control">
					<div class="input-group-btn">	
						<button class="btn btn-success">up</button>
					</div>
				</div>
			</form>
			<div class="row">
		<?php
			if(isset($_FILES['file']['name'])){
				$upfi=new onedrive();
				$bt=$upfi->upload();	
		?>
				<div class="text-center" style="margin: 30px;">
						<?php echo $bt ?>	
				</div>
			</div>
		</div>
	</div>
		<?php } ?>
	

</body>
</html>
<?php
	class onedrive{
		public $hash;
		function __construct()
		{
			
		}
		function upload(){
			if($this->size_jugg()){
				$dir=$this->dir();
				$this->move($dir);
				$url=$this->filecreate($dir);
				$this->unlink($dir);
				return $url;
			}
		}
		protected function mkdir(){
			mkdir("./hash/".$this->hash);
		}
		protected function filecreate($dir){
			$this->mkdir();
			$header=@file_get_contents("./static/header.html");
			$footer=@file_get_contents("./static/footer.html");
			$url=$this->onedrive($dir);
			$share_url="http://".$_SERVER['HTTP_HOST']."/hash/".$this->hash;//如果是HTTPS请自行修改
			$a="<a href=\"".$url."\" id=\"url_value\">".$url."</a>";
			$re="点击此处下载: <a href=\"".$share_url."\" id=\"url_value\">下载链接</a>";
			$page=$header.$a.$footer;
			$status=@file_put_contents("./hash/".$this->hash."/index.html", $page);
			return $re;
		}
		protected function size_jugg(){
			if($_FILES['file']['size']<SIZE){
				return true;
			}else{
				return false;
			}
		}
		protected function filename(){
			$name_array=explode(".", $_FILES['file']['name']);
			$ex=array_pop($name_array);
			$fn=md5($_FILES['file']['tmp_name']);
			$this->hash=$fn;
			return $fn.".".$ex;
		}
		protected function move($dir){
			move_uploaded_file($_FILES['file']['tmp_name'], $dir);
		}
		protected function dir(){
			$filename=$this->filename();
			return "./download/".$filename;
		}
		protected function onedrive($dir){
		
			$filename=$this->filename();
			$dir=dirname(__FILE__)."/download/".$filename;
			$sx="/usr/local/bin/onedrive ".$dir." ".$filename;
			@exec($sx);
			$url=exec("/usr/local/bin/onedrive --link ".$filename);//返回URL
			return $url;
		}
		protected function unlink($dir){
			unlink($dir);
		}

	}


?>
