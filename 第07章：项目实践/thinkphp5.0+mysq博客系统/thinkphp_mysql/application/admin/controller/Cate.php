<?php

namespace app\admin\controller;

class Cate extends Base
{
    //栏目列表
    public function list()
    {
//        查询数据库中添加的数据 order正序输出 paginate 分栏 分1栏
        $cates = model('Cate')->paginate(10);
        //定义一个模板数据变量
        $viewDate = [
            'cates' => $cates
        ];
        $this->assign($viewDate);
        return view();
    }

    //栏目添加
    public function add()
    {
        if (request()->isAjax()){
            $data = [
              'catename' => input('post.catename'),
                'sort' => input('post.sort')
            ];
            $result = model('Cate')->add($data);
            if ($result == 1) {
                $this->success('栏目添加成功','admin/cate/list');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    //排序
    public function sort()
    {
        $data = [
          'id' => input('post.id'),
            'sort' => input('post.sort')
        ];
        $result = model('Cate')->sort($data);
        if ($result == 1){
            $this->success('排序成功');
        }else{
            $this->error($result);
        }
    }

    //栏目编辑
    public function edit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'catename' => input('post.catename')
            ];
            $result = model('Cate')->edit($data);
            if ($result == 1){
                $this->success('栏目编辑成功！','admin/cate/list');
            }else {
                $this->error($result);
            }
        }
        $cateInfo = model('Cate')->find(input('id'));
        //模板变量
        $viewdata = [
          'cateInfo' => $cateInfo
        ];
        $this->assign($viewdata);
        return view();
    }

    //栏目删除
    public function del()
    {
        $cateInfo = model('Cate')->find(input('id'));
        $result = $cateInfo->delete();
        if ($result) {
            $this->success('栏目删除成功！', 'admin/cate/list');
        }else {
            $this->error('栏目删除失败！');
        }
    }
}
