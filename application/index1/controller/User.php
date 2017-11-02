<?php
namespace app\index\controller;

use app\index\model\User as UserModel;
use app\index\model\Profile;
use app\index\model\Arc;
use think\Loader;
class User
{   
	protected $user;
	public function _initialize()
	{
		$this->user = new UserModel;
	}
	public function add()
	{    

		// public $user;
		// public function _initializa()
		// {
		// 	$this->user = new UserModel;
		// }
		// 使用 Loader 类实例化（单例）
		//使用loader::model('user');可以直接模型名 就可以完成实例化 不用use模型
		$user = Loader::model('role');
		
		// 或者使用助手函数`model`
		//$user = model('User');==>M('user')[3.2]
		//$user = new UserModel;
		//第一种：
		// $user->nickname = 'wangerxiao';
		// $user->status = '1';
		// $user->save();
		//第二种：
		// $user->data(['nickname'=>'WERTY','status'=>1]);
		// $user->save();
		//$user = new UserModel();
		//$user->nickname = 'THINKPHP';
		//$user->save();
		//第三种办法：
		//$user->save(['nickname'=>'hahah','status'=>1]);	
		//$user = new UserModel(['nickname'=>'hahah','status'=>1]);
		//$user->save();
		//UserModel::create(['nickname'=>'hahah','status'=>1]);
		/*$data = [
			['nickname'=>'www','status'=>1],
			['nickname'=>'dd','status'=>1],
			['nickname'=>'ww','status'=>1]
		];*/
		//$user->saveAll($data);
		//dump($user->id);
	}
	public function updateInfo()
	{
		 $info = UserModel::get(39);
		 return $info->update_time;
		// $info->nickname = 'thjsf';
		// $info->save()   ;
		//$info = UserModel::get(5);
		// return $info->status;
		//return $info->getData('status');
		//dump($info->toArray());
		//$info->delete();
		//$info->nickname = 'wpshi';
		//$info->save();
		//$user = new UserModel();
		//$user->save(['nickname'=>'huahua'],['id'=>5]);
		//$info = $user->where('id',5)->find();
		//return $info['nickname'];
		//$user = new UserModel(['nickname'=>'WERTYU','status'=>1]);
		//$user->save();
	}
	public function oneToOne()
	 {
	 	$info = UserModel::get(11);
	 	echo $info->toJson();
	 	echo '<br />';
	 	echo $info->appendRelationAttr('profile',['adds'])->
	 	toJson();
	// 	$info = UserModel::get(18,'profile');
	// 	return $info->profile->adds;
	 	// $info = Profile::get(4);
	 	// return $info->user->username;
	 	//关联新增
	 	// $info = UserModel::get(11);
	 	// return $info->profile()->save(['adds'=>'马德里']);
	}
	public function oneToMany()
	{
		// $info = UserModel::get(11);
		// foreach ($info->arc as $key => $value) {
		// 	dump($value->adds);
			
		// }
		$info  = Arc::get(2);
		return $info->user->username;
	}
	public function ManyToMany()
	{
		// $info = UserModel::get(11);
		// foreach ($info->role as $key => $value) {
		// 	dump($value->name);
		// }
		 $info = UserModel::get(26);
		// $info->role()->save(['name'=>'后台']);
		$info->role()->save(3);

	}
}