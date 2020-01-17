<?php

class ApplicationController extends Controller
{
	public $layout="";
	public $paramForLayout = array();
	
	// page for editing the form
	// for client
	public function actionEditForm($formId)
	{
		$this->layout = "cClubSiteLayout";
		// get the existing data
		$Form = Form::model()->findByPk($formId);
		if($Form == null)
		{
			$this->render("error",array(
				"text" => "form not exists."
			));
		}
		else
		{
			$shoutkey = $Form->shoutkey;
			$name = $Form->name?$Form->name:"";
			$expiredTime = $Form->expiredTime?$Form->expiredTime:"";
			$isActive = $Form->isActive;
			$isReady = $Form->isReady;
			$picPath = $Form->picPath?$Form->picPath:"";

			$createTime = $Form->createTime;
			$createBy = User::model()->findByPk($Form->createBy)->userName;

			// load the question and answers.
			$questions = Form::loadQuestions($formId);

			$this->render('cEditForm',array(
				"formId" => $formId,
				"shoutkey" => $shoutkey,
				"name" => $name,
				"expiredTime" => $expiredTime,
				"isActive" => $isActive,
				"isReady" => $isReady,
				"picPath" => $picPath,

				"createTime" => $createTime,
				"createBy" => $createBy,
				"questions" => Text::json_encode_ch($questions),
			));	
		}
	}
	public function actionShowStats($statId,$att_bin=1,$acc_bin=0.1)
	{
		$this->layout = "cClubSiteLayout";
		$Stats = FormStats::model()->find("statId=:s ORDER BY createTime Desc",array(
			":s" => $statId,
		));
		if($Stats == NULL)
		{
			$this->render("error",array(
				"text" => "stats not exists."
			));
		}
		else
		{
			//$statData = json_decode($Stats->data,true);

			$statData = $Stats->data;
			$formIds = explode("_",$statId);
			$this->render('cShowStats',array(
				"statData" => $statData,
				"createTime" => $Stats->createTime,
				"statId" => $statId,
				"formIds" => $formIds,
				"allAndrewIds" => $Stats->allAndrewIds,
				"excuseNote" => $Stats->excuseNote,
				"statRealId" => $Stats->id,
				"att_bin" => $att_bin,
				"acc_bin" => $acc_bin,
			));
		}
	}
	public function actionGetStatsJson($statId)
	{
		$this->layout = "cClubSiteLayout";
		$Stats = FormStats::model()->find("statId=:s ORDER BY createTime Desc",array(
			":s" => $statId,
		));
		if($Stats == NULL)
		{
			$this->render("error",array(
				"text" => "stats not exists."
			));
		}
		else
		{
			header('Content-Type: application/json');
			header('Content-Disposition: attachment; filename=stats_'.$statId.".json");
			$statData = $Stats->data;
			echo $statData; // json string
		}
	}
	

	public function actionCheckSubmit($formId)
	{
		$this->layout = "cClubSiteLayout";
		// get the existing data
		$Form = Form::model()->findByPk($formId);
		if($Form == null)
		{
			$this->render("error",array(
				"text" => "form not exists."
			));
		}
		else
		{
			$Form = Form::model()->findByPk($formId);
			$S = SubmitData::model()->findAll("formId=:f",array(":f"=>$formId));
			$submits = array();
			foreach($S as $one)
			{
				$submits[] = array(
					"andrewId" => $one['andrewId'],
					"name" => $one['name'],
					"picData" => json_decode($one['picData']),
				);
			}
			$this->render('cCheckSubmit',array(
				"picPath" => $Form->picPath,
				"submits" => $submits,
				"name" => $Form->name,
			));
		}
	}
	
