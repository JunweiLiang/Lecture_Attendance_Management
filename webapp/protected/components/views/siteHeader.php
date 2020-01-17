<?php
	/*****************
	@author Leongchunwai<2546858999@qq.com>  in 2013.8//modified in 2013.11
	****************/
?>
<style type="text/css">
	#<?php echo $id;?>{
		background-color:<?php echo COLOR1_LIGHTER1?>;
		height:30px;
		padding:5px 0px;

		width:100%;
		-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;
	}
	div.makeupspace{
		height:30px;
		padding:5px 0;
		width:100%;
		position:relative;
	}
	#<?php echo $id;?> > a.logo{
		position:absolute;
		left:50%;
		width:300px;
		text-align:center;
		margin-left:-150px;
		font-size:1.2em;
		font-weight:bold;
		padding-top:5px;
		color:white;
		text-decoration:none;
		outline:none;
	}
	#<?php echo $id;?> > a.logo:focus{
		outline:none;
	}
	#<?php echo $id?> > span.loading{
		position:absolute;
		left:50%;
		width:20px;
		margin-left:52px;
		font-size:1.2em;
		font-weight:bold;
		padding-top:5px;
		color:white;
	}

	#<?php echo $id;?> > div.header-button,
	#<?php echo $id;?> > div.back{
		float:left;
		padding:5px 10px;
		cursor:pointer;
		margin-right:5px;
		margin-left:5px;
		height:20px;
		background-color:<?php echo COLOR1_LIGHTER2;?>;
		border-radius:3px;
		position:relative;
	}
	#<?php echo $id;?> > div.back{
		background-color:transparent;
		padding:8px;
		padding-left:0;
		padding-bottom:0px;
		display:none;
	}
	#<?php echo $id;?> > div.header-button:hover{
		background-color:<?php echo COLOR1_LIGHTER2_MORE;?>;
	}
	#<?php echo $id;?> > div.header-button > span{
		color:white;
		font-size:0.8em;
		font-weight:bold;
	}
	#<?php echo $id;?> > div.header-button > span > input.search{
		width:100px;
		background-color:transparent;
		border:0;
	}
	#<?php echo $id;?> > div.header-button.right{
		float:right;
	}
	#<?php echo $id;?> > div.header-button > span.header-icon > i{
		margin-top:2px;
	}
	#<?php echo $id;?> > div.header-button.highlight{
		background-color:<?php echo COLOR1_LIGHTER2_MORE;?>;
	}
	#<?php echo $id;?> > div.header-button.remind > div.remindSum{
		position:absolute;
		top:-4px;
		right:-3px;
		background-color:rgb(250,0,0);
		color:white;
		font-weight:bold;
		font-size:0.8em;
		width:auto!important;
		width:10px;
		min-width:10px;
		height:10px;
		line-height:10px;
		padding:3px;
		border-radius:8px;
		text-align:center;
		display:none;
	}
	#<?php echo $id?> > div.pop-up{
		position:absolute;
		border-radius:5px;
		top:45px;
		display:none;
		background-color:white;
		-moz-box-shadow:0 1px 6px #999;
 	   -webkit-box-shadow:0 1px 6px #999;
 	   box-shadow:0 1px 6px #999;
 	   z-index:999;
	}

	#<?php echo $id?> > div.pop-up.projectList,
	#<?php echo $id?> > div.pop-up.humanResource{
		left:10px;
		width:300px;
		border:1px silver solid;
	}
	#<?php echo $id?> > div.pop-up.new,
	#<?php echo $id?> > div.pop-up.profile,
	#<?php echo $id?> > div.pop-up.remind{
		right:10px;
		width:300px;
		border:1px silver solid;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list{
		padding:10px 0;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > a.block,
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > a.to{
		display:block;
		padding:5px 20px;
		font-weight:bold;
		text-decoration:none;
		color:black;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > a.block:hover,
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > a.to:hover{
		color:white;
		background-color:<?php echo COLOR1_LIGHTER1;?>;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up{
		display:none;
		padding:10px;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up input{
		margin:0;
	}
	#<?php echo $id?> > div.pop-up > div.delete{
		position:absolute;
		top:10px;
		right:2px;
		cursor:pointer;
		color:gray;
		font-weight:bold;
		width:25px;
		height:25px;
		opacity:0.9;
			filter:alpha(opacity=90);
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	}
	#<?php echo $id?> > div.pop-up > div.back{
		position:absolute;
		top:14px;
		left:15px;
		cursor:pointer;
		color:gray;
		font-weight:bold;
		width:25px;
		height:25px;
		display:none;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.title,
	#<?php echo $id?> > div.pop-up > div.title{
		text-align:center;
		padding:10px 0;
		margin:0px 10px;
		margin-bottom:5px;
		border-bottom:1px <?php echo COLORDARKER?> solid;
		color:gray;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content{
		padding:5px;
		overflow-x:hidden;
		overflow-y:auto;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content::-webkit-scrollbar {
		height: 9px;
		width: 9px;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content::-webkit-scrollbar-button {
		display: block;
		height: 5px;
		width: 5px;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content::-webkit-scrollbar-track-piece {
		background: <?php echo COLORDARK?>;
		border-radius:5px;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content::-webkit-scrollbar-thumb{
		background:<?php echo COLORDARKERER?>;
		border-radius:5px;
		display:block;
		height:10px;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content > div.block{
		margin-bottom:5px;
		background-color:<?php echo COLOR1_LIGHTER1?>;
		border-radius:3px;
		padding-left:10%;
		cursor:pointer;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content > div.block > div.projectName{
		padding:10px;
		font-weight:bold;
		border-radius:0 3px 3px 0;
		background-color:<?php echo COLOR1_LIGHTER3?>;
	}
	#<?php echo $id?> > div.pop-up.projectList > div.content > div.block:hover > div.projectName{
		background-color:<?php echo COLOR1_LIGHTER3_DARK?>;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body{
		padding:5px 0;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block{
		padding:10px;
		cursor:pointer;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block > div.title{
		font-weight:bold;
		padding:5px;
		font-size:1.2em;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block > div.subTitle{
		font-size:1em;
		color:gray;
		padding:5px;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block:hover{
		background-color:<?php echo COLOR1_LIGHTER1;?>;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block:hover > div.title{
		color:white;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item > div.body > div.block:hover > div.subTitle
	{
		color:silver;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item.addProject > div.body
	{
		padding:5%;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item.addProject > div.body > div.title{
		font-weight:bold;
		padding-bottom:5px;
		font-size:1em;
	}
	#<?php echo $id?> > div.pop-up.new > div.pop-up-item.addProject > div.body > div.line > input.projectName{
		width:95%;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content{
		padding-bottom:10px;
		word-break:break-all;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block{
		padding:10px;
		position:relative;
		font-size:0.9em;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block:hover{

	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.time{
		color:silver;
		font-size:0.8em;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.delete{
		display:none;
		z-index:994;
		position:absolute;
		top:5px;
		right:10px;
		background-color:white;
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block:hover > div.delete{
		display:block;
	}
	/*手机上ipad就直接显示*/
	@media screen and (max-device-width:1100px)
	{
		#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.delete{
			display:block;
		}
	}
	#<?php echo $id?> > div.pop-up.remind > div.content > div.block > div.line{
		padding:5px 0;
		word-break:break-all;
	}
	/*手机屏幕*/
	@media screen and (max-device-width:500px)
	{
		#<?php echo $id;?> > div.header-button{
			padding-top:7px;
			padding-bottom:3px;
		}
		#<?php echo $id;?> > div.header-button > span.header-text
		{
			display:none
		}
		#<?php echo $id;?> > div.header-button:hover{
			background-color:<?php echo COLOR1_LIGHTER2;?>;
		}
		/*弹出框*/
		#<?php echo $id?> > div.pop-up.new,
		#<?php echo $id?> > div.pop-up.profile,
		#<?php echo $id?> > div.pop-up.remind{
			right:5%;
			width:90%;
		}
		#<?php echo $id?> > div.pop-up.projectList{
			left:5%;
			width:90%;
		}
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up > div.line{
		padding:3px 0;
		position:relative;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up > div.line > div.left{
		float:left;
		width:60px;
		padding-top:3px;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up > div.line > div.right{
		margin-left:60px;
	}
	#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up > div.line > div.alertpw{
		color:red;
		font-size:0.9em;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		startLoading();
		//$("#<?php echo $id?> > input.loading").change();
	});
	//loading, stop loading
	cw.ech("#<?php echo $id?> > input.loading",function(){
		//alert("a");
		$("#<?php echo $id?> > span.loading").show();
		//startLoading();
	});
	cw.ech("#<?php echo $id?> > input.stopLoading",function(){
		$("#<?php echo $id?> > span.loading").hide();
		//startLoading();
	});
	function startLoading()
	{
		setInterval(function(){
			$Object = $("#<?php echo $id?> > span.loading");

			if($Object.html() == "")
			{
				$Object.html(".");
			}
			else if($Object.html() == ".")
			{
				$Object.html("..");
			}
			else if($Object.html() == "..")
			{
				$Object.html(".&nbsp;");
			}
			else
			{
				$Object.html("");
			}

		},300);
	}
</script>

<script type="text/javascript">
	//点击首logo的事件
	cw.ec("#<?php echo $id?> > a.logo",function(e){
		e.preventDefault();
		//window.location.reload();
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application","_self");
		/*
		<?php foreach($headerChange as $one){ ?>
				$("<?php echo $one;?>").change();
		<?php } ?>
		//隐藏返回
		$("#<?php echo $id?> > div.back").hide();
		*/
	});
</script>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	//点击profile
	cw.ec("#<?php echo $id?> > div.header-button.profile",function(){
		//alert("a");
		if($("#<?php echo $id?> > div.pop-up.profile").css("display") == "none")
		{
			//把profile内所有inpop-up 隐藏,显示按钮
			$("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up").hide();
			$("#<?php echo $id?> > div.pop-up.profile > div.list a").show();
			$("#<?php echo $id?> > div.pop-up.profile > div.back").hide();
			$("#<?php echo $id?> > div.pop-up.profile").show();
			$("#overlayPopups > input.show").change();
		}
		else
		{
			$("#<?php echo $id?> > div.pop-up.profile").hide();
			$("#overlayPopups > input.hide").change();
		}
	});
	//点击to,打开inpop-up
	cw.ec("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > a.to",function(){
		$(this).parent().children("div.inpop-up").show()
			.find("input").eq(0).focus();
		$(this).parent().parent().find('a').hide();
		//显示返回按钮
		$("#<?php echo $id?> > div.pop-up.profile > div.back").show();
	});
	//inpop-up 返回
	cw.ec("#<?php echo $id?> > div.pop-up.profile > div.back",function(){
		//把profile内所有inpop-up 隐藏,显示按钮
		$("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.inpop-up").hide();
		$("#<?php echo $id?> > div.pop-up.profile > div.list a").show();
		$(this).hide();
	});
	//确认修改名字
	cw.ec("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.changeName > div.ok",function(){
		var data = {};
		data.nickname = $(this).parent().children("input.nickname").val();
		if(data.nickname == "")
		{
			return false;
		}
		cw.post(cw.url+"changeNickname",data,function(result){

		});
		$("#<?php echo $id?> > div.pop-up.profile").children("input.nickName").val(data.nickname).end()
			.children("div.title").html(data.nickname);
		$("#<?php echo $id?> > div.header-button.profile > span.header-text").html(data.nickname);
		//触发返回
		$("#<?php echo $id?> > div.pop-up.profile > div.back").trigger(cw.ectype);
	});
	//确认修改密码
	cw.ec("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.changePw > div.ok",function(){

		var data = {};
		data.oldPw = $(this).parent().find("div.line > div.right > input.oldPw").val();
		data.newPw = $(this).parent().find("div.line > div.right > input.newPw").val();
		data.newPw1 = $(this).parent().find("div.line > div.right > input.newPw2").val();
		if($(this).hasClass("disabled") || (data.oldPw == "") || (data.newPw == ""))
		{
			return false;
		}
		if(data.newPw != data.newPw1)
		{
			setPwAlert("Passwords are not the same.");
			return;
		}
		//不检查格式了

		$(this).addClass("disabled").html("Sending request...");
		setPwAlert('<div class="wrapLoading"><div class="loading"></div></div>',true);
		cw.post(cw.url+"changePw",data,function(result){
			$(this).removeClass("disabled").html("OK");
			//
			if(result.error == 1)
			{
				setPwAlert("Original password is not correct.");
			}
			else
			{
				setPwAlert("Success");
				$(this).parent().find("input").val("");
			}
		},$(this));
	});
	function setPwAlert(str)
	{
		var noErase = arguments[1]?arguments[1]:false;
		$("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.changePw > div.line > div.alertpw").html(str);
		if(!noErase)
		{
			setTimeout(function(){
				$("#<?php echo $id?> > div.pop-up.profile > div.list > div.block > div.changePw > div.line > div.alertpw").html("");
			},3000);
		}
	}
</script>
<script type="text/javascript">
	//点击人力资源
	cw.ec("#<?php echo $id?> > div.header-button.humanResource",function(){
		if($("#<?php echo $id?> > div.pop-up.humanResource").css("display") == "none")
		{
			//载入人力资源
			$("#<?php echo $id?> > div.pop-up.humanResource > input.loadHR").change();
			$("#<?php echo $id?> > div.pop-up.humanResource").show();
			$("#overlayPopups > input.show").change();
		}
		else
		{
			$("#<?php echo $id?> > div.pop-up.humanResource").hide();
			$("#overlayPopups > input.hide").change();
		}
	});
</script>
<script type="text/javascript">
	//显示返回按钮
	cw.ech("#<?php echo $id?> > input.showBack",function(){
		//alert("ss");
		$("#<?php echo $id?> > div.back").show();
	});
	//点击返回
	cw.ec("#<?php echo $id?> > div.back",function(){
		$("#<?php echo $id?> > a.logo").trigger(cw.ectype);
	});
	cw.ech("#<?php echo $id?> > input.closePopup",function(){
		//alert('d');
		$("#<?php echo $id?> > div.pop-up").hide();
	});
	//点击logo
	cw.ec("#<?php echo $id?> > a.logo",function(){
		window.location.hash = "";
	});
</script>
<script type="text/javascript">

	// click help
	cw.ec("#<?php echo $id?> > div.header-button.help",function(){
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/cHelp","_self");
	});
</script>
<div class="makeupspace"></div>
<div id="<?php echo $id;?>">
	<?php $this->widget("OverlayWidget",array(
			"zindex" => "998",
			"id" => "overlayPopups",
			"transparent" => true,
			"targetSelector" => "#".$id." > input.closePopup",
		));?>
	<input class="closePopup" type="hidden"></input>
	<input class="showBack" type="hidden"></input>
	<input class="loading" type="hidden"></input>
	<input class="stopLoading" type="hidden"></input>
	<a class="logo" title="home" href="<?php echo Yii::app()->baseUrl;?>/">
		CheckIn
	</a>
	<span class="loading" style="display:none"></span>
	<?php /*按钮，全部float*/
	?>
	<!--
	<div class="header-button projectList">
		<span class="header-icon"><i class="icon-th-large icon-white"></i></span>
		<span class="header-text">项目列表</span>
	</div>
	-->
	<div class="back">
		<i class="icon-chevron-left"></i>
	</div>

	<div class="header-button right profile">
		<span class="header-icon"><i class="icon-th-large icon-white"></i></span>
		<span class="header-text"><?php echo $username;?></span>
	</div>
	<!--
	<div class="header-button right help">
		<span class="header-icon"><i class="icon-exclamation-sign icon-white"></i></span>
		<span class="header-text">Help</span>
	</div>-->

	<?php if($userLevel == 3){ //高级用户 ?>

	<?php } ?>

	<?php /*下面是各种弹出框*/ ?>
	<div class="pop-up remind">
		<div class="delete close">&times;</div>
		<div class="title">Message</div>
		<div class="content"><div class='wrapLoading'><div class='loading'></div></div></div>
	</div>


	<div class="pop-up humanResource">
		<div class="delete close">&times;</div>
		<div class="title">Human Resource</div>
		<input class="loadHR" type="hidden"></input>
		<div class="content">
			<?php
			/*
				$this->widget("HumanResourceWidget",array(
					"id" => $id."humanResource",
					//监听载入
					"listen" => "#".$id." > div.pop-up.humanResource > input.loadHR",
					//有修改功能
					"canEdit" => true,
					"noHeader" => true,
				));
				*/
			?>
		</div>
	</div>
	<div class="pop-up profile">
		<div class="close back"><i class="icon-chevron-left"></i></div>
		<div class="delete close">&times;</div>
		<div class="title"><?php echo $username;?></div>
		<input class="nickName" type="hidden" value="<?php echo $username;?>"></input>
		<div class="list">
			<div class="block">
				<a class="to" href="#">Change Nickname</a>
				<div class="changeName inpop-up">
					<input class="input-medium nickname" type="text" value="<?php echo $username;?>"></input>
					<div class="btn ok">OK</div>
				</div>
			</div>
			<div class="block">
				<a class="to" href="#">Change Password</a>
				<div class="changePw inpop-up">
					<div class="line">
						<div class="left">Original</div>
						<div class="right">
							<input class="input-medium oldPw" type="password" value=""></input>
						</div>
					</div>
					<div class="line">
						<div class="left">New</div>
						<div class="right">
							<input class="input-medium newPw" type="password" value=""></input>
						</div>
					</div>
					<div class="line">
						<div class="left">Again</div>
						<div class="right">
							<input class="input-medium newPw2" type="password" value=""></input>
						</div>
					</div>
					<div class="line">
						<div class="alertpw"></div>
					</div>
					<div class="btn btn-block ok">OK</div>
				</div>
			</div>

			<a class="block" href="<?php echo Yii::app()->baseUrl;?>/index.php/user/logout">Logout</a>
		</div>
	</div>

</div>
