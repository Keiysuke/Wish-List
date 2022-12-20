<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="design"/>
        
        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>

            <div class="relative flex justify-center border-b-2 mb-4 gap-2">
                <h1>Liste des icônes SVG</h1>
                <x-svg.folder class="cursor icon-xs" title="Dossier des icônes SVG" onClick="setClipboard('{{ str_replace('\\', '/', public_path()) }}')"/>
            </div>

            <h3 class="underline font-bold mb-4">1. Les petites icônes ({{ count($icons['min']) }})</h3>
            <div class="grid grid-cols-8 gap-4">
                @foreach($icons['min'] as $icon)
                    <div class="grid justify-items-center">
                        <x-dynamic-component :component="$icon['component']" class="icon-sm" href="#"/>
                        <span class="text-sm">{{ $icon['name'] }}</span>
                    </div>
                @endforeach
            </div>

            <h3 class="underline font-bold mt-6 mb-4">2. Les grandes icônes ({{ count($icons['big']) }})</h3>
            <div class="grid grid-cols-8 gap-4">
                @foreach($icons['big'] as $icon)
                    <div class="grid justify-items-center">
                        <x-dynamic-component :component="$icon['component']" class="icon-lg" href="#"/>
                        <span class="text-sm">{{ $icon['name'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
