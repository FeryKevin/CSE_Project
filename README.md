# Projet CSE

Site du comité social et économique du lycée Saint-Vincent, il permet de consulter les informations sur les offres et les partenariats du CSE à ses salariés.

## Contexte
Dans le cadre du BTS SIO du lycée Saint-Vincent ce projet est le bilan des connaissances et permet de capitaliser les deux années d'apprentissages au sein du BTS.

<br>

## Stack technique
 - Symfony
 - Twig
 - JavaScript

<br>

## Prérequis :
 - PHP 8.1 +
 - Système de gestion de base de données
 - Composer

<br>

## Installation
Un makefile est présent afin de simplifier l'installation et la préparation, vous pouvez effectuer plusieurs commande :

Afin d'installer toutes les dépendences composer :
```bash
make vendor
```

Afin de créer et remplir la base de données :
```bash
make database
```

Pour lancer le serveur de développement :
```bash
symfony serve
```

## Connexion

```bash
Login : e@e.e
```

```bash
Password : aaa
```

## Optionnel
Possibilité de lancer le projet avec docker, l'environnement se compose d'une partie base de données ainsi qu'une partie mailcatcher
