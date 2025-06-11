# AquaLara - Système de Gestion Immobilière

Application web de gestion immobilière développée avec Laravel, spécialisée dans :
- Gestion des relevés de consommation (eau, gaz, électricité)
- Calcul et génération des décomptes de charges
- Suivi des provisions
- Gestion des clients et appartements
- Planification des interventions techniques

## Fonctionnalités principales

- **Gestion des relevés**
  - Saisie des relevés d'eau (chaude/froide)
  - Relevés de chauffage
  - Suivi des consommations
  - Calcul automatique des coûts

- **Décomptes et provisions**
  - Génération automatique des décomptes
  - Calcul des provisions
  - Export PDF des décomptes
  - Historique des paiements

- **Gestion locative**
  - Suivi des clients
  - Gestion des appartements
  - Historique des interventions
  - Planification des maintenances

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre système :

- PHP 8.1 ou supérieur
- Composer
- Node.js (16.x ou supérieur) et npm
- MySQL 8.0 ou supérieur
- Git

## Installation

1. Clonez le dépôt :
```bash
git clone https://github.com/votre-username/TFE2025_aqualara_v2.git
cd TFE2025_aqualara_v2
```

2. Installez les dépendances PHP :
```bash
composer install
```

3. Installez les dépendances JavaScript :
```bash
npm install
```

4. Créez le fichier d'environnement :
```bash
cp .env.example .env
```

5. Générez la clé d'application :
```bash
php artisan key:generate
```

6. Configurez votre fichier .env avec vos informations de base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aqualara
DB_USERNAME=votre_username
DB_PASSWORD=votre_password
```

7. Exécutez les migrations et les seeders :
```bash
php artisan migrate --seed
```

8. Compilez les assets :
```bash
npm run dev
```

## Configuration

### Configuration du système de fichiers

```bash
php artisan storage:link
```

### Configuration des permissions (Linux/Unix) :
```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

## Démarrage du projet en local

1. Lancez le serveur Laravel :
```bash
php artisan serve
```

2. Dans un autre terminal, compilez les assets en temps réel :
```bash
npm run dev
```

Le projet sera accessible à l'adresse : http://localhost:8000

## Déploiement en production

### Prérequis serveur

- Serveur web (Apache/Nginx)
- PHP 8.1+
- MySQL 8.0+
- Composer
- Node.js et npm
- SSL/TLS pour HTTPS

### Étapes de déploiement

1. Configurez votre serveur web :
   - Pour Apache, assurez-vous que mod_rewrite est activé
   - Pour Nginx, configurez le bloc server approprié

2. Sur le serveur, clonez le projet et installez les dépendances :
```bash
git clone https://github.com/votre-username/TFE2025_aqualara_v2.git
cd TFE2025_aqualara_v2
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

3. Configurez l'environnement de production :
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurez le fichier .env pour la production :
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aqualara_prod
DB_USERNAME=prod_username
DB_PASSWORD=prod_password
```

5. Optimisez l'application :
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

6. Configurez les tâches planifiées dans crontab :
```bash
* * * * * cd /chemin/vers/votre/projet && php artisan schedule:run >> /dev/null 2>&1
```

### Maintenance et mises à jour

Pour mettre à jour l'application en production :

```bash
php artisan down
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan up
```

## Tests

Pour exécuter les tests :

```bash
php artisan test
```

## Documentation

- Guide utilisateur : voir `USER_GUIDE.md`
- Documentation technique : voir `DEVELOPER_GUIDE.md`
- Documentation API : voir `docs/api.md`

## Sécurité

Si vous découvrez une faille de sécurité dans l'application, veuillez envoyer un e-mail à [votre-email@domaine.com].
