
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
	#cShowStats{
		width:90%;
		margin:30px auto;
		background-color:white;
		min-height:100px;
		border-radius:5px;
	}
	#cShowStats input{margin:0}
	#cShowStats > div.title{
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
	#cShowStats > div.stats{
		padding:10px;
	}
	#cShowStats > div.stats > div.ctr{
		padding:10px
	}
	#cShowStats > div.stats > div.info{
		padding:10px;
		border-bottom:1px silver solid;
	}
	#cShowStats > div.stats > div.userList{
		padding:30px;
		line-height:30px;
	}
	#cShowStats > div.stats > div.specs{
		border-top:1px silver solid;
		padding:10px;
		margin:10px;
	}
	#cShowStats > div.stats > div.specs > div.block,
	#cShowStats > div.stats > div.charts > div.chart > div.blocks > div.block{
		padding:10px;
		border-bottom:1px silver solid;
		position:relative;
	}
	#cShowStats > div.stats > div.specs > div.block > div.checkThisGuy,
	#cShowStats > div.stats > div.charts > div.chart > div.blocks > div.block > div.checkThisGuy{
		position:absolute;
		top:10px;
		right:20px;
	}
	#cShowStats > div.stats > div.charts > div.chart > div.blocks > div.block.highlighted{
		background-color:yellow;
	}
	#cShowStats > div.stats > div.stuff textarea{
		width:600px;
		height:300px;
	}
	#cShowStats > div.stats > div.stuff > div.allAndrewIds{
		margin:0 0 0 650px;
	}
	#cShowStats > div.stats > div.stuff > div.excuseNote{
		float:left;
		width:600px;
	}
	#cShowStats > div.stats > div.charts > div.att{
		float:left;
		width:50%;
	}
	#cShowStats > div.stats > div.charts > div.acc{
		margin:0 0 0 50%;
	}
	#cShowStats > div.stats > div.charts > div.chart{
		padding:50px 0;
	}
	#cShowStats > div.stats > div.charts > div.chart > div.title{
		border-bottom:1px silver solid;
		padding:10px;
	}
	#cShowStats > div.stats > div.charts > div.chart > div.graph{
		width:90%;height:400px;margin:0px;
	}
	#pictureModal > div.modal-body > div.picArea{
		padding:20px;
	}
	#pictureModal > div.modal-body > div.picArea > div.pic{
		position:relative;
	}
	/* the canvas on top of a pic*/
	#locator{
		position:absolute;
		width:100%;
		height:100%;
		top:0;
		left:0;
		z-index:999;
	}
	#pictureModal > div.modal-header > h2 > div.picSelection{
		padding:5px;
		min-height:25px;
	}
	#pictureModal > div.modal-header > h2 > div.picSelection > div.block{
		padding:3px 20px;
		display:inline-block;
		float:left;
		border:1px silver solid;
		cursor:pointer;
	}
	#pictureModal > div.modal-header > h2 > div.picSelection > div.block.selected{
		background-color:yellow;
	}
