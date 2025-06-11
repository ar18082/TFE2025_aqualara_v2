# TODO List - Optimisations AquaLara-App

## 1. Modifications dans l'interface "Détails Provisions"
- [N] Fusionner les deux formulaires en un seul
- [N] Ajouter un champ "Date" à côté du bouton "Enregistrer"
- [N] Permettre la saisie de la date pour le relevé et le décompte
- [N] Transformer la colonne "provision" en "clé de répartition" quand l'option "montant global réparti" est sélectionnée
- [N] Ajouter la possibilité de déverrouiller la colonne avec la touche §
- [ ] ⚠️ À TERMINER : Implémenter le stockage des provisions dans la base de données (créer la table appropriée après analyse de la structure existante du client)

## 2. Modifications dans la section Gaz et Électricité
- [N] Supprimer les champs suivants dans la partie inférieure :
  - Nombre de mètres cubes
  - Prix du mètre cube
  - Total frais d'hiver
  - Total frais

## 3. Améliorations de l'interface de saisie
- [N] Rendre les titres cliquables pour déverrouiller chaque colonne
- [N] Conserver les raccourcis clavier pour le déblocage
- [N] Supprimer les alertes lors de l'utilisation des touches
- [N] Supprimer les demandes de confirmation
- [N] Gérer l'affichage des bordures input dans le titre :
  - Masquer les bordures si read only
  - Afficher les bordures une fois le read only désactivé
- [N] Standardiser l'affichage des messages d'aide pour le déverrouillage des colonnes
- [N] Centraliser les styles de déverrouillage dans un fichier SCSS dédié

## 4. Ajout de fonctionnalités dans le menu
- [ ] Ajouter un bouton "Enregistrer" dans les saisies
- [N] Ajouter un bouton "Générer décomptes" à la fin de la ligne du menu déroulant

## 5. Gestion des décomptes
- [ ] Améliorer la génération des PDF :
  - Permettre le choix entre un fichier PDF unique ou des fichiers séparés par appartement
  - Supprimer l'option d'impression PDF actuelle
  - Générer automatiquement les PDF lors de la validation du décompte
  - Intégrer la modification directement dans le programme sans passer par Word

## 6. Gestion des erreurs
- [ ] Améliorer la détection des erreurs :
  - Vérifier la cohérence entre les relevés de chauffage et d'eau
  - Vérifier les index (ancien vs nouveau)
  - Afficher les erreurs en temps réel lors de la saisie

## 7. Interface de clôture des décomptes
- [ ] Modifier le processus de clôture :
  - Ajouter une étape de validation avant la clôture
  - Permettre la génération des PDF à ce moment
  - Gérer la disparition du décompte de la liste une fois clôturé

## 8. Améliorations générales
- [ ] Optimiser la génération des fichiers Word
- [ ] Améliorer la gestion des frais annexes et divers
- [ ] Permettre la modification des libellés dans les fiches individuelles
- [ ] Gérer correctement l'affichage des frais dans les différentes sections (chauffage/eau)

## 9. Gestion des données et calculs
### 9.1 Calculs de répartition
- [ ] Implémenter la formule : consommation de combustible = part chauffage + part eau chaude
- [ ] Mettre en place le calcul du multiplicateur pour la matière chauffante
- [ ] Gérer les coefficients de répartition (exemple : 0,62, 0,63)

### 9.2 Prix de l'eau froide
- [ ] Calculer le prix unitaire de l'eau froide
- [ ] Intégrer ce prix dans le calcul de l'eau chaude (A20 + prix eau froide)
- [ ] Gérer la répartition des coûts entre eau chaude et froide

### 9.3 Distinction eau chaude/froide
- [ ] Mettre en place des compteurs séparés
- [ ] Gérer les cas où il y a uniquement de l'eau chaude
- [ ] Intégrer les différents tarifs selon le type d'eau

## 10. Stockage et base de données
### 10.1 Tables historiques
- [ ] Créer une structure pour stocker l'historique des montants
- [ ] Implémenter un système de versionnage des données
- [ ] Gérer les dates de modifications

