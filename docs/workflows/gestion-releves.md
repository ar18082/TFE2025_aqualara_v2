# Gestion des Relevés

## Vue d'ensemble
Le workflow de gestion des relevés permet de saisir, valider et traiter les relevés de consommation (chauffage, eau, électricité) pour chaque client.

## Processus

### 1. Saisie des Relevés
1. L'utilisateur sélectionne un client
2. Le système charge les paramètres du client :
   - Type de compteur
   - Coefficients
   - Historique des relevés
3. L'utilisateur saisit les nouvelles valeurs
4. Le système valide les données
5. Les relevés sont enregistrés

### 2. Traitement par Lots
1. L'utilisateur prépare plusieurs relevés
2. Le système traite les relevés en lots :
   - Validation des données
   - Calcul des consommations
   - Enregistrement en base
3. Un rapport de traitement est généré

### 3. Validation des Relevés
1. Le système vérifie les anomalies :
   - Valeurs aberrantes
   - Incohérences temporelles
   - Doublons
2. L'utilisateur valide ou corrige les anomalies
3. Les relevés validés sont marqués comme définitifs

### 4. Consultation des Relevés
1. L'utilisateur accède à l'historique des relevés
2. Il peut :
   - Filtrer par période
   - Filtrer par type de relevé
   - Exporter les données
3. Les graphiques de consommation sont disponibles

## Règles Métier

### Validation des Données
- Les valeurs doivent être positives
- Les dates doivent être cohérentes
- Les valeurs ne peuvent pas être inférieures aux précédentes
- Les écarts importants doivent être justifiés

### Calculs
- Consommation = Valeur actuelle - Valeur précédente
- Coût = Consommation × Prix unitaire
- TVA = Coût × Taux de TVA

### Permissions
- Saisie : Technicien et supérieur
- Validation : Manager et supérieur
- Consultation : Tous les utilisateurs
- Export : Comptable et supérieur

## Gestion des Erreurs

### Cas d'Erreur Courants
1. Valeur invalide
   - Message : "La valeur saisie n'est pas valide"
   - Action : Vérifier la saisie

2. Date incorrecte
   - Message : "La date doit être postérieure au dernier relevé"
   - Action : Corriger la date

3. Écart important
   - Message : "Attention : écart important avec le relevé précédent"
   - Action : Demander une justification

## Intégration avec Autres Modules

### Facturation
- Les relevés servent de base à la facturation
- Les anomalies sont signalées avant facturation

### Rapports
- Les relevés sont utilisés pour les rapports de consommation
- Les tendances sont calculées automatiquement

### Alertes
- Les écarts importants déclenchent des alertes
- Les relevés manquants sont signalés 