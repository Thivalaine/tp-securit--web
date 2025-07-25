<?php
require_once 'vendor_jwt.php';
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
$jwt = '';
$error = '';
$secret = 'SuperSecretKey123!';
if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username === 'admin' && $password === 'adminpass') {
        $header = base64url_encode(json_encode(['alg'=>'HS256','typ'=>'JWT']));
        $payload = base64url_encode(json_encode(['user'=>$username,'role'=>'admin']));
        $signature = base64url_encode(hash_hmac('sha256', $header.'.'.$payload, $secret, true));
        $jwt = $header . '.' . $payload . '.' . $signature;
    } else {
        $error = 'Identifiants invalides.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Login JWT sécurisé</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header-lock">🔒</div>
  <h1>Login JWT sécurisé</h1>
  <form method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <button type="submit">Se connecter</button>
  </form>
  <?php if ($jwt) { ?>
    <div style="margin:24px auto;max-width:500px;background:#fff;padding:18px;border-radius:8px;box-shadow:0 2px 8px #1e3c7240;">
      <b>Votre JWT :</b><br>
      <input style="width:90%;font-size:14px;" value="<?php echo $jwt; ?>" readonly>
      <br><a href="profile_jwt_secure.php?token=<?php echo $jwt; ?>">Accéder au profil</a>
    </div>
  <?php } ?>
  <?php if ($error) { echo '<p style="color:red;">'.$error.'</p>'; } ?>
  <a href="login_jwt.php">Retour à la version vulnérable</a>
  <?php include 'footer.php'; ?>
</body>
</html> 