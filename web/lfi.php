<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>LFI vulnérable</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header-lock">🔒</div>
  <h1>Démo LFI vulnérable</h1>
  <form method="get">
    <label>Choisir une page à inclure :</label><br>
    <select name="page">
      <option value="about.txt">À propos</option>
      <option value="contact.txt">Contact</option>
    </select>
    <button type="submit">Afficher</button>
  </form>
  <div style="margin:24px auto;max-width:400px;background:#fff;padding:18px;border-radius:8px;box-shadow:0 2px 8px #1e3c7240;">
    <?php
    if (isset($_GET['page'])) {
      $file = $_GET['page'];
      include "pages/" . $file;
    }
    ?>
  </div>
  <a href="lfi_secure.php">Voir la version sécurisée</a>
  <?php include 'footer.php'; ?>
</body>
</html> 