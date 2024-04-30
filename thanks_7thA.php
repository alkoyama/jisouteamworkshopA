<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ご注文ありがとうございます</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>ご注文ありがとうございました！</h1>
        <p>またのご利用をお待ちしております。</p>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['oid'])) {
            $oid = htmlspecialchars($_GET['oid']);
            echo "<p>注文番号: <strong>$oid</strong></p>";
        } else {
            echo "<p>注文番号が見つかりません。</p>";
        }
        ?>

        <!-- ホームページに戻る -->
        <a href="index_7thA.php" class="btn btn-primary mt-3">ストアフロントに戻る</a>
    </div>
</body>
</html>