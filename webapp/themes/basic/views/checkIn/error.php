
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
	}
	#checkIn > div.content > div.title{
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
		<div class="title">Messages</div>
		<div class="message"><?php echo $text?></div>
	</div>

	<!-- footer -->
	<div class="footer">An <a target="_blank" href="https://github.com/JunweiLiang/Lecture_Attendance_Management">open-source project</a> designed by <a target="_blank" href="https://www.cs.cmu.edu/~junweil/">Junwei Liang</a>.</div>
</div>
