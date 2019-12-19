<?php

namespace app\common\model;

use think\Model;

class Cate extends Model
{
    //关联文章
    public function article()
    {
        return $this->hasMany('Article','cateid','id');
    }

    //栏目添加
    public function add($data)
    {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->save($data);
        if ($result) {
            return 1;
        }else {
            return '栏目添加失败！';
        }
    }

    //栏目排序
    public function sort($data)
    {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('sort')->check($data)) {
            return $this->getError();
        }
        $cateInfo = $this->find($data['id']);
        $cateInfo->sort = $data['sort'];
        $result = $cateInfo->save();
        if ($result) {
            return 1;
        }else {
            return '排序失败';
        }
    }

    //栏目编辑
    public function edit($data)
    {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $cateInfo = $this->find($data['id']);
        $cateInfo->catename = $data['catename'];
        $result = $cateInfo->save();
        if ($result){
            return 1;
        }else{
            return '栏目编辑失败';
        }
    }

}
