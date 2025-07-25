<?php
require_once 'vendor_jwt.php';
function base64url_decode($data) {
    $remainder = strlen($data) % 4;
    if ($remainder) {
        $padlen = 4 - $remainder;
        $data .= str_repeat('=', $padlen);
    }
    return base64_decode(strtr($data, '-_', '+/'));
}
$user = '';
$role = '';
$erreur = '';
$secret = 'SuperSecretKey123!';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $parts = explode('.', $token);
    if (count($parts) === 3) {
        $header = json_decode(base64url_decode($parts[0]), true);
        $payload = json_decode(base64url_decode($parts[1]), true);
        $signature = base64url_decode($parts[2]);
        $expected = hash_hmac('sha256', $parts[0].'.'.$parts[1], $secret, true);
        if ($header && $payload && isset($payload['user']) && hash_equals($signature, $expected)) {
            $user = $payload['user'];
            $role = $payload['role'];
        } else {
            $erreur = 'Token invalide ou signature incorrecte.';
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
  <title>Profil JWT sécurisé</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header-lock">🔒</div>
  <h1>Profil JWT sécurisé</h1>
  <?php if ($user) { ?>
    <div style="margin:24px auto;max-width:500px;background:#fff;padding:18px;border-radius:8px;box-shadow:0 2px 8px #1e3c7240;">
      <b>Bienvenue, <?php echo htmlspecialchars($user); ?> !</b><br>
      Rôle : <?php echo htmlspecialchars($role); ?><br>
      <span style="color:green;">(Signature vérifiée !)</span>
    </div>
  <?php } else { ?>
    <p style="color:red;">Accès refusé : <?php echo $erreur; ?></p>
  <?php } ?>
  <a href="login_jwt_secure.php">Retour au login</a>
  <?php include 'footer.php'; ?>
</body>
</html> 