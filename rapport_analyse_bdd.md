# Rapport d'Analyse de la Base de Données AquaLara-App

## 1. Vue d'ensemble de la Structure

### 1.1 Modèles Principaux
- **Client** : Gestion des clients et leurs informations
- **Appartement** : Gestion des appartements liés aux clients
- **Technicien** : Gestion des techniciens et leurs compétences
- **Event** : Gestion des événements et rendez-vous
- **Appareil** : Gestion des appareils de mesure
- **Releve** : Gestion des relevés de consommation

### 1.2 Catégories de Données
1. **Gestion des Clients**
   - Informations personnelles
   - Coordonnées
   - Relations avec les biens immobiliers

2. **Gestion des Biens**
   - Appartements
   - Propriétaires
   - Gérants

3. **Gestion des Services**
   - Eau
   - Électricité
   - Gaz
   - Chauffage

4. **Gestion des Techniciens**
   - Compétences
   - Régions d'intervention
   - Planning

## 2. Problèmes Identifiés

### 2.1 Incohérences de Nommage
- Mélange de casse (camelCase vs PascalCase)
- Incohérence dans les noms de colonnes (ex: `Codecli` vs `codeCli`)
- Noms de tables non standardisés

### 2.2 Redondance des Données
- Tables multiples pour les relevés (`relEauCs`, `relEauFs`, etc.)
- Duplication des informations de contact
- Répétition des structures de données similaires

### 2.3 Structure Complexe
- Nombre élevé de relations directes
- Tables de liaison multiples
- Manque de normalisation

## 3. Recommandations d'Optimisation

