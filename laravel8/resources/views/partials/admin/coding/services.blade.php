<div class="wrap_h1 mt-8">
    <h1>Services & Models</h1>
    <x-svg.big.cmd class="icon-lg"/>
</div>

<div class="flex flex-col gap-8">
    <h3 class="my-0">1. UtilsController</h3>

    <x-Window.Coding class="w-10/12" title="Lier jeu PS+ avec produit" major="createProductFromPsPlus | linkVgToProduct">
        <x-Window.Comment>Créé ou lie un produit au jeu vidéo & créé une offre PS Store & un achat pour l'utilisateur</x-Window.Comment><br />
        <x-Window.Static name="UtilsController" method="createProductFromPsPlus"/>(<x-Window.Var var="videoGame"/>, 1, 2025)
        <br />
        <br />
        <x-Window.Comment>Lie un produit au jeu vidéo & support fournis</x-Window.Comment><br />
        <x-Window.Static name="UtilsController" method="linkVgToProduct"/>(<x-Window.Var var="videoGameId"/>, <x-Window.Var var="vgSupportId"/>)
    </x-Window.Coding>

    <h3 class="my-0">2. Mes Models</h3>

    <x-Window.Coding class="w-10/12" title="Propriété dynamique">
        <x-Window.Function public name="address"/><br />
        <div class="ml-4">
            <x-Window.Return/> <x-Window.Var var="this"/>->street.", ".<x-Window.Var var="this"/>->city.", ".<x-Window.Var var="this"/>->cp;<br />
        </div>
        }
    </x-Window.Coding>

    <x-Window.Coding class="w-10/12" title="Label avec redirection" major="getStudioAsLink | getPublisherAsLink">
        { !! <x-Window.Var var="videoGame"/>-><x-Window.Keyword name="getStudioAsLink"/>() !! }<br />
        { !! <x-Window.Var var="Book"/>-><x-Window.Keyword name="getPublisherAsLink"/>() !! }<br />
    </x-Window.Coding>

    <h3 class="my-0">3. Mes Services</h3>

    <x-Window.Coding class="w-10/12" title="Lancer une recherche externe" major="SearchService | route 'externalSearch' => SearchController::externalSearch">
        <x-Window.Static name="MySearch" method="getLink"/>('pictures', <x-Window.Var var="search"/>)
    </x-Window.Coding>

    <x-Window.Coding kind="PHP" class="w-10/12" title="Partager un élément (liste, produit...) à un ami" major="ShareController | share | ShareProduct">
        <x-Window.Function public name="shareItem"><x-Window.Var var="type"/> = 'list'</x-Window.Function><br />
        <div class="ml-4">
            <x-Window.Keyword name="switch"/>(<x-Window.Var var="type"/>) {<br />
                <div class="ml-8">
                    <x-Window.Keyword name="case"/> 'list' : <x-Window.Var var="friend"/>-><x-Window.Keyword name="notify"/>(<x-Window.New name="ShareList"/>(<x-Window.Var var="user"/>, <x-Window.Static name="Listing" method="find"/>(<x-Window.Var var="id"/>)));<br />
                    <x-Window.Keyword name="break"/>;<br />
                </div>
            }<br />
        </div>
    </x-Window.Coding>
</div>