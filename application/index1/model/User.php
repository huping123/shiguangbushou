<?php
namespace app\index\model;
use think\Model;
use traits\model\SoftDelete;

class User extends Model
{
	//protected $autoWriteTimestamp = true
	public function getStatusAttr($value) {
		$status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
		return $status[$value];
	}
	public function setNicknameAttr($value)
	{
		return strtolower($value);
	}
	//一对一关联
	public function profile()
	{
		return $this->hasOne('profile','user_id')->bind('adds');
	}
	// public function getStatusAttr($value){
	// 	$status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
	// 	return $status[$value];
	// }
	public function arc()
	{
		return $this->hasMany('arc','user_id');
	}
	//多对多
	public function role()
	{
		return $this->belongsToMany('Role','user_role','r_id','u_id');
	}

}
