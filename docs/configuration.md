# Documentation des Configurations

## Table des matières
1. [Configuration de l'Environnement](#configuration-de-lenvironnement)
2. [Configuration de la Base de Données](#configuration-de-la-base-de-données)
3. [Configuration du Cache](#configuration-du-cache)
4. [Configuration des Services](#configuration-des-services)
5. [Configuration de la Sécurité](#configuration-de-la-sécurité)
6. [Configuration des Notifications](#configuration-des-notifications)

## Configuration de l'Environnement

### Variables d'Environnement

Le fichier `.env` contient les configurations essentielles :

```env
APP_NAME=AquaLara
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### Environnements

- **Local** : Développement local
- **Staging** : Environnement de test
- **Production** : Environnement de production

## Configuration de la Base de Données

### MySQL

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aqualara
DB_USERNAME=root
DB_PASSWORD=
```

### Redis (Cache)

```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Configuration du Cache

### Cache Redis

```php
// config/cache.php
'redis' => [
    'driver' => 'redis',
    'connection' => 'cache',
    'lock_connection' => 'default',
],
```

### Cache des Requêtes

```php
// config/database.php
'query_cache' => [
    'enabled' => true,
    'ttl' => 3600,
],
```

## Configuration des Services

### Service de Facturation

```php
// config/billing.php
'default_currency' => 'EUR',
'tax_rate' => 20.0,
'payment_terms' => 30,
```

### Service de Notifications

```php
// config/notifications.php
'channels' => [
    'mail' => [
        'driver' => 'smtp',
        'host' => env('MAIL_HOST'),
        'port' => env('MAIL_PORT'),
    ],
    'sms' => [
        'driver' => 'twilio',
        'account_sid' => env('TWILIO_SID'),
        'auth_token' => env('TWILIO_TOKEN'),
    ],
],
```

## Configuration de la Sécurité

### Authentification

```php
// config/auth.php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'sanctum',
        'provider' => 'users',
    ],
],
```

### Autorisations

```php
// config/permissions.php
'roles' => [
    'admin' => [
        'permissions' => ['*'],
    ],
    'manager' => [
        'permissions' => [
            'view_reports',
            'manage_users',
            'manage_clients',
        ],
    ],
],
```

## Configuration des Notifications

### Email

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@aqualara.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### SMS

```env
TWILIO_SID=your_sid
TWILIO_TOKEN=your_token
TWILIO_FROM=your_number
```

## Bonnes Pratiques

### Sécurité

- Ne jamais commiter le fichier `.env`
- Utiliser des variables d'environnement pour les secrets
- Changer les clés de production régulièrement
- Limiter les accès aux configurations sensibles

### Performance

- Activer le cache en production
- Optimiser les configurations Redis
- Configurer les timeouts appropriés
- Mettre en place le monitoring

### Maintenance

- Documenter les changements de configuration
- Tester les configurations en staging
- Sauvegarder les configurations de production
- Maintenir un historique des versions 