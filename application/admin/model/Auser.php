<?php
namespace app\admin\Model;
use think\Model;
use think\Db;
class Auser extends Model
{
	protected $updateTime = false;
	public function checkusernameModle(){
		$name = $_POST['username'];
		return Db::name('auser')->where("username = '$name'")->find();
	}
	public function checkpwdModel($userinfo){
		if(strcasecmp($userinfo['password'],md5($_POST['password'])) ==0){
			return true;
		}else{
			return false;
		}
	}
}