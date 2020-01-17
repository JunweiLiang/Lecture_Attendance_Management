
<style type="text/css">
	#checkIn > div.makeupspace{
		height:30px;
		padding:5px 0;
		width:100%;
		position:relative;
	}
	#checkIn > div.header
	{
		position: fixed;
	    top: 0;
	    left: 0;
	    z-index: 9999;
		background-color: rgb(0,128,192);
	    height: 30px;
	    padding: 5px 0px;
	    width: 100%;
	    -webkit-user-select: none;
	    -khtml-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	    text-align:center;
	}
	#checkIn > div.header > a{
		font-size: 1.2em;
	    font-weight: bold;
	    padding-top: 5px;
	    color: white;
	    text-decoration: none;
	    outline: none;

	    position: absolute;
	    left: 50%;
	    width: 300px;
	    text-align: center;
	    margin-left: -150px;
	}
	#checkIn > div.content{
		margin:10px auto;
		width:80%;
		border-radius:5px;
		background-color:white;
		min-height:400px;
		padding-bottom:30px;
	}
	#checkIn > div.content > div.title,#checkIn > div.content > div.sitting > div.title{
		padding:10px;
		font-weight:bold;
		font-size:1.2em;
		color:silver;
		border-bottom:1px silver solid;
	}
	#checkIn > div.content > div.message{
		text-align:center;
		padding:20px;
		font-weight:bold;
		font-size:1.3em;
		color:gray;
		line-height:40px;
	}
	#checkIn > div.footer{
		font-weight:bold;
		font-size:0.8em;
		color:gray;
		text-align:center;
		padding:5px 0;
	}
	#checkIn input{margin:0}
	#checkIn > div.content > div.questions > div.block{
		padding:10px 3%;
		line-height:30px;
	}
	#checkIn > div.content > div.questions > div.block > div.line{
		padding:10px 0;
		position:relative;
		text-align:center;
	}
	#checkIn > div.content > div.questions > div.block > div.line > input.basic{
		width:80%;
		/*
		position:absolute;
		top:5px;
		right:0;
		*/
	}
	#checkIn > div.content > div.sitting > div.picArea{
		padding:20px;
	}
	#checkIn > div.content > div.sitting > div.picArea > div.pic{
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
	#checkIn > div.content > div.submitting{
		padding:10px 0;
		text-align:center;
	}
