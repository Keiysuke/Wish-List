<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website;

class CrowdfundingSeeder extends Seeder
{
    public function run()
    {
        // Créer ou récupérer le site Kickstarter
        $kickstarter = Website::firstOrNew(['label' => 'Kickstarter']);
        $kickstarter->is_crowdfunding = 1;
        $kickstarter->save();

        \App\Models\CrowdfundingState::create(['label' => 'Nouveau']);
        \App\Models\CrowdfundingState::create(['label' => 'Financement en cours']);
        \App\Models\CrowdfundingState::create(['label' => 'Financement terminé']);
        \App\Models\CrowdfundingState::create(['label' => 'Envoi des produits']);
        \App\Models\CrowdfundingState::create(['label' => 'Terminé']);
    }
}
