# TP Sécurité Web – Vulnérabilités (PHP, MongoDB, Docker)

## Lancement rapide avec Docker

1. **Prérequis** : [Docker Desktop](https://www.docker.com/products/docker-desktop/) installé
2. Dans le dossier du projet :
   ```sh
   docker-compose up --build
   ```
3. Accéder au site : [https://localhost:8080](https://localhost:8080)
   - Ignore l'avertissement de sécurité (certificat auto-signé)

---

## 1. Injection NoSQL (MongoDB)

- Page : `nosql.php` (vulnérable), `nosql_secure.php` (corrigée)
- Test :
  - Utilisateur : `admin` / Mot de passe : `adminpass` (OK)
  - OU :
    - Utilisateur : `{"$ne":null}`
    - Mot de passe : `{"$ne":null}`
    - → Tu es connecté même sans le bon mot de passe (faille)
- Remédiation : cast en string, pas d'opérateurs spéciaux (voir version sécurisée)

---

## 2. LFI (Local File Inclusion)

- Page : `lfi.php` (vulnérable), `lfi_secure.php` (corrigée)
- Test :
  - Sélectionne une page (about.txt/contact.txt) → OK
  - Modifie l’URL : `lfi.php?page=../../nosql.php` → inclusion de fichiers non prévus (faille)
- Remédiation : liste blanche des fichiers autorisés (voir version sécurisée)

---

## 3. JWT (JSON Web Token)

- Pages :
  - `login_jwt.php` (génère un JWT vulnérable, alg=none, pas de signature)
  - `profile_jwt.php` (accepte n’importe quel JWT bien formé)
  - `login_jwt_secure.php` (JWT signé, alg=HS256, clé forte)
  - `profile_jwt_secure.php` (vérifie la signature)
- Test :
  - Connecte-toi avec `admin` / `adminpass` sur la version vulnérable
  - Modifie le token (payload) ou crée un token à la main → accès accordé (faille)
  - Sur la version sécurisée, toute modification du token est refusée
- Remédiation : signature forte, vérification stricte de l’algorithme et de la signature
- **Remarque** : Les tokens JWT sont maintenant compatibles jwt.io et outils JWT.

---

## HTTPS et Let's Encrypt

- En local, le certificat est auto-signé (pour test uniquement).
- En production, utiliser [Let’s Encrypt](https://letsencrypt.org/) pour un vrai certificat SSL (voir documentation officielle).

---

## Lancement sans Docker (manuel)

1. **Installer** :
   - [XAMPP](https://www.apachefriends.org/fr/index.html) ou WAMP (pour Apache+PHP)
   - [MongoDB](https://www.mongodb.com/try/download/community)
2. Placer le contenu du dossier `web` dans le dossier `htdocs` de XAMPP/WAMP.
3. Créer la base et l’utilisateur MongoDB (voir `db/init-mongo.js`).
4. Adapter la connexion dans les fichiers PHP si besoin (host, user, password).
5. Pour HTTPS local, générer un certificat auto-signé et configurer Apache (voir tutos XAMPP/WAMP).

---

**Auteur :** Projet réalisé par Théo DAVIGNY et Victor DE DOMENICO