### 3.1 Restructuration des Tables de Relevés
```php
Schema::create('readings', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // 'water', 'electricity', 'gas', 'heating'
    $table->foreignId('client_id');
    $table->foreignId('appartment_id')->nullable();
    $table->decimal('value', 10, 2);
    $table->date('reading_date');
    $table->string('status');
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

### 3.2 Table de Contacts Unifiée
```php
Schema::create('contacts', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // 'client', 'manager', 'owner'
    $table->string('name');
    $table->string('email')->nullable();
    $table->string('phone')->nullable();
    $table->string('address')->nullable();
    $table->string('city')->nullable();
    $table->string('postal_code')->nullable();
    $table->foreignId('client_id');
    $table->timestamps();
});
```

### 3.3 Table de Services
```php
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // 'water', 'electricity', 'gas', 'heating'
    $table->foreignId('client_id');
    $table->foreignId('appartment_id')->nullable();
    $table->boolean('active')->default(true);
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->string('contract_number')->nullable();
    $table->timestamps();
});
```

### 3.4 Table d'Appareils Optimisée
```php
Schema::create('devices', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // 'meter', 'controller', etc.
    $table->string('model');
    $table->string('serial_number')->unique();
    $table->foreignId('client_id');
    $table->foreignId('appartment_id')->nullable();
    $table->boolean('active')->default(true);
    $table->date('installation_date');
    $table->date('last_maintenance_date')->nullable();
    $table->timestamps();
});
```

## 4. Améliorations des Relations

### 4.1 Relations Client
```php
class Client extends Model
{
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function appartments()
    {
        return $this->hasMany(Appartment::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}
```

### 4.2 Relations Appartement
```php
class Appartment extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}
```

## 5. Plan de Migration

### 5.1 Étapes de Migration
1. Création des nouvelles tables
2. Migration des données existantes
3. Mise à jour des modèles
4. Adaptation des contrôleurs
5. Tests et validation

### 5.2 Script de Migration
```php
// Exemple de migration des données
public function migrateReadings()
{
    // Migration des relevés d'eau
    DB::table('rel_eau_cs')->each(function ($reading) {
        DB::table('readings')->insert([
            'type' => 'water',
            'client_id' => $reading->Codecli,
            'value' => $reading->valeur,
            'reading_date' => $reading->date,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    });
}
```

## 6. Recommandations de Performance

### 6.1 Indexation
```php
// Ajout d'index pour les requêtes fréquentes
Schema::table('readings', function (Blueprint $table) {
    $table->index(['client_id', 'reading_date']);
    $table->index(['appartment_id', 'reading_date']);
    $table->index('type');
});
```

### 6.2 Optimisation des Requêtes
- Utilisation de eager loading
- Mise en cache des données fréquemment accédées
- Pagination des résultats

## 7. Sécurité et Maintenance

### 7.1 Bonnes Pratiques
- Validation des données
- Gestion des transactions
- Logging des modifications

### 7.2 Maintenance
- Sauvegarde régulière
- Nettoyage des données obsolètes
- Monitoring des performances

## 8. Conclusion

Cette restructuration permettra :
- Une meilleure organisation des données
- Une maintenance plus facile
- Des performances améliorées
- Une meilleure scalabilité

## 9. Prochaines Étapes

1. Validation du plan de migration
2. Création des scripts de migration
3. Tests en environnement de développement
4. Déploiement progressif
5. Formation des équipes

## 10. Analyse Détaillée des Tables

### 10.1 Gestion des Événements
#### Table `events`
- **Relations** :
  - `belongsTo` avec `Client`
  - `belongsToMany` avec `Technicien` (via `event_technicien`)
  - `hasMany` avec `Appartement`
  - `hasMany` avec `EventAppartement`
  - `belongsTo` avec `TypeEvent`
  - `hasMany` avec `Document`

- **Problèmes identifiés** :
  - Relation `hasMany` avec `Appartement` devrait être `belongsTo`
  - Manque d'index sur les colonnes fréquemment utilisées dans les requêtes
  - Mélange de types de données pour les dates

- **Recommandations** :
```php
Schema::table('events', function (Blueprint $table) {
    $table->index(['client_id', 'start']);
    $table->index(['type_event_id', 'start']);
    $table->date('start')->change();
    $table->date('end')->change();
});
```

### 10.2 Gestion des Appareils
#### Table `appareils`
- **Relations** :
  - `belongsTo` avec `Materiel`
  - `hasMany` avec `AppareilsErreur`
  - `belongsTo` avec `Client`
  - `hasMany` avec `NotesAppartement`
  - `hasMany` avec `FileStorage`

- **Problèmes identifiés** :
  - Incohérence dans les noms de colonnes (`codeCli` vs `Codecli`)
  - Manque de validation des données
  - Absence de soft deletes

- **Recommandations** :
```php
Schema::table('appareils', function (Blueprint $table) {
    $table->softDeletes();
    $table->string('codeCli')->change();
    $table->string('RefAppTR')->change();
    $table->index(['codeCli', 'RefAppTR']);
});
```

### 10.3 Gestion des Relevés
#### Tables concernées :
- `rel_eau_cs`
- `rel_eau_fs`
- `rel_gaz`
- `rel_elec`
- `rel_chauf`

- **Problèmes identifiés** :
  - Duplication de structure
  - Manque de normalisation
  - Absence de contraintes d'intégrité

- **Recommandations** :
```php
Schema::create('readings', function (Blueprint $table) {
    $table->id();
    $table->enum('type', ['water_cold', 'water_hot', 'gas', 'electricity', 'heating']);
    $table->foreignId('client_id');
    $table->foreignId('appartment_id')->nullable();
    $table->decimal('value', 10, 2);
    $table->date('reading_date');
    $table->string('status');
    $table->text('notes')->nullable();
    $table->timestamps();
    
    $table->index(['client_id', 'reading_date']);
    $table->index(['appartment_id', 'reading_date']);
    $table->index('type');
});
```

### 10.4 Gestion des Techniciens
#### Table `techniciens`
- **Relations** :
  - `belongsToMany` avec `Region` (via `technicien_region`)
  - `belongsToMany` avec `Competence` (via `technicien_competence`)
  - `belongsToMany` avec `Event` (via `event_technicien`)
  - `belongsTo` avec `statusTechnicien`
  - `belongsTo` avec `ColorTechnicien`
  - `belongsTo` avec `User`

- **Problèmes identifiés** :
  - Manque de validation des données
  - Absence de gestion des disponibilités
  - Structure complexe des relations

- **Recommandations** :
```php
Schema::table('techniciens', function (Blueprint $table) {
    $table->softDeletes();
    $table->string('phone')->nullable()->change();
    $table->string('email')->unique()->nullable();
    $table->json('availability')->nullable();
    $table->index(['status_id', 'active']);
});
```

### 10.5 Gestion des Documents
#### Table `documents`
- **Relations** :
  - `belongsTo` avec `Event`
  - `belongsTo` avec `Client`

- **Problèmes identifiés** :
  - Manque de gestion des versions
  - Absence de catégorisation
  - Pas de gestion des permissions

- **Recommandations** :
```php
Schema::table('documents', function (Blueprint $table) {
    $table->string('category')->after('id');
    $table->string('version')->nullable();
    $table->json('permissions')->nullable();
    $table->index('category');
});
```

### 10.6 Gestion des Notes
#### Table `notes_appartements`
- **Relations** :
  - `belongsTo` avec `Appartement`
  - `belongsTo` avec `Appareil`

- **Problèmes identifiés** :
  - Manque de typage des notes
  - Absence de système de priorité
  - Pas de gestion des statuts

- **Recommandations** :
```php
Schema::table('notes_appartements', function (Blueprint $table) {
    $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
    $table->enum('status', ['active', 'resolved', 'archived'])->default('active');
    $table->timestamp('resolved_at')->nullable();
    $table->index(['appartement_id', 'status']);
});
```

### 10.7 Gestion des Erreurs
#### Table `appareils_erreurs`
- **Relations** :
  - `belongsTo` avec `Appareil`
  - `belongsTo` avec `typeErreur`

- **Problèmes identifiés** :
  - Manque de suivi des résolutions
  - Absence de priorisation
  - Pas de gestion des notifications

- **Recommandations** :
```php
Schema::table('appareils_erreurs', function (Blueprint $table) {
    $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
    $table->enum('status', ['open', 'in_progress', 'resolved'])->default('open');
    $table->timestamp('resolved_at')->nullable();
    $table->text('resolution_notes')->nullable();
    $table->index(['appareil_id', 'status']);
});
```

### 10.8 Gestion des Déclarations
#### Tables concernées :
- `dec_entetes`
- `dec_lst_rels`
- `dec_eau_sol`
- `dec_eau_sol_app`

- **Relations** :
  - `dec_entetes` : Table principale des déclarations
  - `dec_lst_rels` : Liste des relevés associés
  - `dec_eau_sol` : Déclarations d'eau solaire
  - `dec_eau_sol_app` : Déclarations d'eau solaire par appartement

- **Problèmes identifiés** :
  - Structure complexe et fragmentée
  - Manque de normalisation
  - Redondance des données

- **Recommandations** :
```php
Schema::create('declarations', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // 'water', 'solar', etc.
    $table->foreignId('client_id');
    $table->date('declaration_date');
    $table->string('status');
    $table->text('notes')->nullable();
    $table->timestamps();
    
    $table->index(['client_id', 'declaration_date']);
    $table->index('type');
});

Schema::create('declaration_readings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('declaration_id');
    $table->foreignId('reading_id');
    $table->timestamps();
    
    $table->unique(['declaration_id', 'reading_id']);
});
```

### 10.9 Gestion des Clients et Services
#### Tables concernées :
- `cli_eau`
- `cli_elec`
- `cli_gaz`
- `cli_chauf`
- `cli_provision`

- **Relations** :
  - Chaque table gère un type de service spécifique
  - Liens avec les clients et les appartements
  - Gestion des provisions

- **Problèmes identifiés** :
  - Duplication de structure
  - Manque de cohérence dans les noms
  - Absence de normalisation

- **Recommandations** :
```php
Schema::create('client_services', function (Blueprint $table) {
    $table->id();
    $table->enum('type', ['water', 'electricity', 'gas', 'heating']);
    $table->foreignId('client_id');
    $table->foreignId('appartment_id')->nullable();
    $table->string('contract_number')->nullable();
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->boolean('active')->default(true);
    $table->timestamps();
    
    $table->index(['client_id', 'type']);
    $table->index(['appartment_id', 'type']);
});

Schema::create('provisions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('client_service_id');
    $table->decimal('amount', 10, 2);
    $table->date('due_date');
    $table->string('status');
    $table->timestamps();
    
    $table->index(['client_service_id', 'due_date']);
});
```

### 10.10 Gestion des Relevés Radio
#### Tables concernées :
- `rel_radio`
- `rel_rad_eau`
- `rel_rad_chf`

- **Relations** :
  - Gestion des relevés à distance
  - Liens avec les appareils
  - Suivi des valeurs

- **Problèmes identifiés** :
  - Structure similaire aux relevés standards
  - Manque d'unification
  - Absence de validation spécifique

- **Recommandations** :
```php
Schema::table('readings', function (Blueprint $table) {
    $table->boolean('is_remote')->default(false);
    $table->string('reading_method')->nullable(); // 'manual', 'radio', 'smart_meter'
    $table->json('remote_data')->nullable();
    $table->index(['is_remote', 'reading_date']);
});
```

### 10.11 Gestion des Gérants et Propriétaires
#### Tables concernées :
- `gerant_imms`
- `app_proprios`
- `contacts`

- **Relations** :
  - Gestion des contacts
  - Liens avec les biens immobiliers
  - Rôles multiples

- **Problèmes identifiés** :
  - Duplication des informations de contact
  - Structure complexe des rôles
  - Manque de normalisation

- **Recommandations** :
```php
Schema::create('property_contacts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('contact_id');
    $table->foreignId('appartment_id');
    $table->enum('role', ['owner', 'manager', 'tenant']);
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->timestamps();
    
    $table->unique(['contact_id', 'appartment_id', 'role']);
    $table->index(['appartment_id', 'role']);
});
```

### 10.12 Gestion des Fichiers et Documents
#### Tables concernées :
- `file_storages`
- `file_xmls`
- `comment_xmls`

- **Relations** :
  - Stockage des fichiers
  - Gestion des documents XML
  - Commentaires associés

- **Problèmes identifiés** :
  - Manque de catégorisation
  - Absence de gestion des versions
  - Structure complexe des commentaires

- **Recommandations** :
```php
Schema::create('files', function (Blueprint $table) {
    $table->id();
    $table->string('category'); // 'document', 'xml', 'image', etc.
    $table->string('original_name');
    $table->string('mime_type');
    $table->string('path');
    $table->integer('size');
    $table->json('metadata')->nullable();
    $table->timestamps();
    
    $table->index('category');
});

