<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$db = new SQLite3("./test.db");
if (!$db) {
    echo('DB接続エラー');
}else{
print('接続に成功しました。<br>');
}

?>
</body>
</html>