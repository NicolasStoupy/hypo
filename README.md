# Projet Hypo

Le projet `hypo` est une application web dédiée à la gestion des opérations d'un centre d'hypothérapie. Ce guide vous
aidera à installer et configurer le projet sur votre machine locale.

---

## Prérequis

Avant de commencer, assurez-vous que votre machine dispose des logiciels suivants installés :

- **Git** : Pour cloner le projet depuis le dépôt.
- **Composer** : Un gestionnaire de dépendances PHP.
- **Node.js et npm** : Pour gérer les dépendances JavaScript et compiler les assets.
- **PHP** : Le langage utilisé pour le backend de l'application.

Vous pouvez vérifier si ces outils sont installés en utilisant les commandes suivantes dans votre terminal :

```bash
git --version
composer --version
node --version
npm --version
php --version
```

**Installation**

Suivez ces étapes pour configurer le projet localement.

**1\. Cloner le répertoire Git**

Clonez le projet hypo en utilisant Git. Exécutez cette commande dans votre terminal :

```bash
git clone <https://github.com/NicolasStoupy/hypo.git>
```
**2\. Accéder au répertoire du projet**

Une fois le projet cloné, accédez au répertoire du projet :

```bash
cd hypo
```
**3\. Installer les dépendances PHP avec Composer**

Installez les dépendances PHP nécessaires pour faire fonctionner le backend de l'application :
```bash
composer install
```
**4\. Installer les dépendances JavaScript avec npm**

Ensuite, installez les dépendances JavaScript nécessaires pour le frontend :
```bash
npm install
```
**5\. Compiler les assets**

Compilez les fichiers JavaScript et CSS pour préparer l'interface de votre application :
```bash
npm run build
```
**6\. Exécuter les migrations de la base de données**

Pour configurer la base de données, exécutez les migrations. Cela créera les tables nécessaires dans votre base de données :
```bash
php artisan migrate
```
**7\. Seeder de la base de données**

Si vous souhaitez remplir la base de données avec des données de test, exécutez la commande suivante pour utiliser les seeders :
```bash
php artisan db:seed
```
**8\. Démarrer l'environnement de développement**

Pour démarrer l'environnement de développement, vous pouvez utiliser cette commande. Elle va démarrer un serveur local et surveiller les changements dans les fichiers :
```bash
npm run dev
```
**9\. Configurer le fichier .env**

Copiez le fichier .env.example en .env pour configurer les variables d'environnement de votre application (comme les paramètres de base de données, les clés API, etc.) :
```bash
copy .env.example .env
```
N'oubliez pas de modifier le fichier .env en fonction de votre environnement local (par exemple, base de données, clé d'application).

**Lancer le Serveur**

Une fois toutes les étapes d'installation terminées, vous pouvez démarrer le serveur local pour voir l'application en action :
```bash
php artisan serve
```
Le serveur sera accessible à l'adresse <http://localhost:8000>.
c
