<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    
    <?php
    // DB接続設定
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    // DB内にテーブルを作成
    $sql = "CREATE TABLE IF NOT EXISTS test"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."password TEXT"
    .");";
    $stmt = $pdo -> query($sql);
    
    $post = "";
    $posterror = "";
    $delete = "";
    $deleteerror = "";
    $edited = "";
    $editerror = "";
    
    // 削除処理
    if(!empty($_POST["delete"]) && !empty($_POST["deletepassword"])) {
        $deletepassword = $_POST["deletepassword"];
        $id = $_POST["delete"];
        $sql = 'DELETE FROM test WHERE password = :password AND id = :id';
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':password', $deletepassword, PDO::PARAM_STR);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $delete = "投稿番号【" . $id . "】を削除しました";
    } elseif(!empty($_POST["delete"])) {
            $deleteerror = "パスワードを入力してください";
    } elseif(!empty($_POST["deletepassword"])) {
        $deleteerror = "削除する投稿番号を入力してください";
    } else {
        
    }
    
    // 編集処理
    if(!empty($_POST["edit"]) && !empty($_POST["password3"]) && 
       !empty($_POST["editname"]) && !empty($_POST["editcomment"])) {
        $edit = $_POST["edit"];
        $password3 = $_POST["password3"];
        $editname = $_POST["editname"];
        $editcomment = $_POST["editcomment"];
        $sql = 'UPDATE test SET name=:name, comment=:comment WHERE password = :password AND id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':password', $password3, PDO::PARAM_STR);
        $stmt -> bindParam(':id', $edit, PDO::PARAM_INT);
        $stmt -> bindParam(':name', $editname, PDO::PARAM_STR);
        $stmt -> bindParam(':comment', $editcomment, PDO::PARAM_STR);
        $stmt -> execute();
        $edited = "投稿番号【". $edit ."】を編集しました";
    } elseif(!empty($_POST["edit"]) && !empty($_POST["editname"]) && !empty($_POST["editcomment"])) {
        $editerror = "パスワードを入力してください";
    } elseif(!empty($_POST["password3"]) && !empty($_POST["editname"]) && !empty($_POST["editcomment"])) {
        $editerror = "編集対象の投稿番号を入力してください";
    } elseif(!empty($_POST["edit"]) && !empty($_POST["password3"]) && !empty($_POST["editcomment"])) {
        $editerror = "名前を入力してください";
    } elseif(!empty($_POST["edit"]) && !empty($_POST["editname"]) && !empty($_POST["password3"])) {
        $editerror = "コメントを入力してください";
    } elseif(!empty($_POST["edit"]) && !empty($_POST["editcomment"])) {
        $editerror = "名前・パスワードを入力してください";
    } elseif(!empty($_POST["edit"]) && !empty($_POST["editname"])) {
        $editerror = "コメント・パスワードを入力してください";
    } elseif(!empty($_POST["edit"]) && !empty($_POST["password3"])) {
        $editerror = "コメント・名前を入力してください";
    } elseif(!empty($_POST["editcomment"]) && !empty($_POST["editname"])) {
        $editerror = "編集対象の投稿番号・パスワードを入力してください";
    } elseif(!empty($_POST["password3"]) && !empty($_POST["editname"])) {
        $editerror = "編集対象の投稿番号・コメントを入力してください";
    } elseif(!empty($_POST["editcomment"]) && !empty($_POST["password3"])) {
        $editerror = "編集対象の投稿番号・名前を入力してください";
    } elseif(!empty($_POST["editcomment"])) {
        $editerror = "編集対象の投稿番号・名前・パスワードを入力してください";
    } elseif(!empty($_POST["edit"])) {
        $editerror = "名前・コメント・パスワードを入力してください";
    } elseif(!empty($_POST["password3"])) {
        $editerror = "編集対象の投稿番号・名前・コメントを入力してください";
    } elseif(!empty($_POST["editname"])) {
        $editerror = "編集対象の投稿番号・コメント・パスワードを入力してください";
    } else {
        
    }
    
    // 投稿処理
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])) {
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $password = $_POST["password"];
        $sql = $pdo -> prepare("INSERT INTO test (name, comment, password) VALUES (:name, :comment, :password)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':password', $password, PDO::PARAM_STR);
        $sql -> execute();
        $post = "投稿しました";
    } elseif(!empty($_POST["name"]) && !empty($_POST["comment"])) {
        $posterror = "パスワードを入力してください";    
    } elseif(!empty($_POST["comment"]) && !empty($_POST["password"])) {
        $posterror = "名前を入力してください";    
    } elseif(!empty($_POST["password"]) && !empty($_POST["name"])) {
        $posterror = "コメントを入力してください";    
    } elseif(!empty($_POST["name"])) {
        $posterror = "コメント・パスワードを入力してください";
    } elseif(!empty($_POST["comment"])) {
        $posterror = "名前・パスワードを入力してください"; 
    } elseif(!empty($_POST["password"])) {
        $posterror = "名前・コメントを入力してください"; 
    } else {
        
    }
    ?>
    
    <form action="" method="post">
        <p>【　　　投稿フォーム　　　】</p>
        名前　　　　　：<input type="text" name="name"><br>
        コメント　　　：<input type="text" name="comment"><br>
        パスワード　　：<input type="text" name="password">
        <input type="submit" name="submit">
    </form>
    <br>
    
    <?php
    echo $post;
    echo $posterror;
    ?>
    
     <form action="" method="post">
        <p>【　　　削除フォーム　　　】</p>
        削除対象番号　：<input type="number" name="delete"><br>
        パスワード　　：<input type="text" name="deletepassword">
        <input type="submit" name="deletebtn" value="削除">
    </form>
    <br>
    
    <?php
    echo $delete;
    echo $deleteerror;
    ?>
    
    <form action="" method="post">
        <p>【　　　編集フォーム　　　】</p>
        編集対象番号　　：<input type="number" name="edit"><br>
        編集する名前　　：<input type="text" name="editname"><br>
        編集するコメント：<input type="text" name="editcomment"><br>
        パスワード　　　：<input type="text" name="password3">
        <input type="submit" value="編集">
    </form>
    <br>
    
    <?php
    echo $edited;
    echo $editerror;
    ?>
    
    <p>【　　投稿一覧　　】</p>
    
    <?php
    // テーブル選択
    $sql = 'SELECT * FROM test';
    $stmt = $pdo -> query($sql);
    $results = $stmt -> fetchAll();
    foreach($results as $row) {
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
        echo "<hr>";
    }
    ?>
  
</body>
</html>