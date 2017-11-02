<?php
namespace app\index\controller;

use think\Controller;
use think\Validate;
use  think\Session;
use app\index\model\User as UserModel;
use think\Request;
use think\Ucpaas;
class User extends Controller
{
	protected $user;
	protected function _initialize()
	{
		$this->user = new UserModel;
	}
	public function index()
	{
		$this->fetch();
	}

	public function unserInfo()
	{
		return $this->hasMany('unserInfo', 'u_id');
	}


	public function login()
	{
		return $this->fetch();
	}

	//判断登陆信息
	public function logp()
	{
		$data = $_POST;
		if($data==""){
			$data = ['error'=>0, 'info' => '信息错误'];
		}else{
			$data = ['error'=>1, 'info' => '信息正确'];

		}
		 echo json_encode($data);
	}
	public function log(UserModel $usermodel)
	{
		$data = $usermodel->insertData($_POST);
		// if($data){
			session('mobile',$_POST['phone']);
			$this->success('进入成功',url('index/index/index'));
		// }else {
		// 	$this->error('进入失败',url('index/user/login'));
		// }
	} 
	
	public function loginout()
	{
		session(null);
		$this->success('退出登录成功',url('index/user/index'));
	}
    // 判断手机号是否存在
    public function mobile()
    {

         $mobile = $_POST['mobile'];
        if($this->user::checkMobile($mobile))
        {
            $data = ['err'=>1,'info'=>'手机号已存在'];
        }else{
            $data = ['err'=>0,'info'=>'手机号可使用'];
        }
        echo json_encode($data);
    }

    //网站后台首页  
   public function upload()  
   {  
        $file = request()->file('photo');  
        $data=$_POST;  
      //  if(isset($file)){  
          
        $info = $file->move('static/images/upload/');  
           var_dump($info) ;die;  
  
      //   if($info){  
      //   // 成功上传后 获取上传信息  
      //    $path = $info->getSaveName();  
      //    $path = '/static/images/upload/' . str_replace("\\", "/" ,$path);  
         
      //    // var_dump($path);die();
      //    if(session('?mobile'))
      //    {
      //       $mobile = session('mobile');
      //       $head = Douser::checkHead($username,$path);
      //       if($head)
      //       {
      //           $this->success('上传成功','index/index/account');
      //       }else{  
      //           $this->error('上传失败','index/index/account');  
      //        }  

      //    }
  
      //   }else{  
      //       $this->error('上传失败','account');  
      //   }  
      // }else{
      //       $this->error('上传失败','account');  
      // }
    }  









   
    //验证码验证
    public function yzm()
    {
    	$data = "";
    	$validate = new Validate([
			'captcha|验证码'=>'require|captcha'
		]);
		$data = [
			'captcha'=>$this->request->param('code'),
		];
			if (!$validate->check($data)) {
				return $validate->getError();
			} else {
				return  $data="";
			}
    }

    // 手机短信的验证
	public function dosafety()
	{		
	   //  //初始化必填
	    $options['accountsid']='c40ae9c7d4ead7de54cb79411ef6ef48';
	     $options['token']='8cb45561c999fbe3def9d57e4e0aed20';
	     $str = '12345678900987654321';
	     $str1 = substr(str_shuffle($str),0,4);
	   //  //$_SESSION['phonecode'] = $str1;
	     session('phonecode',$str1);
	    //初始化 $options必填
	    $ucpass = new Ucpaas($options);
	    //开发者账号信息查询默认为json或xml
	    //短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
	   $appId = "0e04a1be91074e199a3158fa57cf194f";
	   $to = $_POST['phone'];
	   $templateId = "153465";
	   $param=$str1;
	    echo json_encode(array('notice'=>$str1));
	    $ucpass->templateSMS($appId,$to,$templateId,$param);
    }

     //用户退出
     public function out()
     {
        session(null);
        $this->success('退出成功','/index/index/index');
     }

 }
