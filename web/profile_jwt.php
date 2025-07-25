<?php
require_once 'vendor_jwt.php';
$user = '';
$role = '';
$erreur = '';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $parts = explode('.', $token);
    if (count($parts) === 3) {
        $payload = json_decode(base64_decode($parts[1]), true);
        if ($payload && isset($payload['user'])) {
            $user = $payload['user'];
            $role = $payload['role'];
        } else {
            $erreur = 'Token invalide.';
        }
    } else {
        $erreur = 'Token mal formé.';
    }
} else {
    $erreur = 'Aucun token fourni.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil JWT vulnérable</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header-lock">🔒</div>
  <h1>Profil JWT vulnérable</h1>
  <?php if ($user) { ?>
    <div style="margin:24px auto;max-width:500px;background:#fff;padding:18px;border-radius:8px;box-shadow:0 2px 8px #1e3c7240;">
      <b>Bienvenue, <?php echo htmlspecialchars($user); ?> !</b><br>
      Rôle : <?php echo htmlspecialchars($role); ?><br>
      <span style="color:red;">(Vulnérable : le token n'est pas vérifié !)</span>
    </div>
  <?php } else { ?>
    <p style="color:red;">Accès refusé : <?php echo $erreur; ?></p>
  <?php } ?>
  <a href="login_jwt.php">Retour au login</a>
  <?php include 'footer.php'; ?>
</body>
</html> 