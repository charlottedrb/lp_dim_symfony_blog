(second repo car trop de bugs sur le premier) 

# Réponses TP 3 

## Doctrine 

> Quelles sont les fonctionnalités principales du Symfony CLI ? 
> [color=purple]

Le Symfony CLI permet de faciliter la création des différents éléments nécessaires au bon fonctionnement d'un projet Symfony. On peut créer les controllers, les entités mais aussi des modifications de la BDD (les migrations).


> Quelles relations existent entre les entités (Many To One/Many To Many/...) ? Faire un schéma de la base de données.
> [color=blue] 

![](https://i.imgur.com/JzRL2Dn.png)


> Expliquer ce qu'est le fichier .env
> [color=cyan]

Le fichier ``.env`` permet de stocker toutes les données un peu sensibles comme les accès à la BDD ou encore les clés d'API. 

> Expliquer pourquoi il faut changer le connecteur à la base de données 
> [color=green]

Le connecteur par défaut est PostGreSQL. Comme on souhaite utiliser SQLite, il faut donc commenter la ligne concernat PostGreSQL et décommenter celle de SQLite. 

> Expliquer l'intérêt des migrations d'une base de données 
> [color=lightgreen]

:::danger
L'intérêt des migrations est de faire du versionning. 
:::


## Administration 

### Administration dans Symfony 

> Faire une recherche sur les différentes solutions disponibles pour l'administration dans Symfony
> [color=yellow] 

Il existe différents bundles (packages) qui permettent de créer une administration sur Symfony. 

* SonataAdminBundle 
* EasyAdmin 

Sonata est très complet mais EasyAdmin (comme son nom l'indique) est simple à mettre en place. 
On utilisera Sonata pour des projets complexes et on préferera utiliser EasyAdmin pour le reste. 

### EasyAdmin 

```php=
composer require easycorp/easyadmin-bundle
```

> Travail préparatoire : Qu'est-ce que EasyAdmin ? 
> [color=orange]

EasyAdmin est un bundle qui permet de créer une administration back-end simple à utiliser et à mettre en place. 

#### Dashboard

Pour créer un tableau de bord on utilise cette commande : 
```php=
php bin/console make:admin:dashboard
```

#### Controllers CRUD

Si on veut utiliser les Controllers CRUD de EasyAdmin, il faut implémenter ``EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\CrudControllerInterface`` ou on peut extends ``AbstractCrudController``.

Pour générer ces controllers, on peut utiliser cette commande : 
```php= 
php bin/console make:admin:crud
```

CRUD signifie : create, show, update, delete.

En les générant, on peut avoir directement ces fonctionnalités. 

#### Design 

Ce bundle génère automatiquement des templates Twig pour visualiser l'administration. 

> Pourquoi doit-on implémenter des méthodes to string dans nos entités? 
> [color=pink]

Lorsqu'on utilise le ``AssociationField`` de EasyAdmin, on l'erreur ci-dessous : 

![](https://i.imgur.com/j2hyCJf.png)

En effet, un objet ne peut pas être utiliser comme ça, il faut implémenter la méthode ``_toString``.

> Qu'est-ce que le ParamConverter ? À quoi sert le Doctrine Param Converter ? 
> [color=red]

Le ParamConverter permet d'implicitement déterminer la nature de l'objet qu'on essaye d'atteindre. 

Par exemple, si on a un paramètre ``id`` dans notre URL et qu'on met dans notre fonction un paramètre de type Post, alors grâce au ParamConverter, on sait que l'``id`` sera l'id de notre Post. 

> Qu'est-ce qu'un formulaire Symfony ? 
> [color=purple]



