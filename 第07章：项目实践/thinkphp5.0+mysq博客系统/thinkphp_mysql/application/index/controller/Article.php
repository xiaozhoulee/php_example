<?php

namespace app\index\controller;

use think\Controller;

class Article extends Controller
{
    //文章详情页
    public function info()
    {
        //查询(文章，评论)的信息
        $articleInfo = model('Article')->find(input('id'));
        $articleInfo->where('id',$articleInfo['id'])->setInc('click');
        $cates = model('Cate')->order('sort','asc')->select();
        $webInfo = model('System')->find();
        $viewdata = [
            'cates' => $cates,
            'webInfo' => $webInfo,
            'articleInfo' => $articleInfo,
        ];
        $this->assign($viewdata);
        return view();
    }

    //文章评论
    public function comm()
    {
        $data = [
            'content' => input('post.content')
        ];
        $result = model('Comment')->comm($data);
        if ($result == 1){
            $this->success('评论成功！');
        }else{
            $this->error($result);
        }
    }
}
