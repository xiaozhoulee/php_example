<?php

namespace app\admin\controller;

class Member extends Base
{
    //会员列表
    public function all()
    {
        $members = model('Member')->order('create_time','desc')->paginate(10);
        $viewDate = [
          'members' => $members
        ];
        $this->assign($viewDate);
        return view();
    }

    //会员添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];
            $result = model('Member')->add($data);
            if ($result == 1){
                $this->success('添加成功','admin/member/all');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    //会员编辑
    public function edit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'oldpass' => input('post.oldpass'),
                'newpass' => input('post.newpass'),
                'nickname' => input('post.nickname')
            ];
            $result = model('Member')->edit($data);
            if ($result == 1) {
                $this->success('会员修改成功','admin/member/all');
            }else{
                $this->error($result);
            }
        }
        $memberInfo = model('Member')->find(input('id'));
        $viewData = [
            'memberInfo' => $memberInfo
        ];
        $this->assign($viewData);
        return view();
    }

    //会员删除
    public function del()
    {
        $memberInfo = model('Member')->with('comments')->find(input('post.id'));
        $result = $memberInfo->delete();
        if ($result) {
            $this->success('会员删除成功','admin/member/all');
        }else {
            $this->error('删除失败');
        }
    }
}
