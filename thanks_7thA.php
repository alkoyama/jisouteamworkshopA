<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/thanks_7thA.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <title>ご注文ありがとうございます</title>
</head>
<body>
  <div class="container text-center mt-5">
    <div class="fade-in"><img src="./images/thanks/thanks_001_fade-in.png" alt="ご注文感謝☆彡"></div> 
        
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['oid'])) {
        $oid = htmlspecialchars($_GET['oid']);
        echo "<p>注文番号: <strong>$oid</strong></p>";
     } else {
        echo "<p>注文番号が見つかりません。</p>";
     }
    ?>

        <!-- ホームページに戻る -->
    <div class="korokoro"><img src="./images/thanks/thanks_002_korokoro.gif"></div>
    <a href="index_7thA.php" class="btn btn-primary ">ストアフロントに戻る</a>
  </div>
</body>
</html>
