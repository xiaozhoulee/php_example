<?php


namespace app\common\validate;

use think\Validate;

class Admin extends Validate
{
    //验证信息是否为空
    protected $rule = [
        'username|管理员账户' => 'require',
        'password|密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'oldpass|原密码' => 'require',
        'newpass|新密码' => 'require',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email',
        'code|验证码' => 'require'
    ];

    //验证场景
    protected $scene = [
        'login' => ['username','password'],
        'register' => ['username','password','conpass','nickname','email'],
        'reset' => ['code'],
        'add' => ['username','password','conpass','nickname','email'],
        'edit' => ['oldpass','newpass','nickname']
    ];
}