Schema::create('file_comments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('file_id');
    $table->text('content');
    $table->string('type')->nullable();
    $table->timestamps();
    
    $table->index(['file_id', 'type']);
});
```

### 10.13 Gestion des Avis de Passage
#### Table `avis_passage_texts`
- **Relations** :
  - `belongsTo` avec `Event`
  - `belongsTo` avec `TypeEvent`

- **Problèmes identifiés** :
  - Manque de standardisation des textes
  - Absence de gestion des versions
  - Pas de catégorisation

- **Recommandations** :
```php
Schema::table('avis_passage_texts', function (Blueprint $table) {
    $table->string('category')->after('id');
    $table->string('version')->nullable();
    $table->boolean('is_template')->default(false);
    $table->json('variables')->nullable();
    $table->index(['category', 'is_template']);
});
```

### 10.14 Gestion des Matériels
#### Table `materiels`
- **Relations** :
  - `hasMany` avec `Appareil`
  - `belongsToMany` avec `Appartement`

- **Problèmes identifiés** :
  - Manque de catégorisation
  - Absence de gestion des stocks
  - Pas de suivi des performances

- **Recommandations** :
```php
Schema::table('materiels', function (Blueprint $table) {
    $table->string('category')->after('id');
    $table->string('manufacturer')->nullable();
    $table->integer('stock_quantity')->default(0);
    $table->decimal('average_lifetime', 5, 2)->nullable();
    $table->json('specifications')->nullable();
    $table->index(['category', 'manufacturer']);
});
```

### 10.15 Gestion des Utilisateurs et Authentification
#### Tables concernées :
- `users`
- `roles`

- **Relations** :
  - `users` : Gestion des utilisateurs du système
  - `roles` : Gestion des rôles et permissions

- **Problèmes identifiés** :
  - Manque de gestion des permissions détaillées
  - Absence de journalisation des actions
  - Pas de gestion des sessions

- **Recommandations** :
```php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('is_active')->default(true);
    $table->timestamp('last_login_at')->nullable();
    $table->string('last_login_ip')->nullable();
    $table->json('preferences')->nullable();
    $table->softDeletes();
    $table->index('is_active');
});

