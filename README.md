# CallBackTool

Un exercice avec Symfony et des appels à une API

## Versions

### TODO
  * Mettre en place la vérification du numéro depuis la vue
    * Configurer le bundle FOSJsRoutingBundle
    * Appel à une route symfony via JS => terminer le script
    
### v0.3.2
  * Amélioration du traitement du tableau reçu par l'API Phone Validate
  * Retrait de l'entity manager de la couche Service
  * Amélioration de l'UI/UX en mode portables et tablettes

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