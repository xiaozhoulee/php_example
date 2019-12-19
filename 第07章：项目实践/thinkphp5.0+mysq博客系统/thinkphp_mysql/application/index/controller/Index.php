<?php

namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    //首页
    public function index()
    {
        $where = [];
        $catename = null;
        if (input('?id')){
            $where = [
                'cateid' => input('id')
            ];
            $catename = model('Cate')->where('id',input('id'))->value('catename');
        }
        //查询内容(列表，域名,文章,推荐文章) 显示网页
        $articles = model('Article')->where($where)->order('create_time','desc')->paginate(5);
        $topArticles = model('Article')->where('is_top','1')->order('create_time','desc')->limit(10)->select();
        $cates = model('Cate')->order('sort','asc')->select();
        $webInfo = model('System')->find();
        $viewdata = [
          'cates' => $cates,
            'webInfo' => $webInfo,
            'articles' => $articles,
            'catename' => $catename,
            'topArticles' => $topArticles
        ];
        $this->assign($viewdata);
        return view();
    }

    //注册
    public function register()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];
            $result = model('Member')->register($data);
            if ($result == 1) {
                $this->success('注册成功','index/index/login');
            }else{
                $this->error($result);
            }
        }
        $cates = model('Cate')->order('sort','asc')->select();
        $webInfo = model('System')->find();
        $viewdata = [
            'cates' => $cates,
            'webInfo' => $webInfo,
        ];
        $this->assign($viewdata);
        return view();
    }

    //登录
    public function login()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password')
            ];
            $result = model('Member')->login($data);
            if ($result == 1) {
                $this->success('登陆成功','index/index/index');
            }else{
                $this->error($result);
            }
        }
        $cates = model('Cate')->order('sort','asc')->select();
        $webInfo = model('System')->find();
        $viewdata = [
            'cates' => $cates,
            'webInfo' => $webInfo,
        ];
        $this->assign($viewdata);
        return view();
    }

    //退出登录
    public function loginout()
    {
        session(null);
        if (session('?index.id')) {
            $this->error('退出失败!');
        }else{
            $this->success('退出成功','index/index/index');
        }
    }

    //搜索功能
    public function search()
    {
        $keyword = '%' . input('keyword') . '%';
        $where[] = ['title', 'like', $keyword];
        $articles = model('Article')->where($where)->paginate(10, false, $where);
        $viewData = [
            'articles' => $articles,
            'catename' => '"' . input('keyword') . '"' . '搜索结果'
        ];
        $this->assign($viewData);
        return view('index/index');
    }
}
