<?php

namespace app\common\model;

use think\Model;

class Member extends Model
{
    //只读字段,意思是：只可以读取不可以修改
    protected $readonly = ['username','email'];

    //关联评论
    public function comments()
    {
        return $this->hasMany('Comment','member_id','id');
    }

    //会员添加
    public function add($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else{
            return '会员验证失败';
        }
    }

    //会员编辑
    public function edit($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $memberInfo = $this->find($data['id']);
        if ($data['oldpass'] != $memberInfo['password']) {
            return '原密码不正确';
        }
        $memberInfo->password = $data['newpass'];
        $memberInfo->nickname = $data['nickname'];
        $result = $memberInfo->save();
        if ($result){
            return 1;
        }else {
            return '会员修改失败！';
        }
    }

    //会员注册
    public function register($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '注册失败！';
        }
    }

    //登录
    public function login($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        unset($data['verify']);
        $result = $this->where($data)->find();
        if ($result) {
            $sessionData = [
                'id' => $result['id'],
                'nickname' => $result['nickname']
            ] ;
            session('index',$sessionData);
            return 1;
        }else{
            return '登录失败！';
        }
    }
}
