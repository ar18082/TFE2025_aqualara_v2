# Documentation des Workflows Métier AquaLara

## Table des matières
1. [Gestion des Clients](#gestion-des-clients)
2. [Gestion des Relevés](#gestion-des-relevés)
3. [Gestion des Documents](#gestion-des-documents)
4. [Gestion des Factures](#gestion-des-factures)

## Gestion des Clients

### Création d'un Client
```mermaid
sequenceDiagram
    participant U as Utilisateur
    participant F as Formulaire
    participant C as ClientController
    participant DB as Base de données

    U->>F: Remplit le formulaire
    F->>C: Envoie les données
    C->>C: Valide les données
    C->>DB: Crée le client
    DB-->>C: Confirme la création
    C-->>F: Affiche le succès
    F-->>U: Affiche le message
```

### Modification d'un Client
```mermaid
sequenceDiagram
    participant U as Utilisateur
    participant F as Formulaire
    participant C as ClientController
    participant DB as Base de données

    U->>F: Modifie les données
    F->>C: Envoie les modifications
    C->>C: Valide les données
    C->>DB: Met à jour le client
    DB-->>C: Confirme la mise à jour
    C-->>F: Affiche le succès
    F-->>U: Affiche le message
```

## Gestion des Relevés

### Saisie des Relevés
```mermaid
sequenceDiagram
    participant U as Utilisateur
    participant F as Formulaire
    participant C as DecompteController
    participant S as Service
    participant DB as Base de données

    U->>F: Sélectionne le client
    F->>C: Demande les paramètres
    C->>S: Récupère les paramètres
    S-->>C: Retourne les paramètres
    C-->>F: Affiche le formulaire
    U->>F: Saisit les relevés
    F->>C: Envoie les données
    C->>S: Traite les données
    S->>DB: Enregistre les relevés
    DB-->>S: Confirme l'enregistrement
    S-->>C: Retourne le succès
    C-->>F: Affiche le succès
    F-->>U: Affiche le message
```

### Traitement par Lots
```mermaid
sequenceDiagram
    participant U as Utilisateur
    participant C as DecompteController
    participant B as BatchService
    participant DB as Base de données

    U->>C: Envoie plusieurs relevés
    C->>B: Traite par lots
    loop Pour chaque lot
        B->>DB: Enregistre les relevés
        DB-->>B: Confirme l'enregistrement
    end
    B-->>C: Retourne le résultat
    C-->>U: Affiche le résultat
```

## Gestion des Documents

### Upload de Documents
```mermaid
sequenceDiagram
    participant U as Utilisateur
    participant F as Formulaire
    participant C as DocumentController
    participant S as StorageService
    participant DB as Base de données

    U->>F: Sélectionne le fichier
    F->>C: Envoie le fichier
    C->>S: Valide le fichier
    S->>S: Stocke le fichier
    S->>DB: Enregistre les métadonnées
    DB-->>S: Confirme l'enregistrement
    S-->>C: Retourne le succès
    C-->>F: Affiche le succès
    F-->>U: Affiche le message
```

## Gestion des Factures

### Génération de Factures
```mermaid
sequenceDiagram
    participant U as Utilisateur
    participant C as FactureController
    participant S as FactureService
    participant P as PDFService
    participant DB as Base de données

    U->>C: Demande une facture
    C->>S: Prépare les données
    S->>DB: Récupère les données
    DB-->>S: Retourne les données
    S->>P: Génère le PDF
    P-->>S: Retourne le PDF
    S->>DB: Enregistre la facture
    DB-->>S: Confirme l'enregistrement
    S-->>C: Retourne la facture
    C-->>U: Affiche la facture
```

## Rôles et Permissions

### Hiérarchie des Rôles
```mermaid
graph TD
    A[Administrateur] --> B[Manager]
    B --> C[Technicien]
    B --> D[Comptable]
    C --> E[Opérateur]
    D --> E
```

### Matrice des Permissions
| Action | Admin | Manager | Technicien | Comptable | Opérateur |
|--------|-------|---------|------------|-----------|-----------|
| Gestion Clients | ✓ | ✓ | ✓ | ✗ | ✗ |
| Saisie Relevés | ✓ | ✓ | ✓ | ✗ | ✓ |
| Gestion Documents | ✓ | ✓ | ✓ | ✓ | ✗ |
| Génération Factures | ✓ | ✓ | ✗ | ✓ | ✗ |
| Configuration Système | ✓ | ✗ | ✗ | ✗ | ✗ |