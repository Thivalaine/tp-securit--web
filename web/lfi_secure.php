<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>LFI sécurisée</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header-lock">🔒</div>
  <h1>Démo LFI sécurisée</h1>
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
    $allowed = ['about.txt', 'contact.txt'];
    if (isset($_GET['page']) && in_array($_GET['page'], $allowed, true)) {
      include "pages/" . $_GET['page'];
    } elseif (isset($_GET['page'])) {
      echo "Fichier non autorisé.";
    }
    ?>
  </div>
  <a href="lfi.php">Retour à la version vulnérable</a>
  <?php include 'footer.php'; ?>
</body>
</html> 