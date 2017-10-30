<?php
namespace app\admin\Model;
use think\Model;

class Role extends Model
{    //多对多 角色 权限
	public function per()
	{  
		return $this->belongsToMany('Per','role_per','per_id','role_id');
	}
}