
<?php $this->widget('SiteHeaderWidget',array(
	"id" => "siteHeader",
	"username" => $this->paramForLayout['nickname'],
	"userLevel" => $this->paramForLayout['userLevel'],
	"headerChange" =>array(
		//"#cIndex > #projectList > input.project",//点击首logo就获取新项目列表
		//"#cIndex > input.toProjectList",//点击首logo后显示项目列表部件
		//"#cIndex > input.gotoDatasetList",
	),//点击头导航的发生的事件
	//"targetName" => "#cIndex > #projectList > input.project",
	"targetChange" => array(
	//	"#cIndex > #projectList > input.project",//新建了项目后就获取新项目列表
	//	"#cIndex > input.toProjectList",//新建了项目后显示项目列表部件
	),
	//点击项目列表中的项目
		"targetProjectId" => "#cIndex > #project > input.projectId",
		"targetProjectName" => "#cIndex > #project > input.projectName",
		"targetProjectIntro" => "#cIndex > #project > input.projectIntro",
		"targetChangeP" => array(
			"#cIndex > #project > input.projectId",//点击了项目后载入项目内容
			"#cIndex > input.toProject",//点击了项目后显示项目部件
		),
)); ?>
<style type="text/css">
	#cMainPage{
		width:90%;
		margin:30px auto;
		background-color:white;
		min-height:100px;
		border-radius:5px;
	}
	#cMainPage input{margin:0}
	#cMainPage > div.title{
		padding:10px;
		font-weight:bold;
		font-size:1.1em;
		color:gray;
		border-bottom:1px silver solid;
		margin-bottom:10px;
		text-align:center;
	}
	#siteHeader{
		position:fixed;
		top:0;
		left:0;
		z-index:9999;
	}
	#cMainPage > div.new {
		padding:5px;
		margin:10px 2%;
		background-color:rgb(105,196,211);
		border-radius:5px;
	}
	#cMainPage > div.new > div.addNew{
		text-align:center;
		padding:5px;
		cursor:pointer;
	}
	#cMainPage > div.new > div.newContent{
		line-height:30px;
		text-align:center;
	}
	#cMainPage > div.new > div.newContent > input.shoutkey{
		width:70%;
	}
	#cMainPage > div.formList{
		padding:0px 2%;
		padding-bottom:30px;
	}
	#cMainPage > div.formList > div.block{
		margin:10px 0;
		background-color:rgb(240,240,240);
		border-radius:5px;
		box-shadow:1px 1px 1px silver;
		padding:10px;
		text-align:center;

	}
	div.footer{
		font-weight:bold;
		font-size:0.8em;
		color:gray;
		text-align:center;
		padding:5px 0;
	}
</style>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	// get the form list
	var s = 0;
	var l = 10;
	$(document).ready(function(){
		loadFormList(s,l);
		s+=l;
	});
	// more
	cw.ec("#cMainPage > div.formList > div.showMore",function(){
		loadFormList(s,l);
		s+=l;
	});
	function loadFormList(s,l)
	{
		var data ={};
		// show the loading
		$("#cMainPage > div.formList").append('<div class="wrapLoading"><div class="loading"></div></div>');
		cw.post(cw.url+"getFormList?s="+s+"&l="+l,data,function(result){
			$("#cMainPage > div.formList > div.wrapLoading").remove();
			$("#cMainPage > div.formList > div.showMore").remove();
			if(result.status == 0)
			{
				for(var i = 0;i<result.formList.length;++i)
				{
					$("#cMainPage > div.formList").append(makeOneForm(result.formList[i]));
				}
				if(result.formList.length == l)
				{
					$("#cMainPage > div.formList").append('<div class="btn btn-small btn-info btn-block showMore">More</div>');
				}
				else if(result.formList.length == 0)
				{
					// no more things
					$("#cMainPage > div.formList").append('<div class="wrapLoading">No more form.</div>');
				}
			}
			else
			{
				$("#cMainPage > div.formList").append("<div class='wrapLoading'>Error. Please refresh page.</div>")
			}
		});
	}
	// click the new
	cw.ec("#cMainPage > div.new > div.addNew",function(){
		$(this).parent().children("div.newContent").slideToggle();
	});
	// new shoutkey
	cw.ec("#cMainPage > div.new > div.newContent > div.createNew",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.shoutkey = $.trim($(this).parent().children("input.shoutkey").val());
		if(data.shoutkey == "")
		{
			return;
		}
		$(this).addClass("disabled");
		cw.post(cw.url+"createNewForm",data,function(result){
			$(this).removeClass("disabled");
			if(result.status == 0)
			{
				// go the the edit page
				window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/editForm?formId="+result.formId,"_self");
			}
			else
			{
				alert("error!");
			}
		},$(this));

	});
	function makeOneForm(data)
	{
		return $('<div class="block" title="By '+data.userName+'">'+
			'<input class="selected" type="checkbox"></input> '+
			(data.isActive==1?"<span class='text-success'>[Active]</span> ":"")+
			'<input class="formId" type="hidden" value="'+data.id+'"></input>'+
			"("+data.shoutkey+") "+cw.showTime(data.createTime,1)+
			' <a class="btn btn-small edit" href="<?php echo Yii::app()->baseUrl?>/index.php/application/editForm?formId='+data.id+'" target="_self">Edit</a> '+
			' <a class="" href="<?php echo Yii::app()->baseUrl?>/index.php/application/checkSubmit?formId='+data.id+'" target="_self"><i class="icon-eye-open" style="margin-top:5px"></i></a> '+
			(data.isReady==0?"<span class='text-warning'>[NotReady!]</span> ":"")+
		'</div>');
	}
	// get satt for a list of forms
	cw.ec("#cMainPage > div.title > div.getStat",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		// get all selected form
		data.formIds = new Array();
		$("#cMainPage > div.formList > div.block > input.selected:checked").each(function(){
			var formId = parseInt($(this).parent().children("input.formId").val());
			data.formIds.push(formId);
		});
		if(data.formIds.length == 0)
		{
			$("#cMainPage > div.title > span.info").html("Please select one form at least").emptyLater();
			return;
		}
		//console.log(data);
		$(this).addClass("disabled");
		$("#cMainPage > div.title > span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"getStats",data,function(result){
			$(this).removeClass("disabled");
			$("#cMainPage > div.title > span.info").html("");
			//alert(result.debug);
			window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/showStats?statId="+result.statId,"_self");
		},$(this));
	})
</script>
<div id="cMainPage">
	<div class="title">Question Form List
		<div class="btn btn-small btn-success getStat">Get stat</div>
		<span class="info text-info"></span>
	</div>
	<div class="new">
		<div class="newContent" style="display:none">
			<input class="input-medium shoutkey" type="text" placeholder="Enter shoutkey"></input>
			<div class="btn btn-small btn-success createNew">New</div>
		</div>
		<div class="addNew"><i class='icon-plus icon-white'></i></div>
	</div>
	<div class="formList">

	</div>
</div>

<div class="footer">An <a target="_blank" href="https://github.com/JunweiLiang/Lecture_Attendance_Management">open-source project</a> designed by <a target="_blank" href="https://www.cs.cmu.edu/~junweil/">Junwei Liang</a>.</div>
