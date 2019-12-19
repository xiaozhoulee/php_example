<?php


namespace app\common\validate;


use think\Validate;

class System extends Validate
{
    protected $rule = [
        'webname|网站信息' => 'require',
        'copyright|版权信息' => 'require'
    ];
}