Schema::create('user_activities', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id');
    $table->string('action');
    $table->string('ip_address')->nullable();
    $table->json('details')->nullable();
    $table->timestamps();
    
    $table->index(['user_id', 'created_at']);
});
```

### 10.16 Gestion des Régions et Compétences
#### Tables concernées :
- `regions`
- `competences`
- `technicien_region`
- `technicien_competence`

- **Relations** :
  - Gestion des zones géographiques
  - Gestion des compétences techniques
  - Association techniciens-régions
  - Association techniciens-compétences

- **Problèmes identifiés** :
  - Manque de hiérarchie des régions
  - Absence de catégorisation des compétences
  - Pas de gestion des priorités

- **Recommandations** :
```php
Schema::table('regions', function (Blueprint $table) {
    $table->foreignId('parent_id')->nullable();
    $table->string('code')->unique();
    $table->integer('level')->default(0);
    $table->json('boundaries')->nullable();
    $table->index(['parent_id', 'level']);
});

Schema::table('competences', function (Blueprint $table) {
    $table->string('category')->after('id');
    $table->integer('level')->default(1);
    $table->text('description')->nullable();
    $table->json('requirements')->nullable();
    $table->index(['category', 'level']);
});

Schema::table('technicien_region', function (Blueprint $table) {
    $table->enum('priority', ['primary', 'secondary', 'backup'])->default('primary');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->index(['technicien_id', 'priority']);
});
```

### 10.17 Gestion des Absences
#### Table `absents`
- **Relations** :
  - `belongsTo` avec `Technicien`
  - `belongsTo` avec `Appartement`

- **Problèmes identifiés** :
  - Manque de typage des absences
  - Absence de gestion des remplacements
  - Pas de suivi des notifications

- **Recommandations** :
```php
Schema::table('absents', function (Blueprint $table) {
    $table->enum('type', ['vacation', 'sick', 'training', 'other'])->after('id');
    $table->text('reason')->nullable();
    $table->foreignId('replacement_technicien_id')->nullable();
    $table->boolean('notified')->default(false);
    $table->timestamp('notification_sent_at')->nullable();
    $table->index(['technicien_id', 'start_date']);
    $table->index('type');
});
```

### 10.18 Gestion des Codes Postaux
#### Table `code_postelb`
- **Relations** :
  - Liens avec les adresses des clients et contacts

- **Problèmes identifiés** :
  - Manque de validation des codes
  - Absence de géolocalisation
  - Pas de gestion des changements

- **Recommandations** :
```php
Schema::table('code_postelb', function (Blueprint $table) {
    $table->string('city')->after('code');
    $table->string('department')->after('city');
    $table->decimal('latitude', 10, 8)->nullable();
    $table->decimal('longitude', 11, 8)->nullable();
    $table->date('valid_from');
    $table->date('valid_until')->nullable();
    $table->index(['code', 'city']);
    $table->index(['department', 'city']);
});
```

### 10.19 Gestion des Contenus Mail
#### Table `mail_contents`
- **Relations** :
  - `belongsTo` avec `TypeEvent`

- **Problèmes identifiés** :
  - Manque de gestion des versions
  - Absence de variables dynamiques
  - Pas de gestion des templates

- **Recommandations** :
```php
Schema::table('mail_contents', function (Blueprint $table) {
    $table->string('version')->after('id');
    $table->string('subject')->after('title');
    $table->json('variables')->nullable();
    $table->boolean('is_template')->default(false);
    $table->json('attachments')->nullable();
    $table->index(['type_event_id', 'version']);
    $table->index('is_template');
});
```

## 11. Proposition de Structure Optimisée pour Nouveau Projet

### 11.1 Architecture Globale
```php
// Structure des dossiers
app/
├── Models/
│   ├── Core/
│   │   ├── User.php
│   │   ├── Contact.php
│   │   └── Address.php
│   ├── Property/
│   │   ├── Client.php
│   │   ├── Property.php
│   │   └── PropertyContact.php
│   ├── Service/
│   │   ├── Service.php
│   │   ├── Reading.php
│   │   └── Declaration.php
│   ├── Technical/
│   │   ├── Technician.php
│   │   ├── Region.php
│   │   └── Competence.php
│   └── Planning/
│       ├── Event.php
│       ├── Absence.php
│       └── Schedule.php
├── Services/
│   ├── ReadingService.php
│   ├── DeclarationService.php
│   └── NotificationService.php
└── Repositories/
    ├── ClientRepository.php
    ├── PropertyRepository.php
    └── ReadingRepository.php
