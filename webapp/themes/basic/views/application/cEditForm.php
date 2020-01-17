
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
	#cEditForm{
		width:90%;
		margin:30px auto;
		background-color:white;
		min-height:100px;
		border-radius:5px;
	}
	#cEditForm input{margin:0}
	#cEditForm > div.title{
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
	#cEditForm > div.main {
		text-align:center;
	}
	#cEditForm > div.main > div.line{
		padding:10px 0;
	}
	#cEditForm > div.main > div.questions > div.block{
		padding-bottom:20px;
	}
	#cEditForm > div.main > div.questions > div.block > div.answers{
		padding-top:5px;
	}
	#cEditForm > div.main > div.questions > div.block > div.answers > div.answer{
		padding:5px 0;
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
	// change activation.
	cw.ec("#cEditForm > div.main > div.setActive > div.activate",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.isActive = $(this).parent().children("input.isActive").val();
		data.setTo = data.isActive==1?0:1;
		data.formId = $("#cEditForm > div.main > input.formId").val();
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		$(this).addClass("disabled");
		cw.post(cw.url+"setFormActive",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				setActive(result.isActive);
			}
			else
			{
				$(this).parent().children("span.info").html("Error");
			}
		},$(this));
	});
	function setActive(isActive)
	{
		$("#cEditForm > div.main > div.setActive > input.isActive").val(isActive);
		if(isActive == 1)
		{
			$("#cEditForm > div.main > div.setActive > span.status").html("isActive")
				.parent().children("div.activate").removeClass("btn-success").addClass("btn-danger").html("Deactivate");
		}
		else
		{
			$("#cEditForm > div.main > div.setActive > span.status").html("notActive")
				.parent().children("div.activate").addClass("btn-success").removeClass("btn-danger").html("Activate");
		}
	}
	// change ready
	cw.ec("#cEditForm > div.main > div.setReady > div.readyit",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.isReady = $(this).parent().children("input.isReady").val();
		data.setTo = data.isReady==1?0:1;
		data.formId = $("#cEditForm > div.main > input.formId").val();
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		$(this).addClass("disabled");
		cw.post(cw.url+"setFormReady",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				setReady(result.isReady);
				$(this).parent().children("span.info").html("The data is cached!").emptyLater();
			}
			else
			{
				$(this).parent().children("span.info").html("Error");
			}
		},$(this));
	});
	function setReady(isReady)
	{
		$("#cEditForm > div.main > div.setReady > input.isReady").val(isReady);
		if(isReady == 1)
		{
			$("#cEditForm > div.main > div.setReady > span.status").html("isReady")
				.parent().children("div.readyit").removeClass("btn-success").addClass("btn-danger").html("NotReady");
		}
		else
		{
			$("#cEditForm > div.main > div.setReady > span.status").html("notReady")
				.parent().children("div.readyit").addClass("btn-success").removeClass("btn-danger").html("Ready!");
		}
	}
	// when document ready, set the datetime picker thing
	$(document).ready(function(){

		$('#cEditForm > div.main > div.line > input.expiredTime').val("<?php echo $expiredTime?>").datetimepicker({
			//format: 'yyyy年mm月dd日',
			format: 'yyyy-mm-dd hh:ii:ss',
			weekStart: 1,
			autoclose: true,
			todayBtn: 'linked',
		//	startDate: taskStartTime, //开始时间，在这时间之前都不可选
		//	endDate: taskEndTime,//结束时间，在这时间之后都不可选
			//clearBtn:true,
			todayHighlight:true,
			minView: 1,//小时就够了
			maxView: 2,
			//language: 'zh-CN',
		});//.datetimepicker("setStartDate",taskStartTime).datetimepicker("setEndDate",taskEndTime);

		// load the question and answers
		var questions = <?php echo $questions?>;

		for(var i=0;i<questions.length;++i)
		{
			var $temp = makeQuestion(questions[i]);
			$temp.insertBefore("#cEditForm > div.main > div.questions > div.newQuestion");
		}
	});
	// save question text
	cw.ec("#cEditForm > div.main > div.questions > div.block > div.save",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}

		var data = {};
		data.text = $.trim($(this).parent().children("input.text").val());
		data.qId = $(this).parent().children("input.qId").val();
		data.formId = $("#cEditForm > div.main > input.formId").val();
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url+"saveQuestion",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			if(result.status == 0)
			{
				$(this).parent().children("span.info").html('ok').emptyLater();
			}
			else
			{
				alert("err!");
			}
		},$(this));
	});
	// delete a qustion
	cw.ec("#cEditForm > div.main > div.questions > div.block > div.delete",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.qId = $(this).parent().children("input.qId").val();
		data.formId = $("#cEditForm > div.main > input.formId").val();
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url+"deleteQuestion",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			if(result.status == 0)
			{
				$(this).parent().children("span.info").html('ok').emptyLater();
				// remove the whole thing
				$(this).parent().remove();
			}
			else
			{
				alert("err!");
			}
		},$(this));
	});
	// add a question
	cw.ec("#cEditForm > div.main > div.questions > div.newQuestion > .add",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.question = $.trim($(this).parent().children("input.text").val());
		data.formId = $("#cEditForm > div.main > input.formId").val();
		if(data.question == "")
		{
			return;
		}
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"addQuestion",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				var temp = makeQuestion(result.question);
				temp.insertBefore("#cEditForm > div.main > div.questions > div.newQuestion");
				$(this).parent().children("input.text").val("");
			}
			else
			{
				alert("err!");
			}
		},$(this));
	});
	// add an answer
	cw.ec("#cEditForm > div.main > div.questions > div.block > div.answers > div.newAnswer > .add",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.answer = $.trim($(this).parent().children("input.text").val());
		data.formId = $("#cEditForm > div.main > input.formId").val();
		data.qId = $(this).parent().parent().parent().children("input.qId").val();

		if(data.answer == "")
		{
			return;
		}
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"addAnswer",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				var temp = makeAnswer(result.answer);
				temp.insertBefore($(this).parent().parent().children("div.newAnswer"));
				$(this).parent().children("input.text").val("");
			}
			else
			{
				alert("err!");
			}
		},$(this));
	});
	// edit an answer
	cw.ec("#cEditForm > div.main > div.questions > div.block > div.answers > div.answer > div.save",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}

		var data = {};
		data.text = $.trim($(this).parent().children("input.text").val());
		data.aId = $(this).parent().children("input.aId").val();
		data.qId = $(this).parent().parent().parent().children("input.qId").val();
		data.formId = $("#cEditForm > div.main > input.formId").val();
		data.isCorrect = $(this).parent().children("input.isCorrect").prop("checked")?1:0;

		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url+"saveAnswer",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			if(result.status == 0)
			{
				$(this).parent().children("span.info").html('ok').emptyLater();
			}
			else
			{
				alert("err!");
			}
		},$(this));
	});
	// delete a answer
	cw.ec("#cEditForm > div.main > div.questions > div.block > div.answers > div.answer > div.delete",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.aId = $(this).parent().children("input.aId").val();
		data.qId = $(this).parent().parent().parent().children("input.qId").val();
		data.formId = $("#cEditForm > div.main > input.formId").val();

		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url+"deleteAnswer",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html('');
			if(result.status == 0)
			{
				$(this).parent().children("span.info").html('ok').emptyLater();
				// remove the whole thing
				$(this).parent().remove();
			}
			else
			{
				alert("err!");
			}
		},$(this));
	});
	function makeQuestion(question)
	{
		var temp = $('<div class="block" title="Create at '+question.createTime+'">'+
				'<input class="qId" type="hidden" value="'+question.qId+'"></input>'+
				'<input class="text input-medium" type="text" value="'+question.text+'"></input> <div class="btn btn-small btn-success save">save</div> <div class="btn btn-small btn-danger delete">delete</div> <span class="info text-warning"></span>'+
				'<div class="answers">'+
					'<div class="newAnswer">'+
						'<input class="input-medium text" type="text" placeholder="Enter anwser"></input>'+
						' <div class="btn btn-small btn-info add">NewA</div> <span class="text-warning info"></span>'+
					'</div>'+
				'</div>'+
			'</div>');
		for(var i=0;i<question.answers.length;++i)
		{
			var answer = makeAnswer(question.answers[i]);
			answer.insertBefore(temp.find("div.answers > div.newAnswer"));
		}
		return temp;
	}
	function makeAnswer(answer)
	{
		var checkStr = answer.isCorrect==1?'checked="checked"':"";
		return $('<div class="answer" title="Create at '+answer.createTime+'">'+
			'<input class="aId" value="'+answer.id+'" type="hidden"></input>'+
			//'<input class="isCorrect" value="'+answer.isCorrect+'" type="hidden"></input>'+
			'<input class="text input-medium" type="text" value="'+answer.text+'"></input>'+
			' isCorrect <input class="isCorrect" type="checkbox" '+checkStr+'></input> '+
			'<div class="btn btn-small btn-success save">save</div> <div class="btn btn-small btn-danger delete">delete</div> <span class="info text-warning"></span>'+
		'</div>');
	}
	// function for classroom pic upload
	function picPathError(str)
	{
		$("#cEditForm > div.main > div.picPath > span.info").html(str).emptyLater();
	}
	function picPathSuccess(data)
	{
		$("#cEditForm > div.main > div.picPath > input.picPath").val(data.url)
			.parent().children("img.preview").prop("src",data.url);
			// also save the path to form
		$("#cEditForm > div.main > div.line > div.save").trigger(cw.ectype);
	}
	// save the img and stuff
	cw.ec("#cEditForm > div.main > div.line > div.save",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.formId = $("#cEditForm > div.main > input.formId").val();
		data.name = $("#cEditForm > div.main > div.line > input.name").val();
		data.shoutkey = $.trim($("#cEditForm > div.main > div.line > input.shoutkey").val());
		data.expiredTime = $.trim($("#cEditForm > div.main > div.line > input.expiredTime").val());
		data.picPath = $.trim($("#cEditForm > div.main > div.line > input.picPath").val());
		// they can be empty
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html('<div class="loading"></div>');
		cw.post(cw.url+"saveFormInfo",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				$(this).parent().children("span.info").html("Saved").emptyLater();
			}
			else
			{
				$(this).parent().children("span.info").html("Error").emptyLater();
			}
		},$(this));
	});
	// delete the whole form
	cw.ec("div.main > div.line > div.deleteForm",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.formId = $("div.main > input.formId").val();
		if(!confirm("Confirm deleting the whole form?"))
		{
			return;
		}
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"deleteForm",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html("");
			if(result.status == 0)
			{
				window.open("<?php echo Yii::app()->baseUrl?>/index.php/admin","_self");
			}
			else
			{
				$(this).parent().children("span.info").html("error");
			}
		},$(this));
	});
