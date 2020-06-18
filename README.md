# CallBackTool

Un exercice avec Symfony et des appels à une API

## Versions

### TODO
  * Pages d'erreur personnalisées (404, 500)
  * amélioration des path avec locale

### v0.4.0
  * Validation du numéro de téléphone côté front
  * switch manuel pour la locale
    
### v0.3.2
  * Amélioration du traitement du tableau reçu par l'API Phone Validate
  * Retrait de l'entity manager de la couche Service
  * Amélioration de l'UI/UX en mode portables et tablettes
  * internationalisation du site

### v0.3.1
  * Correctif du client HTTP à la réception d'un numéro invalide
  
### v0.3.0
  * Validation du numéro via API
    * Verification Back => OK
    * Cache sur les requetes HTTP vers l'API => OK

### v0.2.0
  * Création des entités
  * Validation sommaire du formulaire
  * Enregistrement en base de données

### v0.1.0

  * Création des routes et vues
    * Home
    * Registred
    * Listing
  * Données en dur dans le code