```

### 11.2 Modèles Principaux

#### 11.2.1 Gestion des Utilisateurs
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('phone')->nullable();
    $table->boolean('is_active')->default(true);
    $table->json('preferences')->nullable();
    $table->timestamp('last_login_at')->nullable();
    $table->string('last_login_ip')->nullable();
    $table->rememberToken();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('is_active');
});

Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('display_name');
    $table->text('description')->nullable();
    $table->json('permissions');
    $table->timestamps();
});
```

#### 11.2.2 Gestion des Contacts et Adresses
```php
Schema::create('contacts', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // 'client', 'manager', 'owner', 'technician'
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->nullable();
    $table->string('phone')->nullable();
    $table->string('mobile')->nullable();
    $table->json('preferences')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('type');
});

Schema::create('addresses', function (Blueprint $table) {
    $table->id();
    $table->morphs('addressable');
    $table->string('street');
    $table->string('city');
    $table->string('postal_code');
    $table->string('country')->default('FR');
    $table->decimal('latitude', 10, 8)->nullable();
    $table->decimal('longitude', 11, 8)->nullable();
    $table->boolean('is_primary')->default(false);
    $table->timestamps();
    
    $table->index(['addressable_type', 'addressable_id']);
    $table->index(['postal_code', 'city']);
});
```

