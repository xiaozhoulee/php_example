<?php


namespace app\common\validate;

use think\Validate;

class Member extends Validate
{
    protected $rule = [
        'username|用户名' => 'require',
        'password|密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'oldpass|原密码' => 'require',
        'newpass|新密码' => 'require',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email|unique:member',
    ];

    protected $scene =[
      'add' => ['username','password','nickname','email'],
        'edit' => ['oldpass', 'newpass', 'nickname'],
        'register' => ['username','password','conpass','nickname','email'],
        'login' => ['username','password']
    ];
}