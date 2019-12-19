<?php


namespace app\common\validate;

use think\Validate;

class Cate extends Validate
{
    protected $rule = [
        'catename|栏目名称' => 'require|unique:cate',
        'sort|栏目排序' => 'require'
    ];

    protected $scene = [
      'add' => ['catename', 'sort'],
      'sort' => ['sort'],
        'edit' => ['catename']
    ];

}