#### 11.2.3 Gestion des Biens Immobiliers
```php
Schema::create('properties', function (Blueprint $table) {
    $table->id();
    $table->string('reference')->unique();
    $table->string('type'); // 'apartment', 'house', 'commercial'
    $table->string('status'); // 'active', 'inactive', 'maintenance'
    $table->integer('floor')->nullable();
    $table->string('door_number')->nullable();
    $table->json('features')->nullable();
    $table->json('documents')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index(['type', 'status']);
});

Schema::create('property_contacts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('property_id');
    $table->foreignId('contact_id');
    $table->enum('role', ['owner', 'manager', 'tenant']);
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->json('details')->nullable();
    $table->timestamps();
    
    $table->unique(['property_id', 'contact_id', 'role']);
    $table->index(['property_id', 'role']);
});
```

#### 11.2.4 Gestion des Services
```php
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->foreignId('property_id');
    $table->enum('type', ['water', 'electricity', 'gas', 'heating']);
    $table->string('contract_number')->nullable();
    $table->string('provider')->nullable();
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->boolean('is_active')->default(true);
    $table->json('settings')->nullable();
    $table->timestamps();
    
    $table->index(['property_id', 'type']);
    $table->index('is_active');
});

Schema::create('readings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('service_id');
    $table->decimal('value', 10, 2);
    $table->date('reading_date');
    $table->string('reading_method'); // 'manual', 'remote', 'smart_meter'
    $table->string('status'); // 'pending', 'validated', 'rejected'
    $table->text('notes')->nullable();
    $table->json('metadata')->nullable();
    $table->timestamps();
    
    $table->index(['service_id', 'reading_date']);
    $table->index('status');
});
```

#### 11.2.5 Gestion des Techniciens
```php
Schema::create('technicians', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id');
    $table->string('employee_number')->unique();
    $table->json('availability')->nullable();
    $table->json('skills')->nullable();
    $table->string('status'); // 'active', 'inactive', 'on_leave'
    $table->timestamps();
    
    $table->index('status');
});

Schema::create('regions', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code')->unique();
    $table->foreignId('parent_id')->nullable();
    $table->integer('level')->default(0);
    $table->json('boundaries')->nullable();
    $table->timestamps();
    
    $table->index(['parent_id', 'level']);
});

Schema::create('technician_regions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('technician_id');
    $table->foreignId('region_id');
    $table->enum('priority', ['primary', 'secondary', 'backup']);
    $table->timestamps();
    
    $table->unique(['technician_id', 'region_id']);
    $table->index(['technician_id', 'priority']);
});
```

#### 11.2.6 Gestion des Événements
```php
Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->dateTime('start');
    $table->dateTime('end');
    $table->string('status'); // 'scheduled', 'in_progress', 'completed', 'cancelled'
    $table->string('type'); // 'visit', 'maintenance', 'reading'
    $table->foreignId('property_id');
    $table->foreignId('service_id')->nullable();
    $table->boolean('is_billable')->default(false);
    $table->json('metadata')->nullable();
    $table->timestamps();
    
    $table->index(['property_id', 'start']);
    $table->index(['type', 'status']);
});

Schema::create('event_technicians', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id');
    $table->foreignId('technician_id');
    $table->string('role'); // 'primary', 'assistant'
    $table->timestamps();
    
    $table->unique(['event_id', 'technician_id']);
});
```

