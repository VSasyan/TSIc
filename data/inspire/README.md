# À propos de notre implémentation du modèle Inspire

## Introduction

La directive Inspire décrit davantage les services associés aux
données géographiques que leur modélisation. En particulier, la
plupart des *Technical Guidelines* disponibles sur [1][inspire-tg]
s'intéressent à la mise en place des services plutôt qu'à la mise en
œuvre du modèle de données.

Pour implémenter les deux hiérarchies de classes qui nous servent de
prototype, nous nous sommes appuyé sur [2][inspire-tn].

### Network Bundle :

### Transport Bundle :


Comme vous pouvez le constater, il y a plusieurs écarts avec Inspire
expliqués ci-après.



## Sous-ensemble

Nous n'avons implémenté que les parents directs de `RoadLink` et
`RoadNode`. En ce qui concerne les propriétés des éléments du réseau,
nous n'en avons implémenté que trois, à titre d'exemple.

Selon la directive, les `TransportLink` et `TransportNode` sont censés
porter des attributs `validFrom` et `validTo`. Nous les avons oubliés.


## TransportObject

Lors de la mise en œuvre de la modélisation, les relations d'héritage
nous ont posé plusieurs problèmes.

Pour le cas de `TransportObject`, PHP ne permet pas l'héritage
multiple. Nous avons donc dû utiliser un *trait* afin de réutiliser le
code et, par là, simuler un héritage.


## Node <-> Link

[!Link --- Node --- Link](Node-Link.png)

Cette relation est faite entre deux classes parentes,
abstraites. Devant la complexité de la mise en œuvre d'une relation
d'héritage dans une base de données relationnelle, nous avons triché :
la relation bidirectionnelle entre un *Node* et un *Link* a été
redirigée vers les classes enfantes.

Il s'agit d'une relation OneToMany bidirectionnelle. Un nœud s'associe
à plusieurs liens au travers d'une table d'association. Comme une
*targetEntity* doit être une Entity, on ne peut pas la faire pointer
vers Link. De même dans l'autre sens, on ne peut pas pointer vers
Node. Ici, on peut tricher puisque nous n'avons que deux classes
filles : au lieu de pointer vers Node, on pointe vers RoadNode, et au
lieu de pointer vers Link, on pointe vers RoadLink.

À terme, quand `TransportNode` ou `TransportLink` auront plus d'un
enfant chacun, cette astuce ne suffira plus : il faudra recourir à un
véritable héritage comme ci-après.


## Element <-> Property

Dans le modèle de données que nous avons consulté [2][inspire-tn], il
n'est pas fait mention de cette association. De plus, à cause des
nombreuses relations d'héritage, elle est difficile à mettre en œuvre.

Nous avons d'abord essayé d'utiliser les `@MappedSuperclass` de
Doctrine, afin de faire pointer les `Element`s vers leurs
`Property`s. Il y a un certain nombre d'inconvénients :

- la MappedSuperclass doit être propriétaire de la relation ;
- l'identifiant doit avoir la portée *privée* ;

et malgré tout je n'ai pas réussi à l'implémenter.

Ensuite, nous avons essayé un héritage véritable, en déclarant la
classe `NetworkElement` comme une `@Entity`. Il faut alors choisir
la représentation relationnelle de l'héritage : table simple (= tous
les enfants dans une seule table) ou jointures (= une table pour
chaque parent). Les deux représentations nécessitent une colonne de
discrimination qui porte le type de l'élément enfant. Cela signifie
notamment que, lors de l'ajout d'une classe au modèle, au moins deux
fichiers doivent être modifiés.

La modélisation en une seule table a pour inconvénient de générer un
grand nombre de colonnes, surtout que pratiquement toutes les classes
d'Inspire dérivent de `NetworkElement`, et ont des attributs très
variés. La modélisation avec jointures est plus adaptée à un grand
nombre de classes variées, mais aussi bien plus lente.

Cette partie de la modélisation a été interrompue par manque de temps
et de connaissances techniques. La prochaine étape aurait été de
contacter un expert afin de déterminer quelle modélisation est la
meilleure. L'utilisation d'un base de données non relationnelle
pourrait également être examinée.


## Services

La directive Inspire est plutôt orientée vers les services liés à la
géomatique. Pour ce projet, nous n'avons pas eu le temps d'examiner
ces attentes. Peut-être n'y a-t-il pas obligation de produire un
modèle de données conforme, à condition de respecter
l'interopérabilité des services.



[inspire-tg](http://inspire.ec.europa.eu/index.cfm/pageid/2 Inspire
technical guidelines)

[inspire-tn](http://inspire.jrc.ec.europa.eu/documents/Data_Specifications/INSPIRE_DataSpecification_TN_v3.2.pdf
Inspire data specifications on Transport Networks)
