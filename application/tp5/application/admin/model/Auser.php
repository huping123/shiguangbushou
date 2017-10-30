<?php
namespace app\admin\Model;
use think\Model;
use think\Db;
class Auser extends Model
{
	protected $updateTime = false;
	//多对多 管理员、角色
	public function role()
	{	
		return $this->belongsToMany('Role','auser_role', 'role_id', 'auser_id');
	}
	public function checkusernameModle(){
		$name = $_POST['username'];
		return Db::name('auser')->where("username = '$name'")->find();
	}
	public function checkpwdModel($userinfo){
		if(strcasecmp($userinfo['password'],($_POST['password'])) ==0){
			return true;
		}else{
			return false;
		}
	}
	
}