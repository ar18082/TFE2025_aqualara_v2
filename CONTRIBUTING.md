# Guide de Contribution pour les Développeurs

## Table des matières
1. [Introduction](#introduction)
2. [Prérequis](#prérequis)
3. [Installation](#installation)
4. [Structure du Projet](#structure-du-projet)
5. [Standards de Code](#standards-de-code)
6. [Workflow de Développement](#workflow-de-développement)
7. [Tests](#tests)
8. [Documentation](#documentation)
9. [Déploiement](#déploiement)

## Introduction

Ce guide explique comment contribuer au projet AquaLara-App. Il est important de suivre ces directives pour maintenir la qualité et la cohérence du code.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- MySQL 8.0 ou supérieur
- Node.js 16 ou supérieur
- Git

## Installation

1. Cloner le repository :
```bash
git clone https://github.com/votre-organisation/aqualara-app.git
cd aqualara-app
```

2. Installer les dépendances PHP :
```bash
composer install
```

3. Installer les dépendances JavaScript :
```bash
npm install
```

4. Configurer l'environnement :
```bash
cp .env.example .env
php artisan key:generate
```

5. Configurer la base de données dans `.env`

6. Exécuter les migrations :
```bash
php artisan migrate
```

7. Lancer le serveur de développement :
```bash
php artisan serve
npm run dev
```

## Structure du Projet

```
aqualara-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── Services/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   └── views/
├── routes/
├── tests/
└── docs/
```

## Standards de Code

### PHP

- Suivre les standards PSR-12
- Utiliser le typage strict
- Documenter les méthodes avec PHPDoc
- Limiter la complexité cyclomatique à 10

### JavaScript

- Utiliser ES6+
- Suivre les conventions Airbnb
- Documenter les fonctions avec JSDoc
- Limiter la complexité des fonctions

### Git

- Messages de commit descriptifs
- Format : `type(scope): description`
- Types : feat, fix, docs, style, refactor, test, chore

## Workflow de Développement

1. Créer une branche pour la fonctionnalité :
```bash
git checkout -b feature/nom-de-la-fonctionnalite
```

2. Développer et tester localement

3. Commiter les changements :
```bash
git add .
git commit -m "feat: description de la fonctionnalité"
```

4. Pousser les changements :
```bash
git push origin feature/nom-de-la-fonctionnalite
```

5. Créer une Pull Request

## Tests

### Tests Unitaires

```bash
php artisan test --filter=NomDuTest
```

### Tests d'Intégration

```bash
php artisan test --filter=Integration
```

### Tests de Performance

```bash
php artisan test --filter=Performance
```

## Documentation

### Code

- Documenter toutes les classes et méthodes
- Inclure des exemples d'utilisation
- Expliquer les paramètres et retours

### API

- Documenter tous les endpoints
- Inclure des exemples de requêtes
- Expliquer les codes de retour

### Workflows

- Documenter les processus métier
- Inclure des diagrammes
- Expliquer les règles de validation

## Déploiement

### Staging

1. Merger dans la branche `staging`
2. Les tests automatiques s'exécutent
3. Le déploiement est automatique si les tests passent

### Production

1. Créer un tag de version
2. Les tests automatiques s'exécutent
3. Le déploiement est manuel après validation

## Support

Pour toute question ou problème :
- Créer une issue sur GitHub
- Utiliser le canal Slack #dev-support
- Contacter l'équipe de développement 