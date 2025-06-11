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

class BassinController extends Controller
{
    public function index()
    public function store(BassinRequest $request)
    public function update(BassinRequest $request, Bassin $bassin)
    public function destroy(Bassin $bassin)
}
```

#### Models
```php
namespace App\Models;

class Bassin extends Model
{
    protected $fillable = [
        'nom',
        'volume',
        'type_poisson',
        'type_plante',
    ];

    // Relations
    public function parametres()
    public function alertes()
    public function taches()
}
```

#### Services
```php
namespace App\Services;

class BassinService
{
    public function createBassin(array $data)
    public function updateParametres(Bassin $bassin, array $parametres)
    public function generateRapport(Bassin $bassin, $dateDebut, $dateFin)
}
```

## Base de données

### Schéma

```sql
-- Principaux tables et relations
CREATE TABLE bassins (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    volume DECIMAL(10,2) NOT NULL,
    type_poisson VARCHAR(255),
    type_plante VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE parametres (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bassin_id BIGINT UNSIGNED,
    type VARCHAR(50) NOT NULL,
    valeur DECIMAL(10,2) NOT NULL,
    date_mesure TIMESTAMP,
    FOREIGN KEY (bassin_id) REFERENCES bassins(id)
);
```

### Migrations

Les migrations sont dans `database/migrations/`:
```php
public function up()
{
    Schema::create('bassins', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->decimal('volume', 10, 2);
        $table->string('type_poisson')->nullable();
        $table->string('type_plante')->nullable();
        $table->timestamps();
    });
}
```

## API

### Points d'entrée REST

#### Bassins
- GET /api/bassins
- POST /api/bassins
- GET /api/bassins/{id}
- PUT /api/bassins/{id}
- DELETE /api/bassins/{id}

#### Paramètres
- GET /api/bassins/{id}/parametres
- POST /api/parametres
- GET /api/parametres/{id}

### Authentification

Utilisation de Laravel Sanctum pour l'authentification API :

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('bassins', BassinController::class);
    Route::apiResource('parametres', ParametreController::class);
});
```

### Validation

```php
namespace App\Http\Requests;

class BassinRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'type_poisson' => 'nullable|string|max:255',
            'type_plante' => 'nullable|string|max:255',
        ];
    }
}
```

## Tests

### Tests unitaires

```php
namespace Tests\Unit;

class BassinTest extends TestCase
{
    public function test_can_create_bassin()
    public function test_can_update_bassin()
    public function test_can_delete_bassin()
}
```

### Tests d'intégration

```php
namespace Tests\Feature;

class BassinControllerTest extends TestCase
{
    public function test_index_returns_bassins_list()
    public function test_store_creates_new_bassin()
    public function test_update_modifies_bassin()
}
```

### Tests de bout en bout (E2E)

Utilisation de Laravel Dusk pour les tests E2E :

```php
namespace Tests\Browser;

class BassinTest extends DuskTestCase
{
    public function test_user_can_create_bassin()
    public function test_user_can_view_bassin_details()
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