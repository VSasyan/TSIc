# Listes des Vues du Sprint1

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

### vote

Permet aux utilisateurs loggués de voter une nouvelle perturbation.

    Controller : PerturbationController:voterAction
    Url : /perturbation/voter/{id_perturbation}/{id_message}
    Route : perturbation_voter
    Vues : néant

L'utilisateur doit être connecté (statut Particulier, Professionnel ou Admin).
Si l'utilisateur est Professionnel ou Admin, sont vote change immédiatement le statut de la paerturbation, sinon il faut 3 votes identiques pour le faire.

Confirmation en Ajax (vue 'Ajax:confirmation.html.twig') grâce à des messages sur l'objet `$request`.

id_message :
* 1 : inhiber
* 2 : terminer
* 3 : valider

### archive

Permet aux administrateurs/professionnels d'archiver une perturbation.

    Controller : PerturbationController:archiveAction
    Url : /pro/perturbation/archive/{id_perturbation}/{id_message}
    Route : perturbation_archive
    Vues : néant

L'attribut `activated` de la pertrubation passe `false`. Elle n'est plus affichée.

Confirmation en Ajax (vue 'Ajax:confirmation.html.twig') grâce à des messages sur l'objet `$request`.

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
    perturbation.type

Les attributs suplémentaires par rapport à la classe `Perturbation` de base sont récupérés sur la dernière `Formulation`.


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




TEMP :

	public function findOneByGroupe($id_groupe, $rang)
	{
		$choix = $this->createQueryBuilder('c')
			->where('c.groupeChoix = :id_groupe')
			->setParameter('id_groupe', $id_groupe)
			->andWhere('c.rang = :rang')
			->setParameter('rang', $rang)
			->getQuery()
			->getResult();
		if ($choix != null){
			return $choix[0];
		}
		return null;
	}
