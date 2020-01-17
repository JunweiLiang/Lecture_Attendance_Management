<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php

class CheckInController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout = 'checkInLayout';
	public function actionIndex($k="")
	{
		$k = trim(urldecode($k));
		if($k == "")
		{
			$this->render("error",array(
				"text" => "Please enter proper shoutkey. :)"
			));
		}
		else
		{
			// check whether the key is active and ready
			$isActive = false;$isReady = false;
			$Form = Form::model()->find("isActive=1 AND shoutkey=:k AND isDeleted=0",array(
				":k" => $k
			));
			if($Form != null)
			{
				$isActive = true;
				$isReady = $Form->isReady==1?true:false;
				if(!$isReady)
				{
					// not ready, show the message
					$this->render("error",array(
						"text" => "This page is not yet ready. Please come back later. :)"
					));
				}
				else
				{
					// check the expiredTime
					if($Form->expiredTime != null)
					{
						$expiredTime = strtotime($Form->expiredTime);
					}
					if(isset($expiredTime) && (time() > $expiredTime))
					{
						$this->render("error",array(
							"text" => "This page is expired. :)"
						));
					}
					else
					{
						// ready, then get the cache
						$FinalForm = FinalForm::model()->find("formId=:f",array(
							":f" => $Form->id
						));
						if($FinalForm == null)
						{
							$this->render("error",array(
								"text" => "Oops, this shouldn't have happened... QAQ"
							));
						}
						else
						{
							//$questions = Form::loadQuestions($Form->id); // this will take longer?
							$questions = json_decode($FinalForm->data,true);
							$safeCheck = md5($Form->id . $k .$Form->picPath.$Form->name. "chunwaileong"); // so no one mess with these things
							// set the session , so that we can check during submit
							Yii::app()->session['lastOptTime'] = time();
							$this->render("index",array(
								"questions" => $questions,
								"Form" => $Form,
								"safeCheck" => $safeCheck,
								"shoutkey" => $k,
							));
						}
					}	
				}		
			}
			else
			{
				// shoutkey is not found or it is not active
				$this->render("error",array(
					"text" => "Please enter proper shoutkey. :)"
				));
			}	
		}
	}
	public function actionTest()
	{
		echo time();
		echo "</br>";
		echo date("Y-m-d H:i:s");
	}
	public function actionDone()
	{
		//just show the message
		$this->render("error",array(
			"text" => "Got it. :)"
		));
	}

	public function actionSubmit()
	{
		// page is valid in 1 sec to 6 hours
		if(isset(Yii::app()->session['lastOptTime']) && (time() - Yii::app()->session['lastOptTime'] > 1) && (time() - Yii::app()->session['lastOptTime'] < 60*60*6))
		{
			$request = Yii::app()->request;
			$andrewId = $request->getPost("andrewId",null);
			$name = $request->getPost("name",null);
			$picData = $request->getPost("picData",null);
			$questions = $request->getPost("questions",null);
			$formId = $request->getPost("formId",null);
			$safeCheck = $request->getPost("safeCheck",null);
			$shoutkey = $request->getPost("shoutkey",null);
			$picPath = $request->getPost("picPath",null);
			$lectureName = $request->getPost("lectureName",null);
			if(($formId!==null) &&($picPath!==null)&& ($lectureName !==null)&& ($safeCheck!==null) &&($shoutkey!==null)&&($andrewId!==null)&& ($name!==null))
			{
				$result = array(
					"status" => 0,
				);
				//safety check//whether the formId has been altered
				$thisSafe = md5($formId.$shoutkey.$picPath.$lectureName."chunwaileong");
				if($thisSafe !== $safeCheck)
				{
					$result['status'] = 1;
					$result['error'] = "Safe check failed!";
				}
				else
				{
					$transaction = Yii::app()->db->beginTransaction();
					try
					{
						$S = new SubmitData();
						$S->formId = $formId;
						$S->andrewId = $andrewId;
						$S->name = $name;
						$S->submitTime = new CDbExpression("NOW()");
						$S->picData = Text::json_encode_ch($picData);
						$S->answers = Text::json_encode_ch($questions);
						if(!$S->save())
						{
							throw new Exception(var_export($S->getErrors(),true));
						}
						// save it to a json for backup
						$saveTo = "assets/backup/$formId/";
						if(!file_exists($saveTo))
						{
							mkdir($saveTo);
						}
						$filename = "$andrewId.json";
						$data = array(
							"andrewId" => $andrewId,
							"name" => $name,
							"submitTime" => date("Y-m-d H:i:s"),
							"picData" => $picData,
							"questions" => $questions,
							"formId" => $formId,
							"picPath" => $picPath,
							"lectureName" => $lectureName,
						);
						file_put_contents($saveTo.$filename,Text::json_encode_ch($data));
						$transaction->commit();
					}catch(Exception $e)
					{
						$transaction->rollback();
						$result['status'] = 2;
						$result['error'] = $e->getMessage();
					}
				}
				echo Text::json_encode_ch($result);
			}
		}
		else
		{
			// attacks?
			echo json_encode(array("error"=>"optTime"));
		}
	}	
	public function actionVcode()//此方法直接返回vcode图像,random四位数字(不能使用，yii有多余输出?直接在根目录下使用Vcode.php)//可以使用了，万恶的config.php有BOM头!
	{
		header("Content-type:image/PNG");
		$code = sprintf("%04d",rand(1,9999));
		//设置session,在UserControllerlogin中验证 
		Yii::app()->session['vcode'] = $code;
		//打印此图像
		Yii::import("application.extensions.Vcode");
		Vcode::init($code)->printCode();
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
		//	'cacheCheck'//所有请求都先看有没有相应的缓存存在，存在就返回缓存
			//这里需要Bugleong控制器里的静态方法 ,由于控制器不能静态调用，所以把该方法在此复制了一次
			//后面是各种其它方法的filter
			'pageCheck + admin',//已经登录的不能进入页面
		);
	}
	
	public function filterPageCheck($filterChain)
	{
		////检查cookie
		if(isset(Yii::app()->request->cookies['userName']) && isset(Yii::app()->request->cookies['pw']))
		{
			$User = User::model()->find('userName=:userName AND userPw=:userPw',array(
				':userName' => Yii::app()->request->cookies['userName']->value,
				':userPw' => Yii::app()->request->cookies['pw']->value,
			));
			if($User != NULL)
			{
				//设置session
				Yii::app()->session['userId'] = $User['userId'];
				Yii::app()->session['userName'] = $User['userName'];
				Yii::app()->session['userLevel'] = $User['userLevel'];
				$isLogin = true;
			}
			else
			{
				//清空这不正确的cookie
				unset(Yii::app()->request->cookies['userName']);
				unset(Yii::app()->request->cookies['pw']);
			}
		}
		//检查是否已经登录，已经登录就导向内部主页
		if(isset(Yii::app()->session['userId']) && isset(Yii::app()->session['userName']))
		{
			//先判断是否ajax.是ajxa就返回错误
			if(Yii::app()->request->isAjaxRequest)
			{
				die("error:already login.");
			}
			else
			{
				$this->redirect(Yii::app()->baseUrl."/index.php/application");
				die("");
			}
			
		}
		$filterChain->run();
	}
	public function actionDesigner()
	{
		//作者页
		$this->render("designer",array());
		
	}
	
	
	/**
	 * This is the action to handle external exceptions.
	 */
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

}