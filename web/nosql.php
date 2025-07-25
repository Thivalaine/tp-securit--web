<?php
$client = new MongoDB\Driver\Manager('mongodb://tpuser:tppass@mongo:27017/tpsecu');
$message = '';
if (isset($_POST['username'], $_POST['password'])) {
    $filter = [
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];
    $query = new MongoDB\Driver\Query($filter);
    $rows = $client->executeQuery('tpsecu.users', $query)->toArray();
    if (count($rows) > 0) {
        $message = 'Connecté !';
    } else {
        $message = 'Identifiants invalides.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Login NoSQL vulnérable</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header-lock">🔒</div>
  <h1>Login NoSQL vulnérable</h1>
  <form method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <button type="submit">Se connecter</button>
  </form>
  <p style="color:red;">Vulnérable à l'injection NoSQL !</p>
  <p><?php echo $message; ?></p>
  <a href="nosql_secure.php">Voir la version sécurisée</a>
  <?php include 'footer.php'; ?>
</body>
</html> 