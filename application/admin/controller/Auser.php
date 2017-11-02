<?php
namespace app\admin\Controller;
use app\admin\model\Auser;
use think\Controller;
use think\Validate;
use think\Db;
use think\Request;
use think\Session; 
class Auser extends Controller
{   
   
    protected $is_login = [''];
    public function _initialize()
    {
    	if (!$this->checklogin() && $this->is_login[0] == '*') {
    		$this->error('您还未登录，请先登录',url('admin/auser/login'));
    
         }
    }    
    
    public function checklogin()
    {
    	return session('?admin');
    }
	public function login()
	{   
		$code = $this->request->param('code');
		//dump($code); 
		return $this->fetch();
	}
	public function dologin(Auser $auth)
	{
		$validate = new Validate([
			'captcha|验证码'=>'require|captcha',
		]);
		
		$data = [
			'captcha'=> $this->request->param('code'),
		];
		
		if(!$validate->check($data))
		{  
			dump($validate->getError());
		}
		$info = $auth->checkusernameModle();
		if (!$info) {
			$this->error('用户不存在');
		}
		$userinfo = $auth->checkpwdModel($info);
		if ($userinfo) {
			$user = new Auser;
			$username = $_POST['username'];
			$user->save([
				'update_time'=>time(),
			],['username'=>$username]);
			$info = $user->checkusernameModle();
			session('uid',$info);
			$this->success('登录成功','admin/index/index');
		}else{
			$this->error('密码错误');
		}
	}
	public function loginout()
	{
		session(null);
		$this->error('您还未登录111，请先登录',url('admin/auser/login'));
	}
}