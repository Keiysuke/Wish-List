<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="vg_supports"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('vg_supports.update', $vgSupport) }}" method="POST">
                @csrf
                @method('put')
                <div class="relative flex border-b-2 mb-4">
                    <h1>Edition d'un support de Jeu Vidéo</h1>
                    <div class="absolute right-0">
                        <a title="Créer un support" href="{{ route('vg_supports.create') }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                </div>

                <div class="w-full flex inline-flex justify-between mb-4 gap-4">
                    <div class="w-2/4">
                        <x-Form.Label for="label" block required>Nom du support</x-Form.Label>
                        <x-Form.Input name="label" placeholder="Ordinateur" value="{{ old('label', $vgSupport->label) }}"/>
                    </div>
                    <div class="w-1/8">
                        <x-Form.Label for="alias" block required>Alias</x-Form.Label>
                        <x-Form.Input name="alias" placeholder="PC" value="{{ old('alias', $vgSupport->alias) }}"/>
                    </div>
                    <div class="w-1/4">
                        <x-Form.Label for="date-released" block required>Date de sortie</x-Form.Label>
                        <x-Form.Date name="date_released" type="date_released" value="{{ old('date_released', $vgSupport->date_released) }}"/>
                    </div>
                    <div class="w-1/8">
                        <x-Form.Label for="price" block>Prix d'achat (€)</x-Form.Label>
                        <x-Form.Input name="price" placeholder="300" value="{{ old('price', $vgSupport->price) }}"/>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier le support</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('vg_supports.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
