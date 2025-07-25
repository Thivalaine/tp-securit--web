# Guide de test – TP Sécurité Web

## 1. Injection NoSQL (MongoDB)

### Page vulnérable : `nosql.php`
- Accès : https://localhost:8080/nosql.php
- **Test normal** :
  - Utilisateur : `admin`
  - Mot de passe : `adminpass`
  - Résultat : Connecté !
- **Test d’injection NoSQL** :
  - Utilisateur : `{"$ne":null}`
  - Mot de passe : `{"$ne":null}`
  - Résultat : Connecté ! (faille)
- **Explication** : Le filtre MongoDB accepte tout utilisateur dont le champ n’est pas null.

### Page sécurisée : `nosql_secure.php`
- Accès : https://localhost:8080/nosql_secure.php
- Refais le test d’injection :
  - Utilisateur : `{"$ne":null}`
  - Mot de passe : `{"$ne":null}`
  - Résultat : Identifiants invalides. (remédiation)

---

## 2. LFI (Local File Inclusion)

### Page vulnérable : `lfi.php`
- Accès : https://localhost:8080/lfi.php
- Sélectionne une page (about.txt/contact.txt) → OK
- Modifie l’URL :
  - `https://localhost:8080/lfi.php?page=../../nosql.php`
  - Résultat : Inclusion d’un fichier non prévu (faille)
- **Exemple d’attaque réelle (Linux)** :
  - `https://localhost:8080/lfi.php?page=../../../../etc/passwd`
  - Résultat : Affiche le contenu du fichier système `/etc/passwd` (si le serveur y a accès)

### Page sécurisée : `lfi_secure.php`
- Accès : https://localhost:8080/lfi_secure.php
- Refais le test avec `?page=../../nosql.php` ou `?page=../../../../etc/passwd`
  - Résultat : Fichier non autorisé. (remédiation)

---

## 3. JWT (JSON Web Token)

### Pages vulnérables : `login_jwt.php` / `profile_jwt.php`
- Accès : https://localhost:8080/login_jwt.php
- Connecte-toi avec `admin` / `adminpass`
- Récupère le JWT affiché (exemple) :
  - `eyJhbGciOiJub25lIiwidHlwIjoiSldUIn0.eyJ1c2VyIjoiYWRtaW4iLCJyb2xlIjoiYWRtaW4ifQ.`
- Modifie le payload du token (ex : change `"role":"admin"` en `"role":"superadmin"`), ré-encode en base64url, et reconstruis le token complet.
- Accède à : https://localhost:8080/profile_jwt.php?token=TON_TOKEN_MODIFIE
  - Résultat : Accès accordé même avec un token forgé (faille)

### Pages sécurisées : `login_jwt_secure.php` / `profile_jwt_secure.php`
- Accès : https://localhost:8080/login_jwt_secure.php
- Connecte-toi, récupère le JWT signé (exemple) :
  - `eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiYWRtaW4iLCJyb2xlIjoiYWRtaW4ifQ.hV7M6z8KXbrLxLXHwL4-iHwGCTGsq3xoIoNeqcZK5_I`
- Toute modification du token ou usage d’un token non signé :
  - Accès à : https://localhost:8080/profile_jwt_secure.php?token=TON_TOKEN_MODIFIE
  - Résultat : Accès refusé (remédiation)
- **Remarque** : Les tokens générés sont maintenant compatibles jwt.io et tous les outils JWT (format base64url).

---

## Résumé
- Chaque faille est testable sur la page vulnérable, puis la correction est visible sur la page sécurisée.
- Utilise les exemples de payloads pour démontrer l’exploitation. 