</style>
<script type="text/javascript">
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	var stats = <?php echo $statData;?>;
	$(document).ready(function(){
		//console.log(stats);
		// stats.users.andrewId ->
		// stats.forms.formId -> info+image
		// build the info for each user first
		$("#cShowStats > div.stats > div.info > span.totalLect").html(stats.totalForm);
		$("#cShowStats > div.stats > div.info > span.totalStu").html(Object.keys(stats.users).length);

		makeSpecs('attendRate');
		// if all andrewId not empty , calculate that
		if($("#cShowStats > div.stats > div.stuff > div.allAndrewIds > textarea").val() != "")
		{
			$("#cShowStats > div.stats > div.stuff > div.allAndrewIds > div.cal").trigger(cw.ectype);
		}

		// draw graph!!
		// get attendance bucket
		var att_bucket = new Array();
		var att_bin = <?php echo $att_bin?>;
		for(var i=1;i<=stats.totalForm;i+=att_bin)
		{
			att_bucket.push({
				"att_min":i,
				"att_max":i+att_bin,
				"studs":new Array(),
				"label":i+"<"+(i+att_bin)
			});
		}

		// the acc bucker
		var acc_bucket = new Array();
		var acc_bin = <?php echo $acc_bin?>;
		for(var i=0.0;i<=1.0;i+=acc_bin)
		{
			acc_bucket.push({
				"acc_min":i,
				"acc_max":i+acc_bin,
				"studs":new Array(),
				"label":i.toFixed(2)+"<"+(i+acc_bin).toFixed(2)
			});
		}
		// go through all user, each user check for each bucket,
		// assume bucket asc
		for(var aId in stats.users)
		{
			var student = stats.users[aId];
			// for att bucket
			for(var j=0;j<att_bucket.length;++j)
			{
				if((student['totalAttend'] >= att_bucket[j]['att_min']) && (student['totalAttend'] < att_bucket[j]['att_max']))
				{
					att_bucket[j]['studs'].push(student);
					break;
				}
			}
			// for acc bucket
			for(var j=0;j<acc_bucket.length;++j)
			{
				if((student['avgAcc'] >= acc_bucket[j]['acc_min']) && (student['avgAcc'] < acc_bucket[j]['acc_max']))
				{
					acc_bucket[j]['studs'].push(student);
					break;
				}
			}
		}
		//console.log(att_bucket);
		// now that we have the buckets, make two graphs
		var att_points = new Array();
		var total =0;
		for(var i=0;i<att_bucket.length;i++)
		{
			if(att_bucket[i]['studs'].length!=0)
			{
				att_points.push({
					"label":att_bucket[i]['label'],
					"y":att_bucket[i]['studs'].length,
					"studs":att_bucket[i]['studs']
				});
			}
			total+=att_bucket[i]['studs'].length;
		}
		//sanity check
		if(total!=Object.keys(stats.users).length)
		{
			alert("warning, Att point not enough");
		}
		var acc_points = new Array();
		var total =0;
		for(var i=0;i<acc_bucket.length;i++)
		{
			if(acc_bucket[i]['studs'].length!=0)
			{
				acc_points.push({
					"label":acc_bucket[i]['label'],
					"y":acc_bucket[i]['studs'].length,
					"studs":acc_bucket[i]['studs']
				});
			}
			total+=acc_bucket[i]['studs'].length;
		}
		//sanity check
		if(total!=Object.keys(stats.users).length)
		{
			alert("warning, Acc point not enough");
		}
		//console.log(att_points);
		//console.log(acc_points);
		var att_graph_opt = {
			"title":{
				"text":"Attendance graph"
			},
			axisX:{
		        title: "Attendance Count"
		    },
		    axisY:{
		        title: "Student Count"
		    },

			animationEnabled: true,
			"data":[
				{
					"type":"column",
					"myType":"att",
					"dataPoints":att_points,
					"click":checkGroup/*function(e){
						alert(  "dataSeries Event => Type: "+ e.dataSeries.myType+ ", dataPoint { x:" + e.dataPoint.x + ", y: "+ e.dataPoint.studs + " }" );
					}*/
				}
			],
		};

		var acc_graph_opt = {
			"title":{
				"text":"Accuaracy graph"
			},
			animationEnabled: true,
			axisX:{
		        title: "Accuracy bin"
		    },
		    axisY:{
		        title: "Student Count"
		    },
			"data":[
				{
					"type":"column",
					"myType":"acc",
					"dataPoints":acc_points,
					"click":checkGroup/*function(e){
						alert(  "dataSeries Event => Type: "+ e.dataSeries.type+ ", dataPoint { x:" + e.dataPoint.x + ", y: "+ e.dataPoint.studs + " }" );
					}*/
				}
			],
		};
		var att_graph = new CanvasJS.Chart("att_graph",att_graph_opt);
		att_graph.render();
		var acc_graph = new CanvasJS.Chart("acc_graph",acc_graph_opt);
		acc_graph.render();
	});
	// when click a group on the group
	function checkGroup(e)
	{
		var graphType = e.dataSeries.myType;
		var students = e.dataPoint.studs;
		var groupName = e.dataPoint.label;
		// sort the users by name
		students = sortUsers(students,"name",true);//true asc
		// remove all highlights
		$("#cShowStats > div.stats > div.charts > div.chart > div.blocks > div.block").removeClass("highlighted");
		if(graphType == "att")
		{
			$("#cShowStats > div.stats > div.charts > div.att > div.title > span.groupName").html(groupName);
			// remove this graph blocks

			$("#cShowStats > div.stats > div.charts > div.att > div.blocks").html("");
			for(var i=0;i<students.length;++i)
			{
				$("#cShowStats > div.stats > div.charts > div.att > div.blocks").append(makeUserBlock(students[i],i+1,1));
			}
		}
		else
		{
			$("#cShowStats > div.stats > div.charts > div.acc > div.title > span.groupName").html(groupName);
			// remove this graph blocks
			$("#cShowStats > div.stats > div.charts > div.acc > div.blocks").html("");
			for(var i=0;i<students.length;++i)
			{
				$("#cShowStats > div.stats > div.charts > div.acc > div.blocks").append(makeUserBlock(students[i],i+1,1));
			}
		}
	}
	// highlight the same person in both group
	cw.ec("#cShowStats > div.stats > div.charts > div.chart > div.title > div.highlight",function(){
		$("#cShowStats > div.stats > div.charts > div.chart > div.title > div.info").html("");
		// first remove all highlight
		$("#cShowStats > div.stats > div.charts > div.chart > div.blocks > div.block").removeClass("highlighted");
		var att_andrewIds = new Array();
		$("#cShowStats > div.stats > div.charts > div.att > div.blocks > div.block").each(function(){
			att_andrewIds.push($(this).children("input.andrewId").val());
		});

		var same_andrewIds = new Array();
		$("#cShowStats > div.stats > div.charts > div.acc > div.blocks > div.block").each(function(){
			var andrewId = $(this).children("input.andrewId").val();
			if(att_andrewIds.indexOf(andrewId) != -1)
			{
				same_andrewIds.push(andrewId);
			}
		});

		// highlight both blocks
		for(var i=0;i<same_andrewIds.length;++i)
		{
			var andrewId = same_andrewIds[i];
			$("#cShowStats > div.stats > div.charts > div.acc > div.blocks > div.block > input.andrewId[value='"+andrewId+"']").parent().addClass("highlighted");
			$("#cShowStats > div.stats > div.charts > div.att > div.blocks > div.block > input.andrewId[value='"+andrewId+"']").parent().addClass("highlighted");
		}
		$(this).parent().children("span.info").html(same_andrewIds.length+" in common");

	});
	function getUsers(statsUsers)
	{
		var users = new Array();
		for(var andrewId in statsUsers)
		{
			//console.log(andrewId);
			users.push({
				"andrewId":andrewId,
				"attendRate":statsUsers[andrewId]['attendRate'],
				"avgAcc":statsUsers[andrewId]['avgAcc'],
				"name":statsUsers[andrewId]['name'],
			});
		}
		return users;
	}
	function sortUsers(users,sortBy,asc)
	{
		users.sort(function(a,b){
			var keya = a[sortBy];
			var keyb = b[sortBy];
			if(asc)
			{
				if(keya > keyb)
					return 1;
				if(keya < keyb)
					return -1;
			}
			else
			{

				if(keya > keyb)
					return -1;
				if(keya < keyb)
					return 1;
			}
			return 0;
		});
		return users;
	}
	function makeSpecs(sortBy){
		$("#cShowStats > div.stats > div.userList").html("");
		$("#cShowStats > div.stats > div.specs").html("");
		//var asc = true;
		var asc = $("#cShowStats > div.stats > div.ctr > input.asc").prop("checked");
		var users = getUsers(stats.users);
		// sort the key with name
		users = sortUsers(users,sortBy,asc)

		for(var i=0;i<users.length;++i)
		{
			var andrewId = users[i]['andrewId'];
			//console.log(andrewId);
			//insert to user list
			$("#cShowStats > div.stats > div.userList").append(makeUserLinkBlock(stats.users[andrewId],i+1));
			//insert specs for each person
			$("#cShowStats > div.stats > div.specs").append(makeUserBlock(stats.users[andrewId],i+1));
		}
	}
	function makeUserLinkBlock(user,count)
	{
		var temp = $('<a class="userLink" href="#'+user['andrewId']+'"> '+count+'. '+user['name']+" ("+user['andrewId']+") "+'</a> ');
		return temp;
	}
	function makeUserBlock(user,count)
	{
		var useLink = arguments[2]?arguments[2]:2;
		//var attend_rate = (user['totalAttend']/stats.totalForm).toFixed(3);
		var attend_rate = (user['attendRate']*100.0).toFixed(0);
		var acc = user['avgAcc'].toFixed(3);
		var specs = "";
		for(var i in user.forms)
		{
			specs+=" "+user.forms[i]['acc'].toFixed(2)+"("+user.forms[i]['totalCorrect']+"/"+Object.keys(user.forms[i]['qas']).length+") | ";
		}
		var temp = $('<div class="block" name="'+user['andrewId']+'">'+
			(useLink==2?
				'<a name="'+user['andrewId']+'"></a>':
				''
			)+
			'<div class="btn btn-small checkThisGuy">CheckPicture</div>'+
			'<input class="andrewId" type="hidden" value="'+user['andrewId']+'"></input>'+
			'<div class="line"> '+count+'. '+user['name']+ " ("+user['andrewId']+") "+'</div>'+
			'<div class="line"> Attendance: <span class="text-error">'+ attend_rate +'% ('+user['totalAttend']+'/'+stats.totalForm+') </span></div>'+
			'<div class="line"> Avg. Accuracy: <span class="text-error">' + acc + '</span> </div>'+
			'<div class="line"> Specs:'+specs+'</div>'+
		'</div>');
		return temp;
	}
	cw.ec("#cShowStats > div.title > div.redo",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.formIds = <?php echo json_encode($formIds);?>;
		for(var i in data.formIds)
		{
			data.formIds[i] = parseInt(data.formIds[i]);
		}
		//console.log(data);
		$(this).addClass("disabled");
		$("#cMainPage > div.title > span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"getStats?redo=1",data,function(result){
			$(this).removeClass("disabled");
			$("#cMainPage > div.title > span.info").html("");
			//alert(result.debug);
			window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/showStats?statId="+result.statId,"_self");
		},$(this));
	});

	// sort new
	cw.ec("#cShowStats > div.stats > div.ctr > div.sort",function(){
		if($(this).hasClass("sortByAId"))
		{
			makeSpecs('andrewId');
		}
		else if($(this).hasClass("sortByAcc"))
		{
			makeSpecs('avgAcc');
		}
		else
		{
			makeSpecs('attendRate');
		}
	});

	// save stuff
	cw.ec("#cShowStats > div.stats > div.stuff > div > div.save",function(){
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		if($(this).parent().hasClass("excuseNote"))
		{
			data['excuseNote'] = $(this).parent().children("textarea").val();
		}
		else
		{
			data['allAndrewIds'] = $(this).parent().children("textarea").val();
		}
		$(this).addClass("disabled");
		$(this).parent().children("span.info").html("<div class='loading'></div>");
		cw.post(cw.url+"saveStats?statRealId=<?php echo $statRealId?>",data,function(result){
			$(this).removeClass("disabled");
			$(this).parent().children("span.info").html("done").emptyLater();
		},$(this));

	});
	// cal culate info based on the submitted data and all required andrewId
	cw.ec("#cShowStats > div.stats > div.stuff > div.allAndrewIds > div.cal",function(){
		var allText = $.trim($(this).parent().children("textarea").val());
		if(allText == "")
		{
			alert("please enter all andrewId first");
			return;
		}
		var all = new Array();
		var lines = allText.split("\n");
		for(var i=0;i<lines.length;++i)
		{
			var stuff = lines[i].split(/\s/);
			//console.log(stuff);
			all.push({
				"andrewId":stuff[0],
				/*"lastName":stuff[1],
				"firstName":stuff[2],*/
				"name":stuff[2]+" "+stuff[1]
			});
		}
		// check the stat array
		var submittedUsers = getUsers(stats.users);
		var zeroAtt = checkAndrewIdIn(all,submittedUsers);
		var aN = checkAndrewIdIn(submittedUsers,all); // user in the submitted but not in the required
		//console.log(zeroAtt);
		var zeroStr = getNameStr(zeroAtt);
		var aNStr =getNameStr(aN);
		// show them
		$("#cShowStats > div.stats > div.stuff > div.allAndrewIds > div.info > span.zeroNum").html(zeroAtt.length);
		$("#cShowStats > div.stats > div.stuff > div.allAndrewIds > div.info > span.aNum").html(aN.length);
		$("#cShowStats > div.stats > div.stuff > div.allAndrewIds > div.info > span.zeroNames").html(zeroStr);
		$("#cShowStats > div.stats > div.stuff > div.allAndrewIds > div.info > span.aNames").html(aNStr);


	});
	// concat andrewId and name to a string
	function getNameStr(arr)
	{
		var str = "";
		for(var i=0;i<arr.length;++i)
		{
			str+=arr[i]['name']+"("+arr[i]['andrewId']+") | ";
		}
		return str;
	}
	function checkAndrewIdIn(ones,all)
	{
		// the item in ones that are not in all
		var users = new Array();
		for(var i=0;i<ones.length;++i)
		{
			var notIn = true;
			for(var j=0;j<all.length;++j)
			{
				if(ones[i]['andrewId'] == all[j]['andrewId'])
				{
					notIn=false;
					break;
				}
			}
			if(notIn)
			{
				users.push(ones[i]);
			}
		}
		return users;
	}
	// check this website with new bin
	cw.ec("#cShowStats > div.stats > div.charts > div.ctr > div.checkNew",function(){
		var att_bin = $.trim($(this).parent().children("input.att_bin").val());
		var acc_bin = $.trim($(this).parent().children("input.acc_bin").val());
		if((att_bin == "") || (acc_bin == ""))
		{
			alert("Please enter the bin number");
			return;
		}
		window.open("<?php echo Yii::app()->baseUrl?>/index.php/application/showStats?statId=<?php echo $statId?>&att_bin="+att_bin+"&acc_bin="+acc_bin,"_self");
	});
	// check a person's picture history
	var displayData = null; // formId as Id, every time it only carries for one andrew user
	cw.ec("#cShowStats > div.stats > div.specs > div.block > div.checkThisGuy,#cShowStats > div.stats > div.charts > div.chart > div.blocks > div.block > div.checkThisGuy",function(){
		var andrewId = $(this).parent().children("input.andrewId").val();
		// reconstruct the popup
		var name = stats.users[andrewId]['name'];
		var hisforms = stats.users[andrewId]['forms']; // formId -> {"picData":}
		var formInfos = stats.forms; // formId->picPath
		displayData = {};
		for(var formId in hisforms)
		{
			var formData = formInfos[formId];
			displayData[formId] = {
				"lect_name":formData['name'],
				"create_time":formData['createTime'],
				"picPath":formData['picPath'],
				"picData":hisforms[formId]['picData'],// where he is sitting
			};
		}

		// change name
		$("#pictureModal > div.modal-header > h2 > span.name").html(name+" ("+andrewId+")");

		// make slection block
		$("#pictureModal > div.modal-header > h2 > div.picSelection").html("");

		var count=0;
		for(var formId in displayData)
		{
			$("#pictureModal > div.modal-header > h2 > div.picSelection").append('<div class="block">'+
				'<input class="formId" type="hidden" value="'+formId+'"></input>'+
				/*
				'<input class="picPath" type="hidden" value="'+displayData[i]['picPath']+'"></input>'+
				'<input class="picData" type="hidden" value="'+displayData[i]['picData']+'"></input>'+
				'<input class="create_time" type="hidden" value="'+displayData[i]['create_time']+'"></input>'+
				'<input class="lect_name" type="hidden" value="'+displayData[i]['lect_name']+'"></input>'+
				*/
				(++count)+
			'</div>');
		}
		// select the first one
		$("#pictureModal > div.modal-header > h2 > div.picSelection > div.block").eq(0).trigger(cw.ectype);
		// show the modal
		$("#pictureModal").modal("show");
	});
	// click a pic
	var canvas, context;
	cw.ec("#pictureModal > div.modal-header > h2 > div.picSelection > div.block",function(){
		$("#pictureModal > div.modal-header > h2 > div.picSelection > div.block").removeClass("selected");
		$(this).addClass("selected");
		var formId = $(this).children("input.formId").val();
		var picPath = displayData[formId]['picPath'];
		var picData = JSON.parse(displayData[formId]['picData']);
		var create_time = displayData[formId]['create_time'];
		var lect_name = displayData[formId]['lect_name'];
		/*console.log(picPath);
		console.log(picData);
		console.log(lect_name);*/
		// change the title
		$("#pictureModal > div.modal-header > h2 > div.lect_name").html(lect_name + " ("+create_time+")");
		// change the pic
		$("#pictureModal > div.modal-body > div.picArea > div.pic > img.classroomPic").prop("src",picPath);
		canvas = document.getElementById("locator");
		context = canvas.getContext("2d");
		context.clearRect(0, 0, canvas.width, canvas.height);

		// draw it when the image is loaded
		setTimeout(function(){
			canvas = document.getElementById("locator");
			canvas.width = $("#locator").parent().width();
		    canvas.height = $("#locator").parent().height();

		    context = canvas.getContext("2d");
		    context.clearRect(0, 0, canvas.width, canvas.height);
		    //console.log(canvas.width);
		    var x = parseFloat(picData['x']);
			var y = parseFloat(picData['y']);
			var ow = parseFloat(picData['canvasW']);
			var oh = parseFloat(picData['canvasH']);
			x = (x/ow)*canvas.width;
			y = (y/oh)*canvas.height;
			drawDot(x,y);
		},1000);

	});
	function drawDot(x,y){
		//context.fillStyle = "red";
		//context.fillRect(x-5,y-5,10,10);
		// a box around the dot
		context.beginPath();
	    context.rect(x-5,y-5,10,10);
	    context.fillStyle = "transparent";
	    context.fill();
	    context.lineWidth = 1;
	    context.strokeStyle = 'red';
	    context.stroke();
	}
