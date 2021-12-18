
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title></title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>

<?php
include('LotteryGame.php');

$game = new LotteryGame(8, 20);
$game->generateBets();
$game->generateResult();
$game->showTable();
?>

</body>
</html>