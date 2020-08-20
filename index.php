<?php
define('FILENAME','./message.txt');
date_default_timezone_set('Asia/Tokyo');

//reset
$now_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$massage = array();
$message_array = array();

//書き込みがあるなら
if(
!empty($_POST['btn_submit'])
){
    if($file_handle = fopen(FILENAME,"a")){
        $now_date = date("Y-m-d h:i:s");
        $data =
            "'".$_POST['view_name'].
            "':'".$_POST['message'].
            "':'".$now_date."'\n";
        fwrite($file_handle,$data);
        fclose($file_handle);
    }
}

if($file_handle = fopen(FILENAME,'r')){
    while($data = fgets($file_handle)){
        $split_data = preg_split('/\'/',$data);
        $message  = array('view_name' => $split_data[1],
                            'message' => $split_data[3],
                            'post_date' => $split_data[5],
                            );
        array_unshift($message_array,$message);
    }


    fclose($file_handle);
}

?>
<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="reset.css">
<link rel="stylesheet" href="main.css">
<head>
    <meta charset="utf-8">
    <title>掲示板の練習</title>
    <style>
    </style>
</head>

<body>
    <h1>掲示板</h1>
    <!-- ここにメッセージの入力フォームを設置 -->
    <form method="post">
        <div>
            <label for="view_name">
                表示名
            </label>
        </div>
        <div>
            <label for="message">
                ひと言メッセージ
            </label>
            <textarea name="message" id="message">
            </textarea>
        </div>
        <input type="submit" name="btn_submit" value="書き込む">
    </form>
    <hr>
    <section>
        <!-- ここに投稿されたメッセージを表示 -->
        <?php if(!empty($message_array)): ?>
        <?php foreach($message_array as $value ) : ?>
            <article>
                <div class="info">
                    <h2>
                        <?php echo $value['view_name']; ?>
                    </h2>
                    <time>
                        <?php echo date('Y年m月d日 H:i',strtotime($value['post_date'])) ?>
                    </time>
                </div>
                <p>
                    <?php echo $value['message']; ?>
                </p>
            </article>
        <?php endforeach ; ?>
        <?php endif ; ?>
    </section>
</body>

</html>