### 10.2 Gestion des montants
- [ ] Stocker les prix unitaires
- [ ] Conserver l'historique des modifications
- [ ] Gérer les différentes périodes de facturation

### 10.3 Synchronisation
- [ ] Mettre en place un système de mise à jour en temps réel
- [ ] Gérer les conflits de données
- [ ] Assurer la cohérence entre l'interface et la base

## 11. Interface utilisateur avancée
### 11.1 Saisie des détails
- [ ] Créer des formulaires de saisie intuitifs
- [ ] Ajouter des validations des données
- [ ] Implémenter des calculs automatiques

### 11.2 Consultation historique
- [ ] Développer une interface de visualisation des données historiques
- [ ] Permettre la comparaison entre différentes périodes
- [ ] Ajouter des filtres de recherche

### 11.3 Enregistrement modifications
- [ ] Créer un système de sauvegarde automatique
- [ ] Implémenter un journal des modifications
- [ ] Ajouter des confirmations pour les changements importants

## 12. Gestion avancée des décomptes
### 12.1 Génération
- [ ] Automatiser le processus de création des décomptes
- [ ] Intégrer tous les paramètres nécessaires
- [ ] Gérer les cas particuliers (communs, frais annexes)

### 12.2 Système de clôture
- [ ] Définir le processus de clôture
- [ ] Implémenter les vérifications nécessaires
- [ ] Gérer l'archivage des décomptes clôturés

### 12.3 Période de décompte
- [ ] Gérer les dates de début et fin
- [ ] Calculer les prorata temporis
- [ ] Gérer les chevauchements de périodes

## 13. Améliorations techniques
### 13.1 Tables DEC
- [ ] Optimiser la structure des tables
- [ ] Gérer les relations entre les différentes tables
- [ ] Améliorer les performances des requêtes

### 13.2 Frais TR
- [ ] Implémenter le calcul des frais de relevé
- [ ] Gérer la répartition par appartement
- [ ] Intégrer les différents types de compteurs

### 13.3 Cas particuliers
- [ ] Gérer les relevés sans montants
- [ ] Traiter les cas de compteurs défectueux
- [ ] Gérer les changements de locataires

## 14. Documentation et tests
### 14.1 Documentation système
- [ ] Décrire en détail les formules de calcul
- [ ] Documenter l'architecture de la base de données
- [ ] Créer des guides utilisateurs

### 14.2 Tests
- [ ] Créer des scénarios de test complets
- [ ] Tester les cas limites
- [ ] Valider les calculs automatiques

### 14.3 Vérification données
- [ ] Mettre en place des contrôles de cohérence
- [ ] Valider les données historiques
- [ ] Créer des rapports d'anomalies

## 15. Maintenance
### 15.1 Nettoyage données
- [ ] Identifier et supprimer les données de test
- [ ] Corriger les incohérences
- [ ] Optimiser l'espace de stockage

### 15.2 Optimisation
- [ ] Améliorer les temps de réponse
- [ ] Optimiser les requêtes complexes
- [ ] Gérer la montée en charge

### 15.3 Gestion versions
- [ ] Maintenir la compatibilité avec les anciennes données
- [ ] Gérer les migrations de données
- [ ] Documenter les changements de version

## Notes
- Chaque tâche doit être validée avant de passer à la suivante
- Les tests doivent être écrits pour chaque nouvelle fonctionnalité
- La documentation doit être mise à jour au fur et à mesure
- Les performances doivent être mesurées avant et après chaque optimisation

## Progression
- [N] 1. Modifications dans l'interface "Détails et Provisions"
- [N] 2. Modifications dans la section Gaz et Électricité
- [N] 3. Améliorations de l'interface de saisie
- [N] 4. Ajout de fonctionnalités dans le menu
- [ ] 5. Gestion des décomptes
- [ ] 6. Gestion des erreurs
- [ ] 7. Interface de clôture des décomptes
- [ ] 8. Améliorations générales
- [ ] 9. Gestion des données et calculs
- [ ] 10. Stockage et base de données
- [ ] 11. Interface utilisateur avancée
- [ ] 12. Gestion avancée des décomptes
- [ ] 13. Améliorations techniques
- [ ] 14. Documentation et tests
- [ ] 15. Maintenance 