<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="vg_supports"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('vg_supports.update', $vg_support) }}" method="POST">
                @csrf
                @method('put')
                <h1>Edition d'un support de Jeu Vidéo</h1>
                <hr/>

                <div class="w-full flex inline-flex justify-between mb-4 gap-4">
                    <div class="w-2/4">
                        <x-form.label for="label" block required>Nom du support</x-form.label>
                        <x-form.input name="label" placeholder="Ordinateur" value="{{ old('label', $vg_support->label) }}"/>
                    </div>
                    <div class="w-1/8">
                        <x-form.label for="alias" block required>Alias</x-form.label>
                        <x-form.input name="alias" placeholder="PC" value="{{ old('alias', $vg_support->alias) }}"/>
                    </div>
                    <div class="w-1/4">
                        <x-form.label for="date_released" block required>Date de sortie</x-form.label>
                        <x-form.date name="date_released" type="date_released" value="{{ old('date_released', $vg_support->date_released) }}"/>
                    </div>
                    <div class="w-1/8">
                        <x-form.label for="price" block>Prix d'achat (€)</x-form.label>
                        <x-form.input name="price" placeholder="300" value="{{ old('price', $vg_support->price) }}"/>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <x-form.btn type="submit">Modifier le support</x-form.btn>
                    <x-form.cancel href="{{ route('vg_supports.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
