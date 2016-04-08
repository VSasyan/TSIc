# Un workflow pour git

Dans la suite, quand je dis *clean wd*, ça veut dire que le dossier de travail doit être propre (pas de fichiers modifiés, peu de fichiers non suivis).

# Création du dépôt central

(sur le serveur)

    git init --bare


# Tout le monde clone le dépôt

    git clone ssh://git@github.com:vsasyan/TSIc

À ce stade, il n'y a qu'une branche *master*. La branche *master* contient l'historique, taggué par le chef de projet, des versions release.

    v0.1       v0.2        v0.3  
    a -------- b --------- c    master

# La branche *develop*

Tous les développements seront rapatriés (mergés) ici, en général par une personne en particulier.

    v0.1      v0.2     v0.3  
    a ------- c ------ f   master  
     \       /        /  
      -- b ---- d -- e     develop

Bon, nous on ne va pas faire aussi compliqué, mettons *master* == *develop*.

    v0.1      v0.2           v0.3  
    a -- b -- c -- d -- e -- f   master

Rappel des commandes :

* Création d'une branche : `git branch <nom>`
* Changement de branche (clean wd) : `git checkout <nom>`
* Fusion d'une branche :
    * en local : `git merge <autre-branche>`
    * déjà poussée : `git pull origin <autre-branche>` (à préférer)
* Suppression d'une branche : `git branch -d <nom>` (Git s'assure que tout est bien fusionné)

# Les feature branchs

    a -- b -- d -- e -- f develop  
     \                 /  
      z -- y -- x -- w   dev-css

À partir de la branche *develop* (pour nous, *master*), chaque développeur crée une branche pour le sujet sur lequel il travaille.

Il fait tous ses commits sur cette branche.

S'il a besoin du commit de quelqu'un d'autre, il lui demande le numéro. L'autre va faire un `git log`, retrouver ledit commit qui a un en-tête de message **clair**, s'assurer qu'il a été poussé, et le donner au premier. Ce développeur va alors utiliser la commande suivante pour récupérer le ou lesdits commit(s) :

    git cherry-pick [--edit | --ff] <commit-sha>

Ceci est valable s'il y a qu'un seul commit ; sinon, mieux vaut faire un `git merge`.

Puis, il va fusionner avec develop. `git checkout develop` puis `git merge <dev-feature>`. (Pour nous, *master*)

# De la bonne façon de commiter

Si vous êtes sûr de n'avoir fait qu'une tâche à la fois, le `git add *` - `git commit` est OK.

Pour le `git commit`, essayez d'éviter d'utiliser l'option `-m`, car elle n'encourage pas à faire un message de commit clair. Préférez avoir votre éditeur de texte favori dans `git config core.editor "<commande-pour-lancer-votre-editeur-favori>"`.

Un message de commit est composé d'un résumé (< 80 caractères, première ligne), et d'un récapitulatif des choix techniques et des modifications effectués après avoir sauté une ligne.

Avant de `git add` un fichier, ne pas hésiter à faire un `git diff <fichier>`, qui vous aidera à vérifier que toutes les modifications effectuées concernent la même feature, et accessoirement que vous n'avez pas laissé traîner d'espaces ignominieuses.

# De la bonne façon de fusionner [utilisateurs avancés]

Il n'y a en fait pas de "bonne façon", mais une manière d'éviter la duplication de commits liées aux merges. L'inconvénient est une plus grande complexité et un peu de temps. Il s'agit de *rebasage* : intégrer les changements des autres *avant* les miens.

    git pull --rebase origin master

va intégrer tous les commits de master sous les nôtres [de notre branche dev-feature]. Il y aura des conflits, que nous règlerons à la main :

    git add <fichier-fusionné>
    git rebase --continue

ou, si le commit actuel est devenu superflu, `git rebase --skip`.

Si vous êtes perdu ou avez tout foiré, `git rebase --abort` et allez chercher un expert. Sinon, vous pouvez toujours faire une fusion normale, c'est un moindre mal.


