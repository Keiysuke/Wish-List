<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="vg_developers"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('vg_developers.store') }}" method="POST">
                @csrf
                <h1>Création d'un Studio de développement (JV)</h1>
                <hr/>

                <div class="w-full flex inline-flex justify-between mb-4 gap-4">
                    <div class="w-3/4">
                        <x-form.label for="label" block required>Studio de développement</x-form.label>
                        <x-form.input name="label" placeholder="Naughty Dog" value="{{ old('label') }}"/>
                    </div>
                    <div class="w-1/4">
                        <x-form.label for="year_created" block required>Année de création</x-form.label>
                        <x-form.input name="year_created" placeholder="2000" value="{{ old('year_created') }}"/>
                    </div>
                </div>
                <div class="my-4">
                    <x-form.label for="description" block>Description</x-form.label>
                    <x-form.textarea name="description">{{ old('description') }}</x-form.textarea>
                </div>

                <div class="flex items-center justify-between">
                    <x-form.btn type="submit">Ajouter le studio</x-form.btn>
                    <x-form.cancel href="{{ route('vg_developers.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
