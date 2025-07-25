<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>TP Sécurité Web – Accueil</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .accueil-list {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 18px;
      padding: 0;
      margin: 0;
      list-style: none;
    }
    .accueil-list li {
      background: #f5f8ff;
      border-radius: 8px;
      box-shadow: 0 2px 8px #1e3c7220;
      padding: 14px 24px;
      min-width: 260px;
      text-align: center;
      font-size: 18px;
    }
    .accueil-list a { font-size: 16px; }
    .accueil-guide {
      margin-top: 32px;
      text-align: center;
      font-size: 17px;
    }
  </style>
</head>
<body>
  <div class="header-lock">🔒</div>
  <h1>TP Sécurité Web – Accueil</h1>
  <div style="max-width:500px;margin:32px auto;background:#fff;padding:24px 18px 18px 18px;border-radius:12px;box-shadow:0 2px 12px #1e3c7240;">
    <h2 style="text-align:center;">Vulnérabilités à tester :</h2>
    <ul class="accueil-list">
      <li><b>NoSQL Injection</b><br><a href="nosql.php">Vulnérable</a> | <a href="nosql_secure.php">Sécurisé</a></li>
      <li><b>LFI (Local File Inclusion)</b><br><a href="lfi.php">Vulnérable</a> | <a href="lfi_secure.php">Sécurisé</a></li>
      <li><b>JWT</b><br><a href="login_jwt.php">Vulnérable</a> | <a href="login_jwt_secure.php">Sécurisé</a></li>
    </ul>
    <div class="accueil-guide"><a href="TESTS.md">Guide de test</a></div>
  </div>
  <?php include 'footer.php'; ?>
</body>
</html> 