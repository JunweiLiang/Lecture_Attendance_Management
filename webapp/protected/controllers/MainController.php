<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
	/*
		T_log(userId,type,param)
			type:
				1-4同下
				5.新建项目
		T_remind(toUserId,type,isRead,param)
		 type字段
			1.把人加入project   T_PU  添加
			2.设置project中人的角色  T_PU type
			3.分派工作给人     T_workAssign
			4.评论工作（&回复人）T_work

	*/
	
?>
<?php
class MainController extends Controller
{
	//delete answer
	public function actionDeleteAnswer()
	{
		$request = Yii::app()->request;
		$formId = $request->getPost("formId",null);
		$aId = $request->getPost("aId",null);
		$qId = $request->getPost("qId",null);
		if(($qId !== null) && ($formId !== null) && ($aId !== null)) 
		{
			$result = array(
				"status" => 0,
			);
			$A = ChoiceAnswer::model()->findByPk($aId);
			$A->isDeleted = 1;
			if(!$A->save())
			{
				$result['status'] = 1;
			}
			echo Text::json_encode_ch($result);
		}
	}
	//edit answer
	public function actionSaveAnswer()
	{
		$request = Yii::app()->request;
		$formId = $request->getPost("formId",null);
		$qId = $request->getPost("qId",null);
		$aId = $request->getPost("aId",null);
		$text = $request->getPost("text",null);
		$isCorrect = $request->getPost("isCorrect",null);
		if(($text !== null) && ($qId !== null) && ($formId !== null) && ($aId !== null) && ($isCorrect !== null)) 
		{
			$result = array(
				"status" => 0,
			);
			$A = ChoiceAnswer::model()->findByPk($aId);
			if(($A == null) || ($A->qId != $qId))
			{
				$result['status'] = 2;
			}
			else
			{
				$A->text = $text;
				$A->isCorrect = $isCorrect;
				if(!$A->save())
				{
					$result['status'] = 1;
				}
				else
				{
					// check the question's answer is multi choice
					$count = ChoiceAnswer::model()->count("qId=:q AND isCorrect=1 AND isDeleted=0",array(
						":q" => $qId,
					));
					$isSingleChoice = $count > 1?0:1;
					$Q = ChoiceQuestion::model()->findByPk($qId);
					if($Q == null)
					{
						$result['status'] = 3;
					}
					else
					{
						$Q->isSingleChoice = $isSingleChoice;
						if(!$Q->save())
						{
							$result['status'] = 4;
						}
					}
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionAddAnswer()
	{
		$request = Yii::app()->request;
		$formId = $request->getPost("formId",null);
		$qId = $request->getPost("qId",null);
		$answer = $request->getPost("answer",null);
		$userId = Yii::app()->session['userId'];
		if(($formId !== null) && ($qId !== null) && ($answer !== null))
		{
			$result = array(
				"status" => 0,
			);
			$A = new ChoiceAnswer();
			$A->qId = $qId;
			$A->text = $answer;
			$A->isCorrect = 0;
			$A->createTime = new CDbExpression("NOW()");
			$A->createBy = $userId;
			if(!$A->save())
			{
				$result['status'] = 1;
			}
			else
			{
				$result['answer'] = $A->attributes;
				$result['answer']['createTime'] = date("Y-m-d H:i:s");
			}
			echo Text::json_encode_ch($result);
		}
	}
	// save question text
	public function actionSaveQuestion()
	{
		$request = Yii::app()->request;
		$formId = $request->getPost("formId",null);
		$qId = $request->getPost("qId",null);
		$text = $request->getPost("text",null);
		if(($text !== null) && ($qId !== null) && ($formId !== null)) 
		{
			$result = array(
				"status" => 0,
			);
			$Q = ChoiceQuestion::model()->findByPk($qId);
			if($Q == null)
			{
				$result['status'] = 2;
			}
			else
			{
				$Q->text = $text;
				if(!$Q->save())
				{
					$result['status'] = 1;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	// delete question
	public function actionDeleteQuestion()
	{
		$request = Yii::app()->request;
		$formId = $request->getPost("formId",null);
		$qId = $request->getPost("qId",null);
		if(($qId !== null) && ($formId !== null)) 
		{
			$result = array(
				"status" => 0,
			);
			$Q = ChoiceQuestion::model()->findByPk($qId);
			$Q->isDeleted = 1;
			if(!$Q->save())
			{
				$result['status'] = 1;
			}
			echo Text::json_encode_ch($result);
		}
	}
	// add a question
	public function actionAddQuestion()
	{
		$request = Yii::app()->request;
		$formId = $request->getPost("formId",null);
		$question = $request->getPost("question",null);
		$userId = Yii::app()->session['userId'];
		if(($formId !== null) && ($question !== null))
		{
			$result = array(
				"status" => 0,
			);
			$Q = new ChoiceQuestion();
			$Q->formId = $formId;
			$Q->text = $question;
			$Q->createTime = new CDbExpression("NOW()");
			$Q->createBy = $userId;
			if(!$Q->save())
			{
				$result['status'] = 1;
			}
			else
			{
				$result['question'] = $Q->attributes;
				$result['question']['qId'] = $result['question']['id'];
				$result['question']['answers'] = array();
				$result['question']['createTime'] = date("Y-m-d H:i:s");
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionDeleteForm()
	{
		$request = Yii::app()->request;
		$formId = $request->getPost("formId",null);
		if($formId !== null)
		{
			$result = array(
				"status" => 0
			);
			$Form = Form::model()->findByPk($formId);
			if($Form == null)
			{
				$result['status'] = 1;
			}
			else
			{
				$Form->isDeleted = 1;
				if(!$Form->save())
				{
					$result['status'] = 2;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSaveFormInfo()
	{
		$request = Yii::app()->request;
		$formId = $request->getPost("formId",null);
		$shoutkey = $request->getPost("shoutkey",null);
		$expiredTime = $request->getPost("expiredTime",null);
		$picPath = $request->getPost("picPath",null);
		$name = $request->getPost("name",null);
		if(($formId !== null) && ($name !== null) && ($shoutkey !== null) && ($expiredTime !== null) && ($picPath !== null))
		{
			$result = array(
				"status" => 0
			);
			$Form = Form::model()->findByPk($formId);
			if($Form == null)
			{
				$result['status'] = 1;
			}
			else
			{
				$Form->shoutkey = $shoutkey;
				$Form->expiredTime = $expiredTime;
				$Form->picPath = $picPath;
				$Form->name = $name;
				if(!$Form->save())
				{
					$result['status'] = 2;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSetFormActive()
	{
		$request = Yii::app()->request;
		$isActive = $request->getPost("isActive",null);
		$formId = $request->getPost("formId",null);
		$setTo = $request->getPost("setTo",null);
		if(($setTo != null) && ($formId != null) && ($isActive != null))
		{
			$result = array(
				"status" => 0,
			);
			$Form = Form::model()->findByPk($formId);
			if($Form == null)
			{
				$result['status'] = 1;
			}
			else
			{
				// set all the form to be inactive
				$transaction = Yii::app()->db->beginTransaction();
				try
				{
					$sql = "UPDATE C_form SET isActive=0";
					Text::sql($sql,array(),array(),false);
					$Form->isActive = $setTo==1?1:0;
					if(!$Form->save())
					{
						throw new Exception("Form save error");
					}
					else
					{
						$result['isActive'] = $Form->isActive;
					}
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 2;
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionSetFormReady()
	{
		$request = Yii::app()->request;
		$isReady = $request->getPost("isReady",null);
		$formId = $request->getPost("formId",null);
		$setTo = $request->getPost("setTo",null);
		$db = Yii::app()->db;
		if(($setTo != null) && ($formId != null) && ($isReady != null))
		{
			$result = array(
				"status" => 0,
			);
			$Form = Form::model()->findByPk($formId);
			if($Form == null)
			{
				$result['status'] = 1;
			}
			else
			{
				$transaction = $db->beginTransaction();
				try
				{
					$Form->isReady = $setTo==1?1:0;
					if(!$Form->save())
					{
						//$result['status'] = 2;
						throw new Exception("form save error");
					}
					else
					{
						$result['isReady'] = $Form->isReady;
					}

					// put all the data into a json datapage for cache
					$questions = Form::loadQuestions($formId);
					$FinalForm = FinalForm::model()->find("formId=:f",array(
						":f" => $formId
					));
					if($FinalForm == null)
					{
						$FinalForm = new FinalForm();
						$FinalForm->formId = $formId;
						$FinalForm->createTime = new CDbExpression("NOW()");
						$FinalForm->changeTime = new CDbExpression("NOW()");
					}
					$FinalForm->data = Text::json_encode_ch($questions);
					if(!$FinalForm->save())
					{
						throw new Exception("final form save error");
					}

					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					$result['status'] = 3;
					$result['error'] = $e->getMessage();
				}
			}
			echo Text::json_encode_ch($result);
		}
	}
	public function actionCreateNewForm()
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$shoutkey = $request->getPost("shoutkey","");
		if($shoutkey != "")
		{
			$result = array(
				"status" => 0,
			);
			// create a new form and return the form id
			$Form = new Form();
			//$Form->name = "";
			$Form->shoutkey = $shoutkey;
			$Form->createTime = new CDbExpression("NOW()");
			$Form->createBy = $userId;
			if(!$Form->save())
			{
				$result['status'] = 1;
				$result['error'] = $Form->getErrors();
			}
			else
			{
				$result['formId'] = $Form->id;
			}
			echo Text::json_encode_ch($result);
		}
	}
	// get the list of existing forms
	public function actionGetFormList($s=0,$l=10)
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$result = array(
			"status" => 0,
			"formList" => array(),
		);
		// get the form based on the s and l, and add the active one in the front
		$s = (int)$s;
		$s = $s < 0?0:$s;
		$l = (int)$l;
		$l = $l<=0?1:$l;
		$l = $l > 100?100:$l;
		$sql = "SELECT C_form.*,T_user.userName FROM C_form,T_user WHERE C_form.isActive=0 AND C_form.isDeleted=0 AND C_form.createBy=T_user.userId ORDER BY C_form.createTime DESC LIMIT $s,$l";
		$result['formList'] = Text::sql($sql);
		// get the active one
		$Form = Form::model()->find("isActive=1 AND isDeleted=0");
		$Active =$Form->attributes;
		$Active['userName'] = User::model()->findByPk($Active['createBy'])->userName;
		if($Form != null)
		{
			array_unshift($result['formList'],$Active);
		}
		echo Text::json_encode_ch($result);
	}
	// save stuff for stats
	public function actionSaveStats($statRealId)
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$excuseNote = $request->getPost("excuseNote",NULL);
		$allAndrewIds = $request->getPost("allAndrewIds",NULL);
		$Stat = FormStats::model()->findByPk($statRealId);
		$result = array(
			"status" => 0
		);
		if($Stat != NULL)
		{
			if($excuseNote !== NULL)
			{
				$Stat->excuseNote = $excuseNote;
			}
			if($allAndrewIds !== NULL)
			{
				$Stat->allAndrewIds = $allAndrewIds;
			}
			if(!$Stat->save())
			{
				$result['status'] = 1;
				$result['error'] = $Stat->getErrors();
			}
		}
		echo Text::json_encode_ch($result);
	}
	//
	public function actionGetStats($redo=0)
	{
		$request = Yii::app()->request;
		$userId = Yii::app()->session['userId'];
		$formIds = $request->getPost("formIds",array());
		if(count($formIds) > 0)
		{
			$result = array(
				"status" => 0,
				"statId" => ""
			);
			// get the query Id : sorted formId_formId...formId
			sort($formIds);
			$statId = join("_",$formIds);
			$result['statId'] = $statId;
			// check the stat exists or not
			if(!FormStats::model()->exists("statId=:s",array(":s"=>$statId)) || ($redo==1))
			{
				// not exists , get it and save it
				$statData = array(
					"users" => array(), # andrewId -> specs
					"forms" => array(), # form data info
				);
				foreach($formIds as $formId)
				{
					$FinalForm = FinalForm::model()->find("formId=:f ORDER BY id DESC",array(
						":f"=>$formId
					));

					if($FinalForm != NULL)
					{
						// get the form info for each form
						$FormInfoData = Form::model()->findByPk($formId);
						$statData['forms'][$formId] = $FormInfoData->attributes;
						$formData = json_decode($FinalForm->data,true);
						// get the qId->aId
						$qId2aId = array();
						foreach($formData as $one)
						{
							$qId = $one['id'];
							$qId2aId[$qId] = array();
							foreach($one['answers'] as $a)
							{
								$aId = $a['id'];
								$isCorrect = (int)$a['isCorrect'];
								$qId2aId[$qId][$aId] = $isCorrect;
							}
						}
						// get all the people submit hits
						$SubmitData = SubmitData::model()->findAll("formId=:f ORDER BY submitTime DESC",array(
							":f" => $formId,
						));

						foreach($SubmitData as $oneData)
						{
							$andrewId = $oneData->andrewId;
							// normalize the andrew Id, people write it diff sometimes
							$andrewId = strtolower($andrewId);
							$pattern = "/@.+/";
							$andrewId = preg_replace($pattern,"",$andrewId);// remove the email format


							if(!isset($statData['users'][$andrewId]))
							{
								$statData['users'][$andrewId] = array(
									"forms" => array(),
									"name" => $oneData->name,
									"andrewId" => $andrewId,
								);
							}
							if(!isset($statData['users'][$andrewId]['forms'][$formId]))// so for each student we only get their latest submission
							{
								$statData['users'][$andrewId]['forms'][$formId] = array(
									"qas" => array(),
									"totalCorrect" => 0,
									"name" => $oneData->name,
									"submitTime" => $oneData->submitTime,
									"picData" => $oneData->picData,
									"acc" => 0.0,
								);
								foreach(json_decode($oneData['answers'],true) as $oneQA)
								{
									$qId = $oneQA['qId'];
									$isCorrect = 1;
									foreach($oneQA['answers'] as $oneAnswer)
									{
										$aId = $oneAnswer['aId'];
										$checked = (int)$oneAnswer['checked'];
										if($checked != $qId2aId[$qId][$aId])
										{
											$isCorrect=0;
											break;
										}
									}
									$statData['users'][$andrewId]['forms'][$formId]['qas'][$qId] = $isCorrect;
									if($isCorrect == 1)
									{
										$statData['users'][$andrewId]['forms'][$formId]['totalCorrect']+=1;
									}
								}
								if(count($statData['users'][$andrewId]['forms'][$formId]['qas']) != 0)
								{
									$statData['users'][$andrewId]['forms'][$formId]['acc'] = $statData['users'][$andrewId]['forms'][$formId]['totalCorrect']/count($statData['users'][$andrewId]['forms'][$formId]['qas']);
								}
							}
						}// get all submit for this formId
					}
				}// go through all forms
				// calculate global stats
				$statData['totalForm'] = count($formIds);
				foreach($statData['users'] as $andrewId=>&$student)
				{
					$student['totalAttend'] = count($student['forms']);
					$student['attendRate'] = count($student['forms'])/count($formIds);
					$student['avgAcc'] = 0.0;
					foreach($student['forms'] as $formId=>$oneForm)
					{
						$student['avgAcc']+=$oneForm['acc'];
					}
					if($student['totalAttend'] != 0)
					{
						$student['avgAcc'] = $student['avgAcc']/$student['totalAttend'];
					}
				}
				// save this stats
				$FormStats = new FormStats();
				$FormStats->statId = $statId;
				$FormStats->createTime = new CDbExpression("NOW()");
				$FormStats->data = json_encode($statData);
				if(!$FormStats->save())
				{
					$result['status'] = 1;
					$result['error'] = $FormStats->getErrors();
				}

			}

			echo Text::json_encode_ch($result);
		}
	}

	//修改用户 nickname
	public function actionChangeNickname()
	{
		if(isset($_POST['nickname']) && ($_POST['nickname'] != ""))
		{
			$userId = Yii::app()->session['userId'];
			$User = User::model()->findByPk($userId);
			if($User != NULL)
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					$nicknameBefore = $User->nickName;
					$User->nickName = $_POST['nickname'];
					if(!$User->save())
					{
						throw new Exception("error");
					}
					//修改session
					Yii::app()->session['nickName'] = $User->nickName;
					//加入日志
						//获取user信息
						$nickname = $User->nickName;
					Log::addLog(array(
						"type" => USER_CHANGENICKNAME,
						"userId" => $userId,
						"actionId" => $userId,
						"param" => array(
							"nicknameBefore" => $nicknameBefore,
							"nicknameNow" => $nickname,
						),
					));
					$transaction->commit();
				}catch(Exception $e)
				{
					$transaction->rollback();
					die("error");
				}
			}
		}
	}
	//修改用户 密码 
	public function actionChangePw()
	{
		if(isset($_POST['oldPw']) && isset($_POST['newPw']) && !empty($_POST['newPw']))
		{
			$userId = Yii::app()->session['userId'];
			$User = User::model()->findByPk($userId);
			if(($User == NULL) || ($User->userPw != md5($_POST['oldPw'])))
			{
				$data = array(
					"error" => 1,
				);
				echo Text::json_encode_ch($data);
			}
			else
			{
				$db = Yii::app()->db;
				$transaction = $db->beginTransaction();
				try
				{
					$pwBefore = $User->userPw;
					$User->userPw = md5($_POST['newPw']);
					if(!$User->save())
					{
						throw new Exception("e");
					}
					//添加日志
					Log::addLog(array(
						"type" => USER_CHANGEPW,
						"userId" => $userId,
						"actionId" => $userId,
						"param" => array(
							"pwBefore" => $pwBefore,
							"pwNow" => $User->userPw,
						),
					));
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					die("error");
				}
				$data = array();
				echo Text::json_encode_ch($data);
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
			
			'accessControl',
			//'replaceHtml',
			//'userLevel3 + newProject',//高级用户的筛选
			
		);
	}
	
	public function filterAccessControl($filterChain)
	{
		if(!isset(Yii::app()->session['userId']) || !isset(Yii::app()->session['userName']))
		{
			//不可能是ajax调用，
			if(!Yii::app()->request->isAjaxRequest)
			{
				$this->redirect(Yii::app()->baseUrl."/");
				die("");
			}
			else//未登录且非ajax请求则rediret回外部门户主页
			{
				if(!isset(Yii::app()->session['userId']))
				{
					echo "not set userId";
				}
				if(!isset(Yii::app()->session['userName']))
				{
					echo "not set userName";
				}
				
					die("error:f*c*k.");			
			}
		}
		Yii::import("application.extensions.f");
		$filterChain->run();
	}
	public function filterReplaceHtml($filterChain)
	{
		//对POST字段进行单层的特殊字符过滤
		$exceptions = array();
		if(isset($_POST))	
		{
			foreach($_POST as $key => &$val)
			{
				if(!isset($exceptions[$key]))
				{
					Text::replaceHtml($val);
				}
			}
		}
		$filterChain->run();
	}
	public function filterUserLevel3($filterChain)
	{
		if(Yii::app()->session['userLevel'] != 3)//高级用户
		{
			die("error");
		}
		$filterChain->run();
	}
}
?>
