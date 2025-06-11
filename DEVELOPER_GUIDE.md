# Documentation Technique - AquaLara

## Table des matières

1. [Architecture](#architecture)
2. [Structure du projet](#structure-du-projet)
3. [Base de données](#base-de-données)
4. [API](#api)
5. [Tests](#tests)
6. [Déploiement](#déploiement)
7. [Bonnes pratiques](#bonnes-pratiques)

## Architecture

### Vue d'ensemble

AquaLara suit une architecture MVC (Modèle-Vue-Contrôleur) avec une séparation claire des responsabilités :

```
├── App
│   ├── Http
│   │   ├── Controllers    # Logique de contrôle
│   │   ├── Middleware     # Middleware d'application
│   │   └── Requests      # Validation des requêtes
│   ├── Models            # Modèles Eloquent
│   ├── Services          # Logique métier
│   ├── Repositories      # Couche d'accès aux données
│   └── Events           # Événements et listeners
```

### Design Patterns utilisés

- Repository Pattern
- Service Layer Pattern
- Observer Pattern (Events/Listeners)
- Factory Pattern
- Strategy Pattern

## Structure du projet

### Composants principaux

#### Controllers
```php
namespace App\Http\Controllers;

class ClientController extends Controller
{
    public function index()
    public function store(ClientRequest $request)
    public function update(ClientRequest $request, Client $client)
    public function destroy(Client $client)
}

class ReleveController extends Controller
{
    public function store(ReleveRequest $request)
    public function generateDecompte(Request $request)
    public function exportPDF(Releve $releve)
}
```

#### Models
```php
namespace App\Models;

class Client extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
    ];

    // Relations
    public function appartements()
    public function releves()
    public function decomptes()
}

class Appartement extends Model
{
    protected $fillable = [
        'numero',
        'etage',
        'surface',
        'client_id',
    ];

    // Relations
    public function client()
    public function releves()
    public function provisions()
}

class Releve extends Model
{
    protected $fillable = [
        'type', // eau_chaude, eau_froide, chauffage
        'valeur',
        'date_releve',
        'appartement_id',
    ];

    // Relations
    public function appartement()
    public function decompte()
}
```

## Base de données

### Schéma

```sql
-- Tables principales
CREATE TABLE clients (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    telephone VARCHAR(20),
    adresse TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE appartements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(10) NOT NULL,
    etage VARCHAR(10),
    surface DECIMAL(8,2),
    client_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE releves (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type ENUM('eau_chaude', 'eau_froide', 'chauffage'),
    valeur DECIMAL(10,2) NOT NULL,
    date_releve DATE NOT NULL,
    appartement_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (appartement_id) REFERENCES appartements(id)
);

CREATE TABLE decomptes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    montant_total DECIMAL(10,2),
    statut ENUM('brouillon', 'valide', 'cloture'),
    appartement_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (appartement_id) REFERENCES appartements(id)
);
```

## API

### Points d'entrée REST

#### Clients
- GET /api/clients
- POST /api/clients
- GET /api/clients/{id}
- PUT /api/clients/{id}
- DELETE /api/clients/{id}

#### Relevés
- GET /api/releves
- POST /api/releves
- GET /api/appartements/{id}/releves
- POST /api/releves/decompte
- GET /api/releves/{id}/pdf

### Validation

```php
namespace App\Http\Requests;

class ReleveRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type' => 'required|in:eau_chaude,eau_froide,chauffage',
            'valeur' => 'required|numeric|min:0',
            'date_releve' => 'required|date',
            'appartement_id' => 'required|exists:appartements,id',
        ];
    }
}
```

## Tests

### Tests unitaires

```php
namespace Tests\Unit;

class ReleveTest extends TestCase
{
    public function test_can_create_releve()
    public function test_can_generate_decompte()
    public function test_can_export_pdf()
}
```

### Tests d'intégration

```php
namespace Tests\Feature;

class ReleveControllerTest extends TestCase
{
    public function test_store_creates_new_releve()
    public function test_generate_decompte_works()
    public function test_export_pdf_works()
}
```

## Déploiement

### Configuration de l'environnement

Variables d'environnement critiques :
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

QUEUE_CONNECTION=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

### Optimisation des performances

1. Cache de configuration :
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. Optimisation Composer :
```bash
composer install --no-dev --optimize-autoloader
```

3. Configuration du serveur web (Nginx) :
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## Bonnes pratiques

### Standards de code

- PSR-12 pour le style de code
- Typage strict PHP 8.1+
- DocBlocks pour la documentation

### Sécurité

1. Validation des entrées
2. Protection CSRF
3. Authentification et autorisation
4. Sanitization des sorties
5. Protection contre les injections SQL

### Performance

1. Eager Loading des relations
2. Indexation de la base de données
3. Cache des requêtes fréquentes
4. Queue pour les tâches lourdes

### Maintenance

1. Logging structuré
2. Monitoring des erreurs
3. Backups automatisés
4. Documentation à jour 