
# Corso Laravel @ Unipa

Per riportare il progetto allo stato di una giornata specifica del corso, spostarsi nel branch corrispondente, es:

`git checkout giorno-1`


Dopo la clonazinoe del repo, ricordarsi di inizializzare il progetto:

```shell
# installazione dipendenze composer
composer install

# installazione dipendenze npm
npm install

# copia del template delle variabili d'ambiente
cp .env.example .env

# generazione della chiave di cifratura dell'applicazione
php artisan key:generate

# migrazione del database
php artisan migrate
```

## Giorno 1 - 01/10/2025

`git checkout giorno-1`

- Installazione ambiente
- Struttura del progetto
- Primi passi con route, controller, view e model.

## Giorno 2 - 01/10/2025

`git checkout giorno-2`

- Mutator e Accessor
- CRUD sul modello Product
- CSRF
- Model Guarding e MassAssignmentException
- Layout blade
- Request e Validation
- Named routes
- Model binding
- Route groups
- Authentication
- Authorization con Guard
