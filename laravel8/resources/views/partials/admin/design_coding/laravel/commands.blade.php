<div class="wrap_h1 mt-8">
    <h1>Commandes utiles</h1>
    <x-svg.big.cmd class="icon-lg"/>
</div>

<x-admin.help.list_helpers>
    <a href="https://blog.enguehard.info/laravel-quelques-commandes-artisan/" class="link">Commandes artisan</a>
</x-admin.help.list_helpers>

<h3 class="mt-0">0. Commandes diverses</h3>
<div class="grid grid-cols-1 gap-4">
    <div>Créer une commande dans le dossier /App/Console/Commands/ : <span class="italic text-sm">php artisan make:command nomDeLaCommande</span></div>
    <div>Lister les routes définies : <span class="italic text-sm">php artisan route:list</span></div>
    <div>Afficher l'environnement actuel : <span class="italic text-sm">php artisan env</span></div>
    <div>Mettre le site en ligne : <span class="italic text-sm">php artisan up</span></div>
    <div>Mettre le site en maintenance : <span class="italic text-sm">php artisan down</span></div>
    <div>Avoir une citation : <span class="italic text-sm">php artisan inspire</span></div>
</div>

<h3>1. Gestion des migrations</h3>
<div class="grid grid-cols-1 gap-4">
    <div>L'installer : <span class="italic text-sm">php artisan migrate:install</span></div>
    <div>Créer une migration : <span class="italic text-sm">php artisan make:migration ma_migration</span></div>
    <div>Modifier une table existante : <span class="italic text-sm">php artisan make:migration add_user_id_to_purchases --table=purchases</span></div>
    <div>Lancer les migrations : <span class="italic text-sm">php artisan migrate</span></div>
    <div>Annuler X migrations : <span class="italic text-sm">php artisan migrate:rollback --step=X</span></div>
    <div>Annuler mais relancer les migrations : <span class="italic text-sm">php artisan migrate:refresh</span></div>
</div>

<h3>2. Gestion de Ressources</h3>
<div class="grid grid-cols-1 gap-4">
    <div>Création de modèle, controller et migration : <span class="italic text-sm">php artisan make:model monModel -mcr</span></div>
    <div>Créer la migration & son modèle : <span class="italic text-sm">php artisan make:model Emojis --migration</span></div>
    <div>Créer un contrôleur : <span class="italic text-sm">php artisan make:controller EmojiController --ressource</span></div>
    <div>Création d'un Seeder : <span class="italic text-sm">php artisan make:seeder Emojis</span></div>
    <div>Lancer un peuplement : <span class="italic text-sm">php artisan db:seed --class=EmojisSeeder</span></div>
    <div class="flex inline-flex gap-1"><x-svg.warning class="icon-sm" color="orange"/>Repeupler entièrement : <span class="italic text-sm">php artisan migrate:fresh --seed</span></div>
</div>

<h3>3. Gestion des fichiers CSS/JS </h3>
<div class="grid grid-cols-1 gap-4">
    <div>Installer le framework CSS pour utiliser webpack.mix.js: <span class="italic text-sm">npm install</span></div>
    <div>Recompiler le JS/CSS : <span class="italic text-sm">npm run dev/watch</span></div>
</div>

<h3>4. Processus de cache recommandé</h3>
<div class="grid grid-cols-4 gap-4">
    <span>php artisan optimize:clear</span>
    <span>php artisan config:clear</span>
    <span>php artisan route:clear</span>
    <span>php artisan view:clear</span>
    <span>php artisan config:cache</span>
    <span>php artisan route:cache</span>
    <span>php artisan view:cache</span>
    <span>php artisan optimize</span>
</div>

<h3>4. Vider le cache</h3>
<div class="grid grid-cols-1 gap-4">
    <div>Vider le cache de configuration : <span class="italic text-sm">php artisan config:cache</span></div>
    <div>Recharger les fichiers de configuration : <span class="italic text-sm">php artisan config:clear</span></div>
    <div>Régénérer le cache des routes (après modification de ces dernières) : <span class="italic text-sm">php artisan route:cache</span></div>
    <div>Recalculer ses routes : <span class="italic text-sm">php artisan route:clear</span></div>
    <div>Régénérer le cache des vues : <span class="italic text-sm">php artisan view:cache</span></div>
    <div>Recompiler ses vues : <span class="italic text-sm">php artisan view:clear</span></div>
    <div>Vider le cache de l'application : <span class="italic text-sm">php artisan cache:clear</span></div>
    <div>Recompiler les classes (si de nouvelles ou que le fichier <b>composer.json</b> a été modifié) : <span class="italic text-sm">composer dump-autoload</span></div>
    <div>Efface tous les caches : <span class="italic text-sm">php artisan optimize:clear</span></div>
    <div>Redémarrer les workers de la file d'attente : <span class="italic text-sm">php artisan queue:restart</span></div>
</div>
