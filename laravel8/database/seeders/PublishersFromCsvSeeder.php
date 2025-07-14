<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;
use App\Models\PublisherType;
use App\Models\Country;
use App\Models\City;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PublishersFromCsvSeeder extends Seeder
{
    public function run()
    {
        
        DB::table('publisher_types')->insertOrIgnore([
            [
                'id' => 1,
                'label' => 'book',
                'description' => 'Maison d\'édition de livres',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'label' => 'anime',
                'description' => 'Studio d\'animation',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'label' => 'boardgame',
                'description' => 'Maison d\'édition de jeux de société',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        
        // Ajout des villes issues du texte fourni
        $fr = Country::firstOrCreate(['name' => 'France', 'code' => 'FRA']);
        $uk = Country::firstOrCreate(['name' => 'Angleterre', 'code' => 'GBR']);
        City::firstOrCreate(['name' => 'Toulouse', 'country_id' => $fr->id]);
        City::firstOrCreate(['name' => 'Houdan', 'country_id' => $fr->id]);
        City::firstOrCreate(['name' => 'Montreuil', 'country_id' => $fr->id]);
        City::firstOrCreate(['name' => 'Paris 6e', 'country_id' => $fr->id]);
        City::firstOrCreate(['name' => 'Paris', 'country_id' => $fr->id]);
        City::firstOrCreate(['name' => 'Boulogne', 'country_id' => $fr->id]);
        City::firstOrCreate(['name' => 'Billezois', 'country_id' => $fr->id]);
        City::firstOrCreate(['name' => 'Sheffield', 'country_id' => $uk->id]);
        City::firstOrCreate(['name' => 'Londres', 'country_id' => $uk->id]);
        
        // Studios d'animation (ANIME)
        $country = Country::firstOrCreate(['name' => 'Japon', 'code' => 'JPN']);
        $city = City::firstOrCreate(['name' => 'Koganei', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Ghibli', 'url' => 'https://www.ghibli.jp/']);
        $this->createPublisher([
            'name' => 'Studio Ghibli',
            'description' => "Légendaire studio japonais connu pour ses chefs-d'œuvre poétiques.",
            'founded_year' => 1985,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'Emeryville', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Pixar', 'url' => 'https://www.pixar.com/']);
        $this->createPublisher([
            'name' => 'Pixar Animation Studios',
            'description' => "Pionnier de l'animation 3D, filiale de Disney.",
            'founded_year' => 1986,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'Burbank', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Disney Animation', 'url' => 'https://www.disneyanimation.com/']);
        $this->createPublisher([
            'name' => 'Walt Disney Animation Studios',
            'description' => "Studio emblématique à l'origine de l'âge d'or de l'animation.",
            'founded_year' => 1923,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'Glendale', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'DreamWorks', 'url' => 'https://www.dreamworks.com/animation']);
        $this->createPublisher([
            'name' => 'DreamWorks Animation',
            'description' => "Studio célèbre pour ses films divertissants et humoristiques.",
            'founded_year' => 1994,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'Hillsboro', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Laika', 'url' => 'https://www.laika.com/']);
        $this->createPublisher([
            'name' => 'Laika',
            'description' => "Spécialiste de l'animation en stop-motion avec une esthétique unique.",
            'founded_year' => 2005,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'Greenwich', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Blue Sky', 'url' => 'https://www.blueskystudios.com/']);
        $this->createPublisher([
            'name' => 'Blue Sky Studios',
            'description' => "Connu pour ses films en CGI, notamment L'Âge de glace.",
            'founded_year' => 1987,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'Santa Monica', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Illumination', 'url' => 'https://www.illumination.com/']);
        $this->createPublisher([
            'name' => 'Illumination Entertainment',
            'description' => "Filiale d'Universal, spécialisée dans les films à grand succès commercial.",
            'founded_year' => 2007,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'Royaume-Uni', 'code' => 'GBR']);
        $city = City::firstOrCreate(['name' => 'Bristol', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Aardman', 'url' => 'https://www.aardman.com/']);
        $this->createPublisher([
            'name' => 'Aardman Animations',
            'description' => "Studio britannique maître du stop-motion en pâte à modeler.",
            'founded_year' => 1972,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'Japon', 'code' => 'JPN']);
        $city = City::firstOrCreate(['name' => 'Tokyo', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'MAPPA', 'url' => 'https://mappa.co.jp/']);
        $this->createPublisher([
            'name' => 'MAPPA',
            'description' => "Studio japonais dynamique, connu pour ses animations modernes et intenses.",
            'founded_year' => 2011,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);
        $country = Country::firstOrCreate(['name' => 'Japon', 'code' => 'JPN']);
        $city = City::firstOrCreate(['name' => 'Tokyo', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Toei', 'url' => 'https://www.toei-anim.co.jp/']);
        $this->createPublisher([
            'name' => 'Toei Animation',
            'description' => "Un des plus anciens studios d'animation japonais, très influent dans l'univers des anime.",
            'founded_year' => 1948,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::ANIME,
        ]);

        // Maisons d'édition de jeux (BOARDGAME)
        $country = Country::firstOrCreate(['name' => 'France', 'code' => 'FRA']);
        $city = City::firstOrCreate(['name' => 'Guyancourt', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Asmodee', 'url' => 'https://corporate.asmodee.com/']);
        $this->createPublisher([
            'name' => 'Asmodee',
            'description' => "Un des plus grands éditeurs et distributeurs de jeux de société au monde.",
            'founded_year' => 1995,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'France', 'code' => 'FRA']);
        $city = City::firstOrCreate(['name' => 'Paris', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Days of Wonder', 'url' => 'https://www.daysofwonder.com/']);
        $this->createPublisher([
            'name' => 'Days of Wonder',
            'description' => "Éditeur spécialisé dans les jeux familiaux et de stratégie accessibles.",
            'founded_year' => 2002,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'Roseville', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Fantasy Flight', 'url' => 'https://www.fantasyflightgames.com/']);
        $this->createPublisher([
            'name' => 'Fantasy Flight Games',
            'description' => "Éditeur américain connu pour ses jeux immersifs et narratifs.",
            'founded_year' => 1995,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'Roseville', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Z-Man', 'url' => 'https://www.zmangames.com/']);
        $this->createPublisher([
            'name' => 'Z-Man Games',
            'description' => "Éditeur reconnu pour ses jeux innovants et collaboratifs.",
            'founded_year' => 1999,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'Allemagne', 'code' => 'DEU']);
        $city = City::firstOrCreate(['name' => 'Ravensburg', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Ravensburger', 'url' => 'https://www.ravensburger.com/']);
        $this->createPublisher([
            'name' => 'Ravensburger',
            'description' => "Éditeur allemand historique spécialisé dans les puzzles et les jeux familiaux.",
            'founded_year' => 1883,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'France', 'code' => 'FRA']);
        $city = City::firstOrCreate(['name' => 'Nancy', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'IELLO', 'url' => 'https://iellogames.com/']);
        $this->createPublisher([
            'name' => 'IELLO',
            'description' => "Maison d'édition française orientée vers les jeux familiaux et de stratégie légère.",
            'founded_year' => 2004,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'Belgique', 'code' => 'BEL']);
        $city = City::firstOrCreate(['name' => 'Bruxelles', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Repos', 'url' => 'https://reposproduction.com/']);
        $this->createPublisher([
            'name' => 'Repos Production',
            'description' => "Éditeur belge connu pour ses jeux de stratégie et d'ambiance.",
            'founded_year' => 2004,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'États-Unis', 'code' => 'USA']);
        $city = City::firstOrCreate(['name' => 'St. Louis', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Stonemaier', 'url' => 'https://stonemaiergames.com/']);
        $this->createPublisher([
            'name' => 'Stonemaier Games',
            'description' => "Éditeur indépendant réputé pour ses jeux de gestion hautement qualitatifs.",
            'founded_year' => 2012,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'France', 'code' => 'FRA']);
        $city = City::firstOrCreate(['name' => 'Toulon', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'Ludonaute', 'url' => 'https://www.ludonaute.fr/']);
        $this->createPublisher([
            'name' => 'Ludonaute',
            'description' => "Éditeur français centré sur des jeux narratifs et esthétiques.",
            'founded_year' => 2010,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
        $country = Country::firstOrCreate(['name' => 'République tchèque', 'code' => 'CZE']);
        $city = City::firstOrCreate(['name' => 'Brno', 'country_id' => $country->id]);
        $website = Website::firstOrCreate(['label' => 'CGE', 'url' => 'https://czechgames.com/']);
        $this->createPublisher([
            'name' => 'Czech Games Edition',
            'description' => "Éditeur tchèque reconnu pour ses jeux d'ambiance et de stratégie.",
            'founded_year' => 2007,
            'city_id' => $city->id,
            'website_id' => $website->id,
            'type_id' => PublisherType::BOARDGAME,
        ]);
    }


    private function createPublisher($data)
    {
        Publisher::firstOrCreate([
            'label' => $data['name'],
            'type_id' => $data['type_id'],
            'description' => $data['description'] ?? null,
            'founded_year' => $data['founded_year'] ?? null,
            'city_id' => $data['city_id'] ?? null,
            'website_id' => $data['website_id'],
        ]);
    }
}
