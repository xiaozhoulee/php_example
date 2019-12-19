<?php


namespace app\common\validate;


use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title|文章标题' => 'require|unique:article',
        'tags|标签' => 'require',
        'cateid|所属栏目' => 'require',
        'desc|文章概要' => 'require',
        'content|内容' => 'require',
        'is_top|是否推荐' => 'require'
    ];

    protected $scene =[
        'add' => ['title','tags','cateid','desc','content'],
        'top' => ['is_top'],
        'edit' => ['title','tags','is_top','cate_id','desc','content']
    ];

}