<?php

namespace app\admin\controller;

class Article extends Base
{
    //文章列表
    public function list()
    {
        $articles = model('Article')->order(['is_top' => 'asc', 'create_time' => 'desc'])->paginate(10);
        $viewData = [
            'articles' => $articles
        ];
        $this->assign($viewData);
        return view();
    }

    //文章添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top', 0),
                'cateid' => input('post.cateid'),
                'desc' => input('post.desc'),
                'content' => input('post.content')
            ];
            $result = model('Article')->add($data);
            if ($result == 1) {
                $this->success('文章添加成功', 'admin/article/list');
            } else {
                $this->error($result);
            }
        }
        $cates = model('Cate')->select();
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    //推荐
    public function top()
    {
        $data = [
            'id' => input('post.id'),
            'is_top' => input('post.is_top') ? 0 : 1
        ];
        $result = model('Article')->isUpdate(true)->allowField(true)->save($data);
        if ($result) {
            $this->success('操作成功！', 'admin/article/list');
        } else {
            $this->error('操作失败！');
        }
    }

    //文章编辑
    public function edit()
    {
        if (request()->isAjax()){
            $data = [
                'id' => input('post.id'),
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top',0),
                'cate_id' => input('post.cateid'),
                'desc' => input('post.desc'),
                'content' => input('post.content')
            ];
            $result = model('Article')->edit($data);
            if ($result == 1) {
                $this->success('文章编辑成功！', 'admin/article/list');
            }else {
                $this->error($result);
            }
        }
        $articleInto = model('Article')->find(input('id'));
        $cates = model('Cate')->select();
        $viewData = [
            'articleInfo' => $articleInto,
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    //文章删除
    public function del()
    {
        $articleInfo = model('Article')->find(input('post.id'));
        $result = $articleInfo->delete();
        if ($result){
            $this->success('文章删除成功','admin/article/list');
        }else {
            $this->error('文章删除成功');
        }
    }
}