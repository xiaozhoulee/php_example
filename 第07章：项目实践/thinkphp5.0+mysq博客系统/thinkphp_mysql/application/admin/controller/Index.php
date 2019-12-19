<?php

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    //重复登录过滤
    public function _initialize()
    {
        if (session('?admin.id')) {
            $this->redirect('admin/home/index');
        }
    }

    //后台登录
    public function login()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('username'),
                'password' => input('password')
            ];
            $result = model('Admin')->login($data);
            if ($result == 1) {
                $this->success('登录成功！', 'admin/home/index');
            }else {
                $this->error($result);
            }
        }
        return view('login');
    }

    //注册
    public function register()
    {
        //接受前台ajax传来的数据并进行验证
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];
            //如果验证通过后，进行在model模块下的Admin文件处理逻辑
            $result = model('Admin')->register($data);
            //接受到model模块下Admin处理的逻辑返回的数据以后
            //判断模块下Admin文件是否处理正确,正确则通过内置方法 success 返回注册成功并跳转到url页面，失败则输出模板里面处理的报错信息
            if ($result == 1){
                $this->success('注册成功' , 'admin/index/login');
            }else{
                $this->error($result);
            }
        }
        //应用默认地址的view视图模板
        return view();
    }

    //忘记密码
    public function forget()
    {
        return view();
    }
}
