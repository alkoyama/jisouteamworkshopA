<?php

session_start();

session_unset();
session_destroy();

echo "ログアウトしました";
echo '<a href="index_7thA.php">ストアフロントへ戻る</a>';
?>