</script>
<div id="cEditForm">
	<div class="title">Created at <?php echo $createTime?> by <?php echo $createBy?></div>
	<div class="main">
		<input class="formId" type="hidden" value="<?php echo $formId?>"></input>

		<div class="line setActive">
			<input class="isActive" type="hidden" value="<?php echo $isActive?>"></input>
			<span class="status muted">
				<?php echo $isActive==1?"isActive":"notActive"; ?>
			</span>
			<div class="btn btn-small activate <?php echo $isActive==0?"btn-success":"btn-danger"; ?>">
				<?php echo $isActive==0?"Activate":"Deactivate"; ?>
			</div>
			<span class="info text-warning"></span>
		</div>

		<div class="line">
			shoutkey:
			<input class="input-medium shoutkey" type="text" value="<?php echo $shoutkey?>"></input>
		</div>
		<div class="line">
			name:
			<input class="input-medium name" type="text" value="<?php echo $name?>"></input>
		</div>
		<div class="line">
			expiredTime:
			<input class="input-medium expiredTime" placeholder="Click to set" type="text" value=""></input>
		</div>
		<div class="line picPath">
			<input class="picPath" type="hidden" value="<?php echo $picPath?>"></input>
			<?php $this->widget("UploadWidget",array(
					"success" => "picPathSuccess",
					"filename" => "classroomPic",
					"error" => "picPathError",
					"maxSize" => "1024*1024*6",
					"types" => "png,jpg,gif,JPG,jpeg",
					"buttonClasses" => "btn btn-small btn-info",
					"buttonName" => "Upload Classroom"
			));?>
			<span class="info text-warning"></span>
			<img class="preview" <?php echo $picPath==""?"":"src='".$picPath."'"?> style="width:90%"></img>

		</div>
		<div class="line">
			<div class="btn btn-small btn-primary save">Save</div>
			<span class="info text-warning"></span>
		</div>
		<span class="muted">Questions:</span>
		<div class="questions line">

			<div class="newQuestion block">
				<input class="input-medium text" type="text" placeholder="Enter question"></input>
				<!--<i class="icon-plus add" style="cursor:pointer;margin-top:5px;"></i>-->
				<div class="btn btn-small btn-primary add">NewQ</div>
				<span class="text-warning info"></span>
			</div>
		</div>

		<div class="line setReady">
			<input class="isReady" type="hidden" value="<?php echo $isReady?>"></input>
			<span class="status muted">
				<?php echo $isReady==1?"isReady":"notReady"; ?>
			</span>
			<div class="btn btn-small readyit <?php echo $isReady==0?"btn-success":"btn-danger"; ?>">
				<?php echo $isReady==0?"Ready!":"NotReady"; ?>
			</div>
			<span class='muted'>When ready, will cache the whole prob</span>
			<span class="info text-warning"></span>
		</div>

		<div class="line">
			Url: <?php echo Yii::app()->baseUrl;?>?k=<?php echo urlencode($shoutkey);?>
		</div>

		<div class="line">
			<div class="btn btn-danger deleteForm">DeleteForm</div>
			<span class="info text-warning"></span>
		</div>
	</div>
</div>
<div class="footer">An <a target="_blank" href="https://github.com/JunweiLiang/Lecture_Attendance_Management">open-source project</a> designed by <a target="_blank" href="https://www.cs.cmu.edu/~junweil/">Junwei Liang</a>.</div>
