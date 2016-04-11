# Listes des Vues du Sprint2

## Controller User

### list

Permet à l'administrateur de lister l'ensemble des utilisateurs sur le site.

    Controller : UserController:listAction
    Url : /admin/user/list
    Route : user_list
    Vues : User:list.html.twig

Entrée Controlleur :
* $fitre_username (permet de filtrer les utilisateurs si $fitre_username n'est pas *contenu* dans leur username)

Entrée Vues :
* users : la liste des users

Sortie vues (doit figurer) :
* Une liste avec : Prénom Nom (Username)
* un signe distinctif s'ils sont Professionnels / Admin
* En cliquant sur un élément de la liste, on est dirigé vers `path('user_show', {id : user.id})`

### show

Permet à n'importe qui de consulter le profile associé à un membre.

    Controller : UserController:listAction
    Url : /user/show/{id}
    Route : user_show
    Vues : User:show.html.twig

Entrée Controlleur :
* $id : l'indentifiant 

Entrée vue :
* user : l'utilisateur

Sortie de la vue :
* doit figurer tous les attributs associés au profile du membre ;
* doit figurer son statut ;
* doit figurer, si l'utilisateur connecté est Admin, des boutons pour changer le statut (`path('user_upgrade', {id_user:user.id, id_status: [1,2,3])`).

Si le membre n'est pas trouvé, redirection vers l'accueil ('accueil').

### upgrade

Permet à l'administrateur de changer le statut d'un utilisateur.

    Controller : UserController:upgradeAction
    Url : /admin/user/upgrade/{id_user}/{id_status}
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

Redirection si form valide vers 'perturbation_show' à l'id de la perturbation crée à l'instant.

### archive

Permet aux administrateurs/professionnels d'archiver une perturbation.

    Controller : PerturbationController:archiveAction
    Url : /pro/perturbation/archive/{id_perturbation}/{id_message}
    Route : perturbation_archive
    Vues : Ajax:confirmation.html.twig

L'attribut `archived` de la perturbation passe à `true`. Elle n'est plus affichée.

Confirmation en Ajax grâce à des messages sur l'objet `$request`.

### edit

Permet aux professionnels d'editer une perturbation.

    Controller : PerturbationController:editAction
    Url : /pro/perturbation/edit/{id}
    Route : perturbation_aedit
    Vues : Perturbation:edit.html.twig

Entrée controller :
* Request $request : le formulaire de la Formulmation à ajouter
* $id : l'indentifiant de la perturbation à modifier

Le controller crée une nouvelle formulation asociée à la perturbation.
Cette formulation doit être valide, les autres non.
La pertrubation est automatiquement validée.

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

Permet à tout le monde de recevoir les perturbations alentour en AJAX.

    Controller : PerturbationController:listNearestAction
    Url : /perturbation/list/nearest/{position}/{rayon=1000}
    Route : perturbation_list_nearest
    Vues : Ajax:index.html.twig

Entrée vue :
* perturbations : liste des perturbations retravaillée :

On a un nouvel objet PerturbationVirtuel de type :

    perturbation.id
    perturbation.nom
    perturbation.center
    perturbation.geoJSON
    perturbation.type

Les attributs suplémentaires par rapport à la classe `Perturbation` de base sont récupérés sur la dernière `Formulation`.

Les pertubations non-actives, non-valides, terminées ou archivées ne sont pas affichée !

### listAll

Permet à l'administrateur, de lister toutes les perturbations.

    Controller : PerturbationController:listAllAction
    Url : /perturbation/list/all
    Route : perturbation_list_all
    Vues : Perturbation:all.html.twig

Entrée vue :
* perturbations : liste des perturbations retravaillée

On a un nouvel objet de type :

    perturbation.id
    perturbation.nom
    perturbation.center
    perturbation.type

Les attributs suplémentaires par rapport à la classe `Perturbation` de base sont récupérés sur la dernière `Formulation`.


## Vote

### vote

Permet aux utilisateurs loggués de voter une nouvelle perturbation.

    Controller : VoteController:voterAction
    Url : /perturbation/voter/{id_perturbation}/{id_message}
    Route : perturbation_voter
    Vues : Ajax:confirmation.html.twig

L'utilisateur doit être connecté (statut Particulier, Professionnel ou Admin).
Si l'utilisateur est Professionnel ou Admin, son vote change immédiatement le statut de la perturbation, sinon il faut 3 votes identiques (même message) pour le faire.

id_message :
* 1 : inhiber
* 2 : terminer
* 3 : valider

Etat de la perturbation à l'origine : [activee, non-valide, non-terminee]
* état après 3 votes `inhiber` : [non-activee, non-valide, non-terminee], la perturbation *n'est plus* affichée ;
* état après 3 votes `terminer` : [activee, valide, terminee], la perturbation *n'est plus* affichée ;
* état après 3 votes `valider` : [activee, valide, non-terminee], la perturbation *est toujours* affichée.

On remarque que les votent `terminer` valident également la perturbation.

Confirmation en Ajax grâce à des messages sur l'objet `$request`.


## ObjectTerrain

### listNearest

Permet aux utilisateurs de récupérer une liste des objects terrain à proximité.

    Controller : ObjetTerrainController:listNearestAction
    Url : /objet/terrain/list/nearest/{position}/{rayon=1000}
    Route : objet_terrain_list_nearest
    Vues : néant

Entrée controlleur :
* position : position en WKT
* rayon : rayon en mètre (par défaut 1000)

Sortie : (format JSON)

    [{
        name : String,
        position : WKT,
        type : integer
    }]

## File

### logoTypePerturbation

Permet aux utilisateurs de récupérer l'image associée à une perturbation.

    Controller : FileControlleur:logoTypePerturbationAction
    Url : /file/logo-type-perturbation/{id}
    Route : logo_type_perturbation
    Vues : néant

Entrée controlleur :
* id de la pertubation

Si la perturbation n'est pas trouvée, cela renvoie l'icone par défaut, sinon l'icone correspondant à la pertrbation (chemin stocké dans l'attribut `logoPicturePath`).

### logoTypeObjetTerrain

Permet aux utilisateurs de récupérer l'image associée à un TypeObjetTerrain.

    Controller : FileControlleur:logoTypeObjetTerrain
    Url : /file/logo-type-objet-terrain/{id}
    Route : logo_type_objet_terrain
    Vues : néant

Entrée controlleur :
* id du type d'objet terrain

Si le type n'est pas trouvé, cela renvoie l'icone par défaut, sinon l'icone correspondant au type (chemin stocké dans l'attribut `logoPicturePath`).
