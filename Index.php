<?php
namespace app\index\controller;
use \think\Request;
use \think\Db;

class Index
{
    public function index(Request $request)
    {
        //$request = Request::instance();
        //return $request->url(true);
        dump($request->param('name'));
    }  
}

    
