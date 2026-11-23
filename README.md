# SkillSwap Campus — Projet Symfony 7 (Groupe 4)

**SkillSwap Campus** est une marketplace d'échange de compétences où étudiants et jeunes professionnels réservent des sessions de mentorat ou proposent leurs savoir-faire. Les échanges sont réglés par paiement simulé ou par portefeuille de crédits-temps (**1 heure enseignée = 1 heure réservée**).

## Stack technique

- **Backend** : Symfony 7.2, PHP 8.2+, Doctrine ORM, Twig, Security, Validator
- **Base de données** : MySQL / PostgreSQL
- **Frontend & UI** : Bootstrap 5, Stimulus, Chart.js
- **Bundles** : `VichUploaderBundle`, `KnpPaginatorBundle`

## Répartition de l'équipe et branches Git

| Membre | Périmètre principal | Entités gérées | Branche Git |
| :--- | :--- | :--- | :--- |
| **Ifaoui Malak** (Membre 1) | Authentification, sécurité et espace client | `User` (profils, rôles, sécurité) | `feature/auth` |
| **Imene Chaibi** (Membre 2) | Catalogue, compétences et parcours | `Skill`, `Offer`, `Availability`, `LearningPath` | `feature/catalogue` |
| **Med Rayen Chaabi** (Membre 3) | Transactions, réservations et crédits-temps | `Booking`, `Session`, `Wallet`, `Transaction` | `feature/booking` |
| **Seif Badrouchi** (Membre 4) | Administration, statistiques, gamification et UI | `Review`, `Badge`, Dashboard et Fixtures | `feature/admin-ui` |

## Installation locale

```bash
# 1. Installer les dépendances PHP
composer install

# 2. Configurer la base de données dans .env.local
cp .env .env.local
# Modifier DATABASE_URL dans .env.local

# 3. Créer la base de données et lancer les migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 4. Lancer le serveur local
symfony server:start
# ou : php -S 127.0.0.1:8000 -t public
```

## Workflow Git

- `main` : version stable (tags `v0.1-base`, `v0.5-mvp`, `v1.0-demo`)
- `develop` : branche d'intégration commune
- `feature/*` : une branche dédiée par membre avec Pull Request relue avant fusion dans `develop`

### Premier push vers GitHub (à exécuter une seule fois)

```bash
git push -u origin --all
git push origin --tags
```
