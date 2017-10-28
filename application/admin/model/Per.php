<?php
namespace app\admin\Model;
use think\Model;
class Per extends Model
{
	public function role()
	{
		return $this->belongsTomany('Role','role_per','role_id','per_id');
	}

}