<div class="flex flex-col gap-4 mb-4">
    <div class="text-center font-bold italic text-xl">Cosmétiques</div>
    @foreach ($liches as $liche)
        <x-sidebars.datas.cosmetic :cosmetic="$liche->cosmetic"/>
    @endforeach
    <div class="text-center font-bold italic text-xl">Warframes</div>
    @foreach ($progenitors as $progenitor)
        <span class="flex inline-flex justify-between"><x-sidebars.datas.weapon :weapon="$progenitor->warframe" type/></span>
    @endforeach
</div>