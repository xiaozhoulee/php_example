<?php

namespace app\common\model;

use think\Model;

class Admin extends Model
{

    //只读字段，不可修改的字段
    protected $readonly = ['email'];

    //登陆效验
    public function login($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        if ($result) {
            if ($result['status'] != 1) {
                return '此账户被禁用！';
            }
            session('admin', ['id' => $result['id'],
                'nickname' => $result['nickname'],
//                'super' => $result['super']
            ]);
            return 1;
        }else {
            return '用户名或者密码错误！';
        }
    }

    //注册账户

    //接受控制器传来的 $data里面的数据
    public function register($data)
    {
        //把数据分给同模块 common下 validate文件 Admin 进行处理逻辑
        $validate = new \app\common\validate\Admin();
        //判断用户输入的数据是否与逻辑一致，不一致则返回处理逻辑里面的报错信息
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        //一致则会将用户传递的数据传送到数据库中
        $result = $this->allowField(true)->save($data);
        //判断result是否传输成功，成功返回1，失败则返回注册失败
        if ($result) {
            return 1;
        }else{
            return '注册失败';
        }
    }

    //添加管理员
    public function add ($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result){
            return 1;
        }else {
            return '管理员添加失败！';
        }
    }

    //编辑
    public function edit($data) {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $adminInfo = $this->find($data['id']);
        if ($data['oldpass'] != $adminInfo['password']){
            return '原密码错误';
        }
        $adminInfo->password = $data['newpass'];
        $adminInfo->nickname = $data['nickname'];
        $result = $adminInfo->save();
        if ($result) {
            return 1;
        }else{
            return '管理员修改失败';
        }
    }
}