	public function actionIndex()// for mainPage
	{
		
		if($this->paramForLayout['userLevel'] != 0)
		{
			//
			//用户角色	
				$this->layout = "cClubSiteLayout";
				//get dataset list
				
				$this->render('cMainPage',array(
					
				));		
		}
		else//管理员角色
		{
			//先获取用户的权限，是否栏目管理员等，用于构造左半边栏
			$userId = Yii::app()->session['userId'];
			$res = User::model()->findByPK("$userId");
			$this->paramForLayout['isUM'] = $res['isUM'];
			$this->paramForLayout['isSuper'] = $res['isSuper'];
			
			$this->layout = "clubSiteLayout";
			$this->render('index');
		}
	}
	/*
	public function actionCHelp()
	{
		$this->layout = "cClubSiteLayout";
		$Notice = Notice::model()->findByPk(1);// the help is id 1
		$this->render("cHelp",array(
			"content" => $Notice->content,
		));
	}*/

	

/*************
	below are for management account
*/
	public function actionUserManage()
	{
		//获取该用户能管理的栏目id,即为其能授予其用户的栏目 (只要直接节点，不需要子结点)(创建该管理员时，其所管理的栏目会经过去重，即一个catalogId被另一个覆盖时，会删掉此重复)
		$isSuper = User::isSuper(Yii::app()->session['userId']);//true false;
		$this->render('userManage',array(
			"isSuper" => $isSuper,
		));
	}
	public function actionPersonalPage($id=0)
	{
		$userId = Yii::app()->session['userId'];
		if($id!=0)
		{	
			//检查$id的用户存在不存在
			$User = User::model()->findByPk($id);
			if($User == null)
			{
				echo "Hey,You!Please dont screw with the address board.A** hole.";
			}
						
		}
		else
		{
			$id = $userId;	
		}
				
				$this->render('personalPage',array(
					'id' => $id,
				));
		
	}
	
	
	public function actionNotice($noticeId = 0)
	{
		//不再一次获取
		//获取notice数
		/*$Num = Notice::model()->count();
		$this->render("notice",array(
			"noticeNum" => $Num,
		));
		*/
		if($noticeId == 0)
		{
			//获取所有notice
			$Notice = Notice::model()->findAll();
			$arr = array();
			foreach($Notice as $one)
			{
				$arr[] = $one->attributes;
			}
			$this->render("noticeView",array(
				"arr" => $arr
			));
		}
		else
		{
			$arr = Notice::model()->findByPk($noticeId);
			if($arr!=NULL)
			{
				$this->render("noticeEdit",array(
					"arr" => $arr,
				));
			}
			else
			{
				$this->render("notStart",array(
					"text" => "wrong noticeId"
				));
			}
		}
		
	}
	//*******************************************
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			
			'accessControl',//所有进入内部论坛都需要登录
			//后面是各种其它方法的filter(分三类角色的acition)
			//'judgeFilter',
			'managerFilter + userManage,personalPage,notice',
			'isSuper + superManage,notice',
			'isUM + userManage',
		);
	}
	
	public function filterAccessControl($filterChain)
	{
		if(!isset(Yii::app()->session['userId']) || !isset(Yii::app()->session['userName']))
		{
			//不可能是ajax调用，
			if(!Yii::app()->request->isAjaxRequest)
			{
				//echo Yii::app()->request->requestUri;
				//echo Yii::app()->controller->getId();
				//echo Yii::app()->controller->getAction()->getId();
				//echo urldecode(urlencode(Text::getRequest()));
				$this->redirect(Yii::app()->baseUrl."/index.php/admin?r=".urlencode(Text::getRequest()));
				die("");
			}
			else//未登录且非ajax请求则rediret回外部门户主页
			{
					die("error:f**k.");			
			}
		}
		//判断角色
		$UserRole = User::getUserRole(Yii::app()->session['userId']);
		
		if($UserRole == false)
		{
			die("error");
		}
		/*
			判断用户是否管理员，或者用户
		*/
		$this->paramForLayout['username'] = $UserRole['userName'];
		$this->paramForLayout['nickname'] = $UserRole['nickName'] == ""?$UserRole['userName']:$UserRole['nickName'];
		$this->paramForLayout['userLevel'] = $UserRole['userLevel'];

		Yii::import("application.extensions.f");
		$filterChain->run();
	}
	public function filterManagerFilter($filterChain)
	{
		if(!User::isManager(Yii::app()->session['userId']))
		{
			//不可能是ajax调用，
			if(!Yii::app()->request->isAjaxRequest)
			{
				$this->redirect(Yii::app()->baseUrl."/");
				die("");
			}
			else//未登录且非ajax请求则rediret回外部门户主页
			{
					die("error:f**k.");			
			}
		}
		//先获取用户的权限，是否栏目管理员等，用于构造左半边栏
		$userId = Yii::app()->session['userId'];
		$res = User::model()->findByPK("$userId");
		$this->paramForLayout = array(
			'isUM' => $res['isUM'],
			'isSuper' => $res['isSuper'],			
		);
		
		$this->layout = "clubSiteLayout";
		$filterChain->run();
	}
	
	
	public function filterIsUM($filterChain)
	{
		if(!User::isUM(Yii::app()->session['userId']))
		{
			//非ajax调用，
			if(!Yii::app()->request->isAjaxRequest)
			{
				$this->redirect(Yii::app()->baseUrl."/");
				die("");
			}
			else//未登录且ajax请求则rediret回外部门户主页
			{
				die("error:f**k.");			
			}
		}
		$filterChain->run();
	}
	
	public function filterIsSuper($filterChain)
	{
		if(!User::isSuper(Yii::app()->session['userId']))
		{
			//非ajax调用，
			if(!Yii::app()->request->isAjaxRequest)
			{
				$this->redirect(Yii::app()->baseUrl."/");
				die("");
			}
			else//未登录且ajax请求则rediret回外部门户主页
			{
				die("error:f**k.");			
			}
		}
		$filterChain->run();
	}
}