# AquaLara - Système de Gestion pour Aquaponie

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

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

## Sécurité

Si vous découvrez une faille de sécurité dans l'application, veuillez envoyer un e-mail à [votre-email@domaine.com].
