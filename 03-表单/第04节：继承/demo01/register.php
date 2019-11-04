<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    //表单三部曲
//接收到用户提交的数据,保存到txt当中
//1.接受并校验用户传过来的信息
//2.持久化
//3.响应

//接受用户提交的数据,保存文件

//    1.校验参数的完整性
    if (empty($_POST['username'])){
//        没有用户名 或 用户名为空
        $message = '会不会玩';
    }else{
        if (empty($_POST['password'])){
            $message =  '请输入密码';
        }else{
            if (empty($_POST['confirm'])){
                $message =  '请输入确认密码';
            }else{
                if ($_POST['password'] === $_POST['confirm']){
                    if (!(isset($_POST['agree'])) && $_POST['agree'] === 'on'){
                        $message =  '必须同意用户协议';
                    }else{
//                        所有效验都OK
                        $username = $_POST['username'];
                        $password = $_POST['password'];

//                        将数据保存到文件中
                        file_put_contents('users.txt' , $username . '|' . $password . "\n", FILE_APPEND);

                        $message =  '注册成功';
                    }
                }else{
                    $message = '两次密码不一致';
                }
            }
        }


    }
}

?>


<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
             <title>Document</title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <table border="1px">
        <tr>
            <td><label for="username">用户名</label></td>
            <td><input type="text" name="username" id="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"></td>
        </tr>
        <tr>
            <td><label for="password">密码</label></td>
            <td><input type="password" name="password" id="password"></td>
        </tr>
        <tr>
            <td><label for="confirm">确认密码</label></td>
            <td><input type="text" name="confirm" id="confirm"></td>
        </tr>
        <tr>
            <td></td>
            <td><label><input type="checkbox" name="agree">同意用户协议</label></td>
        </tr>
        <?php if(isset($message)): ?>
            <tr>
                <td></td>
                <td><?php echo $message?></td>
            </tr>
        <?php endif ?>
        <tr>
            <td></td>
            <td><button>提交</button></td>
        </tr>
    </table>
</form>
</body>
</html>
