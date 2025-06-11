# Guide de Déploiement

## Table des matières
1. [Prérequis](#prérequis)
2. [Environnements](#environnements)
3. [Processus de Déploiement](#processus-de-déploiement)
4. [Configuration du Serveur](#configuration-du-serveur)
5. [Sécurité](#sécurité)
6. [Maintenance](#maintenance)
7. [Rollback](#rollback)

## Prérequis

### Serveur
- PHP 8.1 ou supérieur
- MySQL 8.0 ou supérieur
- Redis 6.0 ou supérieur
- Nginx 1.18 ou supérieur
- SSL/TLS (Let's Encrypt recommandé)

### Outils
- Composer
- Node.js 16 ou supérieur
- Git
- Supervisor (pour les workers)

## Environnements

### Staging
- URL : staging.aqualara.com
- Base de données : aqualara_staging
- Cache : activé
- Debug : désactivé

### Production
- URL : app.aqualara.com
- Base de données : aqualara_prod
- Cache : activé
- Debug : désactivé

## Processus de Déploiement

### 1. Préparation

```bash
# Cloner le repository
git clone https://github.com/votre-organisation/aqualara-app.git
cd aqualara-app

# Installer les dépendances
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Copier les fichiers de configuration
cp .env.example .env
```

### 2. Configuration

```bash
# Générer la clé d'application
php artisan key:generate

# Configurer l'environnement
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Base de Données

```bash
# Exécuter les migrations
php artisan migrate --force

# Seeder les données si nécessaire
php artisan db:seed --force
```

### 4. Permissions

```bash
# Configurer les permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Configuration du Serveur

### Nginx

```nginx
server {
    listen 443 ssl http2;
    server_name app.aqualara.com;
    root /var/www/aqualara/public;

    ssl_certificate /etc/letsencrypt/live/app.aqualara.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/app.aqualara.com/privkey.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Supervisor

```ini
[program:aqualara-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/aqualara/artisan queue:work
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/aqualara/storage/logs/worker.log
```

## Sécurité

### SSL/TLS
- Renouvellement automatique des certificats
- Configuration HSTS
- Cipher suites sécurisées

### Firewall
- UFW activé
- Ports ouverts : 80, 443
- Protection contre les attaques DDoS

### Monitoring
- Logwatch pour les logs système
- Prometheus pour les métriques
- Alertmanager pour les notifications

## Maintenance

### Tâches Quotidiennes
```bash
# Nettoyage des logs
php artisan log:clear

# Optimisation de la base de données
php artisan optimize

# Vérification des mises à jour
composer update --dry-run
```

### Tâches Hebdomadaires
```bash
# Sauvegarde de la base de données
php artisan backup:run

# Nettoyage du cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Rollback

### 1. Annuler la Migration
```bash
php artisan migrate:rollback
```

### 2. Restaurer la Base de Données
```bash
php artisan backup:restore
```

### 3. Revenir à la Version Précédente
```bash
git checkout <previous-tag>
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Vérifier l'Intégrité
```bash
php artisan health:check
php artisan test
``` 