</script>
<div id="cShowStats">
	<!--
	<script language="javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.canvasjs.min.js"></script>-->
	<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>

	<div class="modal fade hide" id="pictureModal" style="width:1200px;margin-left:-600px;">
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h2>
    			picture history for <span class="text-info name"></span> <br/>
    			<div class="picSelection"></div><br/>
    			<div class="lect_name"></div>
    		</h2>
		</div>
		<div class='modal-body' style="">
			<div class="picArea">
				<div class="pic">
					<img class="classroomPic" style="width:100%" src=""></img>
					<canvas id="locator"></canvas>
				</div>
			</div>
		</div>
		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">close</button>
		</div>
	</div>

	<div class="title">Stats
		<span class="text-info">Created at <?php echo $createTime?>
		</span>
		<div class="btn btn-small btn-success redo">Re-calculate</div>
		<a class="btn btn-small btn-warning download" href="<?php echo Yii::app()->baseUrl;?>/index.php/application/getStatsJson?statId=<?php echo $statId?>" target="_blank">Download JSON</a>
	</div>

	<div class="stats">
		<div class="stuff">
			<div class="excuseNote">
				<div class="title">Excuse Note</div>
				<textarea class="excuseNote"><?php echo $excuseNote?></textarea>
				<div class="btn btn-small btn-warning save">save</div>
				<span class="text-info info"></span>
			</div>
			<div class="allAndrewIds">
				<div class="title">All andrewIds (andrewId+space+lastName+space+firstName)</div>
				<textarea class="allAndrewIds"><?php echo $allAndrewIds?></textarea>
				<div class="btn btn-small btn-info cal">cal</div>
				<div class="btn btn-small btn-warning save">save</div>
				<span class="text-info info"></span>
				<div class="info">
					Zero attendance (<span class="text-error zeroNum"></span>): <span class="text-info zeroNames"></span> <br/>
					Attended but not in list (<span class="text-error aNum"></span>): <span class="text-info aNames"></span>
				</div>
			</div>
		</div>
		<div class="info">
			total lectures: <span class="text-info totalLect"></span>
			total people attended: <span class="text-info totalStu"></span>
			(The following doesn't account for info above.)
		</div>
		<div class="charts">
			<div class="ctr">
				<div class="btn btn-small btn-success checkNew">Check With</div>
				att bin: <input class="input-small att_bin" style="width:25px" type="text" value="<?php echo $att_bin?>"></input>
				acc bin: <input class="input-small acc_bin" style="width:25px" type="text" value="<?php echo $acc_bin?>"></input>
			</div>
			<div class="att chart">
				<div class="att_graph graph" id="att_graph" style=""></div>
				<div class="title">Specs (<span class="groupName text-warning"></span>)
					<div class="btn btn-small btn-info highlight">Highlight the same</div>
					<span class="info text-info"></span>
				</div>
				<div class="att_blocks blocks">
					<div class="wrapLoading">
						<span class="muted">Click group to show</span>
					</div>
				</div>
			</div>
			<div class="acc chart">
				<div class="acc_graph graph" id="acc_graph" style=""></div>
				<div class="title">Specs (<span class="groupName text-warning"></span>)
					<div class="btn btn-small btn-info highlight">Highlight the same</div>
					<span class="info text-info"></span>
				</div>
				<div class="acc_blocks blocks">
					<div class="wrapLoading">
						<span class="muted">Click group to show</span>
					</div>
				</div>
			</div>

		</div>
		<div style="clear:both"></div>
		<div class="ctr">
			Sort By:
			<div class="btn btn-small btn-success sort sortByAId">AndrewId</div>
			<div class="btn btn-small btn-success sort sortByAcc">Accuracy</div>
			<div class="btn btn-small btn-success sort sortByAtt">Attendance Rate</div>
			|
			<input class="asc" name="asc" type="radio" value="1"></input> ASC
			<input class="desc" name="asc" type="radio" value="0" checked="checked"></input> DESC
			<br/>
		</div>
		<div class="userList"></div>
		<div class="specs"></div>
	</div>
</div>
