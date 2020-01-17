<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php

class AdminController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout = 'adminLayout';
	public function actionIndex($r="")// can have a redirect url, after successful login will go there //$r can be urldecode and add index.php/$r
	{
		//$this->layout = "";
		//采用不需要使用cookie的图片验证方式，且验证不需要读取session cookie文件,更迅速,(暂不用)
			//缺点是不能ajax刷新验证码
			//(验证码和对应的加密序列必须同时产生，ajax中不能同时返回两种数据?通过产生临时图片文件然后一起返回图片地址与加密序列?)
		/*
		//cipher method
		//设置lastLoginTime以防止单线程dos攻击
		Yii::app()->session['lastLoginTime'] = time();
		Yii::import("application.extensions.Cipher");
		$code = sprintf("%04d",rand(1,9999));
		$encryptedCode = base64_encode(Cipher::init($code)->encrypt());//产生可传递字符串，cipher加密后的字符串会在传递中丢失
		$this->render('login',array(
			'code' => base64_encode(Cipher::init($code)->encrypt()),
			'num'=>$code,
			'encryptedCode' => $encryptedCode,
		));*/
		//session method:
		//设置lastLoginTime以防止单线程dos攻击,在UserController中验证
		Yii::app()->session['lastLoginTime'] = time();
		$r = urldecode($r);
		//$r = str_replace("site")
		$this->render('login',array(
			"redirect" => $r
		));
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
			'pageCheck + index',//已经登录的不能进入页面
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