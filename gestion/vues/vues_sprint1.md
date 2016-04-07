# Listes des Vues du Sprint1

## Controller User

### list

Permet à l'administrateur de lister l'ensemble des utilisateurs sur le site.

    Controller : UserController:listAction
    Url : /user/list
    Route : user_list
    Vues : User:list.html.twig

### show

Permet à n'importe qui de consulter le profile associé à un membre.

    Controller : UserController:listAction
    Url : /user/show/{id}
    Route : user_show
    Vues : User:show.html.twig

Si le membre n'est pas trouvé, redirection vers la liste des membres ('user_list').

Entrée de la vue :
* membre

### upgrade

Permet à l'administrateur de changer le statut d'un utilisateur.

    Controller : UserController:upgradeAction
    Url : /user/upgrade/{id_user}/{id_status}
    Route : user_upgrade
    Vues : néant

Si problème (membre non trouvé, status invalide, autorisation manquante, ...),
redirection vers la liste des membres ('user_list').
Si succès, redirection vers la fiche du membre ('user_show').

id_status :
* 1 : particulier
* 2 : professionnel
* 3 : admin

## Perturbation

### show

Permet à n'importe qui de consulter le détail d'une pertrubation et de ses formulations.

    Controller : PerturbationController:showAction
    Url : /perturbation/show/{id}
    Route : perturbation_show
    Vues : Perturbation:show.html.twig

Si la pertrubation n'est pas trouvée, redirection vers ('accueil').

Entrée de la vue :
* perturbation

### add

Permet aux utilisateurs loggués de créer une nouvelle perturbation.

    Controller : PerturbationController:addAction
    Url : /perturbation/add
    Route : perturbation_add
    Vues : Perturbation:add.html.twig

Entrée de la vue :
* form

Redirection si form valide vers 'perturbation_show'.

### vote

Permet aux utilisateurs loggués de voter une nouvelle perturbation.

    Controller : PerturbationController:voterAction
    Url : /perturbation/voter/{id_perturbation}/{id_message}
    Route : perturbation_voter
    Vues : néant

Redirection vers 'perturbation_show'.

id_message :
* 1 : inhiber
* 2 : terminer
* 3 : valider

### archive

Permet aux administrateurs/professionnels d'archiver une perturbation.

    Controller : PerturbationController:archiveAction
    Url : /perturbation/archive/{id_perturbation}/{id_message}
    Route : perturbation_archive
    Vues : néant

Redirection vers 'perturbation_list'. Ajax ?

### edit

Permet aux professionnels d'editer une perturbation.

    Controller : PerturbationController:editAction
    Url : /perturbation/edit/{id}
    Route : perturbation_aedit
    Vues : Perturbation:edit.html.twig

Entrée vue :
* form

Si form valide, redirection vers 'perturbation_show'.

### index

Permet à tout le monde, de lister les perturbations alentour en appelant 'perturbation_list_nearest' en AJAX.

    Controller : PerturbationController:indexAction
    Url : /
    Route : accueil
    Vues : Ajax:index.html.twig

Entrée vue :
* title : "Liste des perturbations à proximité"
* function : "list_nearest"

### listNearest

Permet à tout le monde, de recevoir les perturbations alentour en AJAX.

    Controller : PerturbationController:listNearestAction
    Url : /perturbation/list/nearest/{position}/{rayon=1000}
    Route : perturbation_list_nearest
    Vues : Ajax:index.html.twig

Entrée vue :
* perturbations : liste des perturbations retravaillée :

On a un nouvel objet de type :

    perturbation.id
    perturbation.nom
    perturbation.center
    perturbation.geoJSON
    perturbation. autre ?

Les attributs suplémentaires par rapport à la classe `Perturbation` de base sont récupérés sur la dernière `Formulation`.
