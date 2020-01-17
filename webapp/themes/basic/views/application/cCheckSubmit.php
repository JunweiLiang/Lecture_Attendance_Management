
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
	#cCheckSubmit{
		width:90%;
		margin:30px auto;
		background-color:white;
		min-height:100px;
		border-radius:5px;
	}
	#cCheckSubmit input{margin:0}
	#cCheckSubmit > div.title{
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
	#cCheckSubmit > div.main {
		text-align:center;
	}
	#cCheckSubmit > div.main > div.line{
		padding:10px 0;
	}
	#cCheckSubmit > div.main > div.picArea{
		padding:20px;
	}
	#cCheckSubmit > div.main > div.picArea > div.pic{
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
	var submits = <?php echo Text::json_encode_ch($submits);?>;
	var canvas, context;
	window.onresize = function(event){
		// change the canvas width and height
		canvas = document.getElementById("locator");
	    canvas.width = $("#locator").parent().width();
	    canvas.height = $("#locator").parent().height();
	    drawBoxesOrDots();
	}
	$(document).ready(function(){
		canvas = document.getElementById("locator");
	    /*
	    // have to set manually
	    canvas.width = 1108;
	    canvas.height = 375;
	    console.log(canvas.width);
	    console.log($("#locator").parent().width()+" "+$("#locator").parent().height());
	    */
	    canvas.width = $("#locator").parent().width();
	    canvas.height = $("#locator").parent().height();

	    context = canvas.getContext("2d");
		// draw all the pic on the pic
		drawBoxesOrDots();
		setTimeout(function(){
			drawBoxesOrDots();
		},1000);
	});
	function drawBoxesOrDots()
	{
		context.clearRect(0, 0, canvas.width, canvas.height);
		for(var i=0;i< submits.length;++i)
		{
			// we need to norm the coordinates
			// for rect
			if(submits[i]['picData']['startX']!=null)
			{
				var sx = submits[i]['picData']['startX'];
				var sy = submits[i]['picData']['startY'];
				var ex = submits[i]['picData']['endX'];
				var ey = submits[i]['picData']['endY'];
				var ow = submits[i]['picData']['canvasW'];
				var oh = submits[i]['picData']['canvasH'];
				sx = (sx/ow)*canvas.width;
				sy = (sy/oh)*canvas.height;
				ex = (ex/ow)*canvas.width;
				ey = (ey/oh)*canvas.height;
				//console.log([sx,sy,ex,ey]);
				drawSquare(sx,sy,ex,ey);
			}
			else
			{
				// for clicks
				var x = submits[i]['picData']['x'];
				var y = submits[i]['picData']['y'];
				var ow = submits[i]['picData']['canvasW'];
				var oh = submits[i]['picData']['canvasH'];
				x = (x/ow)*canvas.width;
				y = (y/oh)*canvas.height;
				drawDot(x,y);
			}

		}
	}
	function drawDot(x,y){
		context.fillStyle = "red";
		context.fillRect(x-5,y-5,10,10);
	}
	function drawSquare(startX,startY,endX,endY) {
	    // creating a square
	    var w = endX - startX;
	    var h = endY - startY;
	    var offsetX = (w < 0) ? w : 0;
	    var offsetY = (h < 0) ? h : 0;
	    var width = Math.abs(w);
	    var height = Math.abs(h);

	    context.beginPath();
	    context.rect(startX + offsetX, startY + offsetY, width, height);
	    context.fillStyle = "transparent";
	    context.fill();
	    context.lineWidth = 2;
	    context.strokeStyle = 'red';
	    context.stroke();

	}
</script>
<div id="cCheckSubmit">
	<div class="title"><?php echo $name?></div>
	<div class="main">
		<div class="line">
			Total submission: <?php echo count($submits)?>
		</div>
		<div class="picArea">
			<div class="pic">
				<img class="classroomPic" style="width:100%" src="<?php echo $picPath;?>"></img>
				<canvas id="locator"></canvas>
			</div>
		</div>
	</div>
</div>
<div class="footer">An <a target="_blank" href="https://github.com/JunweiLiang/Lecture_Attendance_Management">open-source project</a> designed by <a target="_blank" href="https://www.cs.cmu.edu/~junweil/">Junwei Liang</a>.</div>
