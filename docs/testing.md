# Documentation des Tests

## Table des matières
1. [Vue d'ensemble](#vue-densemble)
2. [Configuration](#configuration)
3. [Types de Tests](#types-de-tests)
4. [Organisation](#organisation)
5. [Exécution](#exécution)
6. [Bonnes Pratiques](#bonnes-pratiques)
7. [Maintenance](#maintenance)

## Vue d'ensemble

Les tests sont une partie essentielle du développement d'AquaLara. Ils garantissent la qualité et la fiabilité de l'application.

### Outils Utilisés
- PHPUnit pour les tests PHP
- Laravel Testing pour les tests d'intégration
- Jest pour les tests JavaScript
- Cypress pour les tests E2E

## Configuration

### PHPUnit

```xml
<!-- phpunit.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true">
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
        <testsuite name="Integration">
            <directory>tests/Integration</directory>
        </testsuite>
    </testsuites>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="DB_DATABASE" value="aqualara_testing"/>
    </php>
</phpunit>
```

### Jest

```javascript
// jest.config.js
module.exports = {
    testEnvironment: 'jsdom',
    setupFilesAfterEnv: ['<rootDir>/tests/setup.js'],
    moduleNameMapper: {
        '^@/(.*)$': '<rootDir>/resources/js/$1',
    },
    collectCoverageFrom: [
        'resources/js/**/*.{js,jsx}',
        '!resources/js/bootstrap.js',
    ],
};
```

## Types de Tests

### Tests Unitaires

```php
// tests/Unit/ClientTest.php
class ClientTest extends TestCase
{
    /** @test */
    public function it_can_calculate_total_consumption()
    {
        $client = new Client();
        $client->addReading(100);
        $client->addReading(200);
        
        $this->assertEquals(300, $client->getTotalConsumption());
    }
}
```

### Tests d'Intégration

```php
// tests/Integration/DecompteControllerTest.php
class DecompteControllerTest extends TestCase
{
    /** @test */
    public function it_can_store_heating_readings()
    {
        $response = $this->postJson('/api/decompte/heating', [
            'client_id' => 1,
            'readings' => [
                ['value' => 100, 'date' => '2024-01-01'],
            ],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('rel_chauf', [
            'client_id' => 1,
            'value' => 100,
        ]);
    }
}
```

### Tests de Performance

```php
// tests/Performance/AjaxPerformanceTest.php
class AjaxPerformanceTest extends TestCase
{
    /** @test */
    public function it_meets_performance_requirements()
    {
        $start = microtime(true);
        
        $response = $this->getJson('/api/clients');
        
        $duration = microtime(true) - $start;
        $this->assertLessThan(0.1, $duration);
    }
}
```

### Tests E2E

```javascript
// cypress/integration/client.spec.js
describe('Client Management', () => {
    it('can create a new client', () => {
        cy.visit('/clients/create');
        cy.get('#client-name').type('Test Client');
        cy.get('#client-email').type('test@example.com');
        cy.get('button[type="submit"]').click();
        
        cy.url().should('include', '/clients');
        cy.contains('Test Client').should('exist');
    });
});
```

## Organisation

### Structure des Dossiers

```
tests/
├── Unit/
│   ├── Models/
│   └── Services/
├── Feature/
│   ├── Controllers/
│   └── Workflows/
├── Integration/
│   ├── API/
│   └── Database/
├── Performance/
│   ├── Ajax/
│   └── Database/
└── E2E/
    ├── Client/
    └── Decompte/
```

### Factories

```php
// database/factories/ClientFactory.php
class ClientFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
```

## Exécution

### Commandes

```bash
# Tests unitaires
php artisan test --filter=Unit

# Tests d'intégration
php artisan test --filter=Integration

# Tests de performance
php artisan test --filter=Performance

# Tests E2E
npm run cypress:open

# Couverture de code
php artisan test --coverage-html coverage
```

### CI/CD

```yaml
# .github/workflows/tests.yml
name: Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
      - name: Install Dependencies
        run: composer install
      - name: Run Tests
        run: php artisan test
```

## Bonnes Pratiques

### Règles de Nommage
- Préfixer les classes de test avec le nom de la classe testée
- Utiliser des noms de méthodes descriptifs
- Suivre le format `it_should_do_something`

### Isolation
- Utiliser des transactions pour les tests de base de données
- Réinitialiser l'état entre les tests
- Éviter les dépendances entre les tests

### Assertions
- Une assertion par test
- Utiliser des assertions spécifiques
- Documenter les cas particuliers

## Maintenance

### Nettoyage

```bash
# Nettoyer les fichiers de test générés
php artisan test:clean

# Supprimer les anciens rapports de couverture
rm -rf coverage/
```

### Mise à Jour

```bash
# Mettre à jour PHPUnit
composer update phpunit/phpunit

# Mettre à jour Jest
npm update jest

# Mettre à jour Cypress
npm update cypress
```

### Monitoring

- Suivre la couverture de code
- Analyser les temps d'exécution
- Identifier les tests flaky
- Maintenir les fixtures à jour 