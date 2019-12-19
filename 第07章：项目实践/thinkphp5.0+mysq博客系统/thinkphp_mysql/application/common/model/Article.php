<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{

    //添加文章
    public function add($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else{
            return '文章添加失败！';
        }
    }

    //推荐
    public function top($data){
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('top')->check($data)) {
            return $this->getError();
        }
        $articleInfo = $this->find($data['id']);
        $articleInfo->is_top = $data['is_top'];
        $result = $articleInfo->save();
        if ($result) {
            return 1;
        }else{
            return '更新失败';
        }
    }

    //文章编辑
    public function edit($data)
    {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        $result = $this->isUpdate(true)->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '文章编辑失败！';
        }
    }
}
