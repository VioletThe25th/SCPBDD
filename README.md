# Projet Administration et Base de données
### Projet SCPBDD, l'objectif sont les suivants :
 - Mettre en œuvre MySQL (Installer MySQL et remise à niveau, décrire l’architecture MySQL
    - Configurer les options du serveur à l’exécution
    - Activer et gérer les nombreux journaux du serveur
    - Réaliser des tâches courantes d’administration de base de données
    - Évaluer les types de données et jeux de caractères
    - Assimiler les concepts de verrouillage de données
    - Découvrir les différents moteurs de stockage disponibles
    - Définir et planifier des évènements de maintenance
    - Décrire les techniques de réglage des performances
    - Décrire les techniques de haute disponibilité
    - Dépanner les problèmes d’administration de base de données les plus courants

 Pour ce projet, nous avons choisis de créer un projet Laravel avec Laragon. L'objectif du projet est d'afficher des bases de donneés dans lequel nous pouvons voir des SCP, leur classe, le site dans lequel ils se trouvent ainsi que les employés des différents sites. 

1) Installation de Blueprint Laravel

Afin de créer automatiquement le différentes tables, les migrations, ainsi que les seeders, nous avons choisis d'installer Blueprint Laravel. Ce dernier est un outil nous permettant de générer tous les fichiers nécessaires au fonctionnement de la base de données grâce à un fichier `draft.yaml`.

Nous utilisons `composer` pour installer Blueprint. 

```bash
composer require --dev laravel-shift/blueprint
```
Blueprint suggère également d'installer le package `Laravel Test Assertions`, car les tests générés peuvent utiliser certaines des assertions supplémentaires et utiles fournies par ce package.

```bash
composer require --dev jasonmccreary/laravel-test-assertions
```

2) Ecriture du fichier Draft.yaml

L'intérêt de `Blueprint laravel` est de pouvoir intégrer un fichier `Draft.yaml` au répertoire `root` du projet.

Dans ce dernier, nous avons plusieurs informations à renseigner : 
- Les models
- Les controllers

Voici comme exemple le modèle de la table `site` :
```yaml
models:
   Site:
      name: varchar(55)
      latitude: decimal(2,9)
      longitude: decimal(2,9)
      adress: varchar(55)
```

Nous avons également ajouté au fichier une partie `controller` : 
```yaml
controller:
   Site:
    index:
      query: all:sites
      render: site.index with:sites
    create:
      render: site.create
    store:
      validate: site
      save: site
      flash: site.id
      redirect: site.index
    show:
      render: site.show with:site
    edit:
      render: site.edit with:site
    update:
      validate: site
      update: site
      flash: site.id
      redirect: site.index
    destroy:
      delete: site
      redirect: site.index
```

Ces deux parties suffisent pour créer un ``modèle``, un ``controller``, ainsi qu'un ``factory`` et une ``migration`` `site`. Des ``views`` vides sont également créés.

3) Peupler la base de données

Afin de peupler la base de données, nous avons modifié les fichiers `seeders` des différentes tables. Nous avons également ajouté les lignes suivantes au fichier `DatabaseSeeder.php` afin de lancer le seed des tables 

```php
\App\Models\User::factory(10)->create();

$this->call([
            SiteSeeder::class,
            ClasseSeeder::class,
            ScpSeeder::class,
            EmployeeSeeder::class
        ]);
```

Nous pouvons voir que nous créons également des utilisateurs fictifs grâce à la première ligne.

### Nous lions également les tables entre elles grâce à ces lignes (ici dans le fichier de migration scp par exemple):

```php
public function up()
{
   Schema::create('scps', function (Blueprint $table) {
      $table->id();
      $table->string('name', 55);
      $table->text('description');
      $table->timestamps();
      $table->unsignedBigInteger('site_id');
      $table->foreign('site_id')
               ->references('id')
               ->on('sites')
               ->onUpdate('cascade')
               ->onDelete('Cascade');
      $table->unsignedBigInteger('classe_id');
      $table->foreign('classe_id')
               ->references('id')
               ->on('classes')
               ->onUpdate('cascade')
               ->onDelete('cascade');
   });
}
```

Nous pouvons voir que nous avons lié la table `site` ainsi que la table `classe` à la table `scp`. 