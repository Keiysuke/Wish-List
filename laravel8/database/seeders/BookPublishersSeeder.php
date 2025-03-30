<?php

namespace Database\Seeders;

use App\Models\BookPublisher;
use App\Models\Website;
use Illuminate\Database\Seeder;

class BookPublishersSeeder extends Seeder
{
    public function run()
    {
        BookPublisher::create([
            'label' => 'Third Editions', 
            'description' => "Vouée aux jeux vidéo créée par Mehdi El Kanafi et Nicolas Courcier. Ensemble, ils avaient déjà fondé en 2010 les éditions Console Syndrome, qui un an plus tard allaient être rachetées par Pix'n Love. Au cours des quatre années suivantes paraîtront plus de vingt livres qu'ils auront édités et souvent corédigés eux-mêmes : Zelda. Chronique d'une saga légendaire, Metal Gear Solid. Une œuvre culte de Hideo Kojima ou encore La Légende Final Fantasy VII.",
            'founded_year' => 2015,
            'country' => 'France (Toulouse)',
            'website_id' => Website::firstOrNew(['label' => 'Third Editions'])->id,
        ]);
        BookPublisher::create([
            'label' => 'Twinkle Editions', 
            'description' => "Maison d'édition éducative en ligne internationale fondée par Jonathan Seaton et Susie Seaton en 2010. Son siège est à Sheffield, en Angleterre. La maison d'édition propose plus de 900 000 ressources éducatives, dont 130 000 en accès libre et dans différentes langues.",
            'founded_year' => 2010,
            'country' => 'Angleterre (Sheffield)',
            'website_id' => Website::firstOrNew(['label' => 'Twinkle Editions'])->id,
        ]);
        BookPublisher::create([
            'label' => "Pix'n Love Editions", 
            'description' => "Cofondée en 2007 par Florent Gorges, Marc Pétronille et Sébastien Mirc. Elle est spécialisée dans la publication d'ouvrages liés à l'histoire des jeux vidéo. Elle édite des collections originales (Pix'n Love, L'Histoire de Nintendo, Les Cahiers du Jeu Vidéo, Les Grands noms du jeu vidéo, etc.) ainsi que des traductions de collections anglaises ou japonaises. Les Éditions Pix'n Love regroupent un effectif d'environ 50 pigistes et auteurs.",
            'founded_year' => 2007,
            'country' => 'France (Houdan)',
            'website_id' => Website::firstOrNew(['label' => "Pix'n Love Editions"])->id,
        ]);
    }
}