</style>
<div id="checkIn">

	<!-- header -->
	<div class="makeupspace"></div>
	<div class="header">
		<a class="logo" title="home" href="<?php echo Yii::app()->baseUrl;?>/">
			CheckIn
		</a>
	</div>

	<!-- body -->
	<div class="content">
		<input class="formId" type="hidden" value="<?php echo $Form->id?>"></input>
		<input class="safeCheck" type="hidden" value="<?php echo $safeCheck?>"></input>
		<div class="title"><?php echo $Form->name;?></div>
		<div class="questions">

			<div class="block">

				<div class="line">
					<!--<span class="head">Andrew Id:</span>-->
					<input class="input-medium basic andrewId" type="text" placeholder="Your andrew ID (not email address). Please make sure it is correct. E.g., [a-z0-9]+"></input>
				</div>

				<div class="line">
					<!--<span class="head">Name:</span>-->
					<input class="input-medium basic name" type="text" placeholder="Your full name"></input>
				</div>

			</div>

			<?php $count=0;foreach($questions as $question){$count++; ?>

				<div class="block question">
					<input class="qId" type="hidden" value="<?php echo $question['qId']?>"></input>
					<div class="questionText">
						<?php echo $count?>. <span class="text"><?php echo $question['text']?></span>
					</div>

					<div class="answers">
						<?php foreach($question['answers'] as $answer){
								// treat all of them as multiple choice
							?>

							<div class="line answer">
								<input class="aId" type="hidden" value="<?php echo $answer['id']?>"></input>
								<input class="answer" type="checkbox" name="<?php echo $question['qId']?>"></input>
								<span class="text"><?php echo $answer['text']?></span>
							</div>

						<?php } ?>
					</div>

				</div>
			<?php } ?>
		</div>

		<div class="sitting">
			<div class="title">Where were you?</div>
			<div class="picArea">
				<!--<span class="info muted">Draw(drag) a rectangle around where you were sitting, then click "submit" at the bottom.</span>-->
				<!-- (Please do so on a desktop browser)-->
				<span class="info muted" style="font-weight:bold">Click on where you were sitting, then click "submit" at the bottom.</span>
				<div class="pic">
					<img class="classroomPic" style="width:100%" src="<?php echo $Form->picPath;?>"></img>
					<canvas id="locator"></canvas>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			// script for draging a rect on the picture
			var canvas, context, startX, endX, startY, endY;
			var mouseIsDown = 0;
			var finalPos = null;

			window.onresize = function(event){
				// change the canvas width and height
				canvas = document.getElementById("locator");
			    canvas.width = $("#locator").parent().width();
			    canvas.height = $("#locator").parent().height();
			}
			function init() {

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
			   	//alert($("#locator").parent().html());

			    context = canvas.getContext("2d");
			    /*
			    // for rectangle
			    canvas.addEventListener("mousedown", mouseDown, false);
			    canvas.addEventListener("mousemove", mouseXY, false);
			    canvas.addEventListener("mouseup", mouseUp, false);
			    */
			    // just a click
			    canvas.addEventListener("click",click,false);
			}
			function click(event){
				var pos = getMousePos(canvas, event);
				context.clearRect(0, 0, canvas.width, canvas.height);
				/*
				context.fillStyle = "red";
				//check the sceen with to determine the square size.
				if(canvas.width > 400)
					context.fillRect(pos.x-5,pos.y-5,10,10);
				else
					context.fillRect(pos.x-3,pos.y-3,6,6);
				*/
				// show a img
				var img=document.getElementById("clickImg");
				if(canvas.width > 400)
					context.drawImage(img,pos.x-7,pos.y-7,14,14);
				else
					context.drawImage(img,pos.x-4,pos.y-4,8,8);
				finalPos = {
		        	"x":pos.x,
		        	"y":pos.y,
		        	"canvasW":canvas.width,
		        	"canvasH":canvas.height,
		        };
			}

			function mouseUp(event) {
			    if (mouseIsDown !== 0) {
			        mouseIsDown = 0;
			        var pos = getMousePos(canvas, event);
			        endX = pos.x;
			        endY = pos.y;
			        drawSquare(); //update on mouse-up
			        // the final results, two points on the diagnal line
			        finalPos = {
			        	"startX":startX,
			        	"startY":startY,
			        	"endX":endX,
			        	"endY":endY,
			        	"canvasW":canvas.width,
			        	"canvasH":canvas.height,
			        };

			        // if startX == endX, means only click a point
			        if((startX==endX) || (startY==endY))
			        {
			        	finalPos = null;
			        }
			        //console.log(finalPos);
			    }
			}

			function mouseDown(event) {
			    mouseIsDown = 1;
			    var pos = getMousePos(canvas, event);
			    startX = endX = pos.x;
			    startY = endY = pos.y;
			    drawSquare(); //update
			}

			function mouseXY(event) {

			    if (mouseIsDown !== 0) {
			        var pos = getMousePos(canvas, event);
			        endX = pos.x;
			        endY = pos.y;

			        drawSquare();
			    }
			}

			function drawSquare() {
			    // creating a square
			    var w = endX - startX;
			    var h = endY - startY;
			    var offsetX = (w < 0) ? w : 0;
			    var offsetY = (h < 0) ? h : 0;
			    var width = Math.abs(w);
			    var height = Math.abs(h);

			    context.clearRect(0, 0, canvas.width, canvas.height);

			    context.beginPath();
			    context.rect(startX + offsetX, startY + offsetY, width, height);
			    context.fillStyle = "transparent";
			    context.fill();
			    context.lineWidth = 2;
			    context.strokeStyle = 'red';
			    context.stroke();

			}

			function getMousePos(canvas, evt) {
			    var rect = $("#locator").offset();
			    //console.log("pagexy:"+evt.pageX+" "+evt.pageY);
			    //console.log("rectlefttop:"+rect.left+" "+rect.top);
			    //console.log("xy:"+(evt.pageX - rect.left)+" "+ (evt.pageY - rect.top))
			    return {
			        x: evt.pageX - rect.left,
			        y: evt.pageY - rect.top
			    };
			}
			// this not working in safari
			$(window).load(function(){
				init();
			});
			/*
			$(document).ready(function(){
				init();
			});	*/
		</script>

		<div class="submitting">
			<div class="btn btn-primary submit">Submit</div>
			<span class="text-error info"></span>
		</div>
		<script type="text/javascript">
			cw.ec("#checkIn > div.content > div.submitting > div.submit",function(){
				if($(this).hasClass("disabled"))
				{
					return;
				}
				var $c = $("#checkIn > div.content");
				var data = {};
				data.andrewId = $.trim($c.find("div.block > div.line > input.andrewId").val());
				if(data.andrewId == "")
				{
					e("Please enter Andrew Id.");
					$c.find("div.block > div.line > input.andrewId").css({"borderColor":"red"});
					return;
				}
				data.name = $.trim($c.find("div.block > div.line > input.name").val());
				if(data.name == "")
				{
					e("Please enter your name.");
					$c.find("div.block > div.line > input.name").css({"borderColor":"red"});
					return;
				}
				// get the position
				data.picData = finalPos;
				if(data.picData == null)
				{
					e("Please find yourself in the picture.");
					$c.find("div.sitting > div.picArea > span.info").removeClass("muted").addClass("text-error");
					return;
				}
				data.questions = getQuestions();// no check for question answering, will grade in the end
				data.formId = $("#checkIn > div.content > input.formId").val();
				data.safeCheck = $("#checkIn > div.content > input.safeCheck").val();
				data.shoutkey = "<?php echo $shoutkey?>";
				data.picPath = "<?php echo $Form->picPath?>";
				data.lectureName = "<?php echo $Form->name?>";
				//console.log(data);
				$(this).addClass("disabled");
				$(this).parent().children("span.info").html('<div class="loading"></div>');
				cw.post("<?php echo Yii::app()->baseUrl?>/index.php/checkIn/submit",data,function(result){
					$(this).removeClass("disabled");
					if(result.status == 0)
					{
						e("ok");
						window.open("<?php echo Yii::app()->baseUrl?>/index.php/checkIn/done","_self");
					}
					else
					{
						e("Submit Error, please refresh page and try again");
					}
				},$(this));
			});
			function getQuestions()
			{
				var data = new Array();
				$("#checkIn > div.content > div.questions > div.question").each(function(){
					var question = {};
					question.qId = $(this).children("input.qId").val();
					question.text = $(this).find("div.questionText > span.text").html();
					question.answers = new Array();
					$(this).find("div.answers > div.answer").each(function(){
						var answer = {};
						answer.aId = $(this).children("input.aId").val();
						answer.text = $(this).children("span.text").html();
						answer.checked = $(this).children("input.answer").prop("checked")?1:0;
						question.answers.push(answer);
					});
					data.push(question);
				});
				return data;
			}
			function e(str)
			{
				$("#checkIn > div.content > div.submitting > span.info").html(str).emptyLater();
			}
		</script>

	</div>

	<!-- footer -->
	<div class="footer">An <a target="_blank" href="https://github.com/JunweiLiang/Lecture_Attendance_Management">open-source project</a> designed by <a target="_blank" href="https://www.cs.cmu.edu/~junweil/">Junwei Liang</a>.</div>
	<img id="clickImg" style="display:none" src="<?php echo Yii::app()->baseUrl?>/assets/clickImg.png"></img>
</div>