### 11.3 Services et Repositories

#### 11.3.1 Services
```php
class ReadingService
{
    public function createReading(array $data)
    {
        return DB::transaction(function () use ($data) {
            $reading = Reading::create($data);
            $this->validateReading($reading);
            $this->updateServiceStatistics($reading->service);
            return $reading;
        });
    }
}

class DeclarationService
{
    public function generateDeclaration(Service $service, array $readings)
    {
        return DB::transaction(function () use ($service, $readings) {
            $declaration = Declaration::create([
                'service_id' => $service->id,
                'period_start' => $readings->first()->reading_date,
                'period_end' => $readings->last()->reading_date,
                'status' => 'draft'
            ]);
            
            foreach ($readings as $reading) {
                $declaration->readings()->attach($reading->id);
            }
            
            return $declaration;
        });
    }
}
```

#### 11.3.2 Repositories
```php
class PropertyRepository
{
    public function getActivePropertiesWithServices()
    {
        return Property::with(['services' => function ($query) {
            $query->where('is_active', true);
        }])
        ->where('status', 'active')
        ->get();
    }
    
    public function getPropertiesByRegion(Region $region)
    {
        return Property::whereHas('address', function ($query) use ($region) {
            $query->where('postal_code', 'like', $region->code . '%');
        })->get();
    }
}
```

### 11.4 Migrations et Seeds

#### 11.4.1 Migrations
```php
// Exemple de migration avec rollback
public function up()
{
    Schema::create('services', function (Blueprint $table) {
        // ... structure de la table
    });
}

public function down()
{
    Schema::dropIfExists('services');
}
```

#### 11.4.2 Seeds
```php
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            RegionSeeder::class,
            ServiceTypeSeeder::class,
        ]);
    }
}
```

### 11.5 Tests

#### 11.5.1 Tests Unitaires
```php
class ReadingServiceTest extends TestCase
{
    public function test_create_reading()
    {
        $service = Service::factory()->create();
        $data = [
            'service_id' => $service->id,
            'value' => 100.50,
            'reading_date' => now(),
            'reading_method' => 'manual'
        ];
        
        $reading = app(ReadingService::class)->createReading($data);
        
        $this->assertDatabaseHas('readings', [
            'service_id' => $service->id,
            'value' => 100.50
        ]);
    }
}
```

#### 11.5.2 Tests d'Intégration
```php
class PropertyManagementTest extends TestCase
{
    public function test_property_creation_with_contacts()
    {
        $response = $this->postJson('/api/properties', [
            'reference' => 'PROP-001',
            'type' => 'apartment',
            'contacts' => [
                [
                    'role' => 'owner',
                    'name' => 'John Doe',
                    'email' => 'john@example.com'
                ]
            ]
        ]);
        
        $response->assertStatus(201);
        $this->assertDatabaseHas('properties', ['reference' => 'PROP-001']);
        $this->assertDatabaseHas('contacts', ['email' => 'john@example.com']);
    }
}
```

### 11.6 Documentation

#### 11.6.1 README.md
```markdown
# AquaLara App

## Installation
1. Cloner le repository
2. Copier `.env.example` vers `.env`
3. Configurer la base de données
4. Installer les dépendances : `composer install`
5. Générer la clé d'application : `php artisan key:generate`
6. Exécuter les migrations : `php artisan migrate`
7. Seeder la base de données : `php artisan db:seed`

## Structure de la Base de Données
- [Documentation détaillée de la structure](./docs/database.md)
- [Guide de migration](./docs/migration.md)
- [API Documentation](./docs/api.md)
```

#### 11.6.2 Documentation API
```php
/**
 * @api {post} /api/readings Créer un nouveau relevé
 * @apiName CreateReading
 * @apiGroup Readings
 *
 * @apiParam {Number} service_id ID du service
 * @apiParam {Number} value Valeur du relevé
 * @apiParam {Date} reading_date Date du relevé
 * @apiParam {String} reading_method Méthode de relevé
 *
 * @apiSuccess {Object} reading Le relevé créé
 */
public function store(Request $request)
{
    // ... logique de création
}
``` 