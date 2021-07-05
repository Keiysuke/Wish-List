<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="websites"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('websites.store') }}" method="POST">
                @csrf
                <h1>Création d'un site</h1>
                <hr/>

                <div class="flex gap-4 mb-4">
                    <div class="w-10/12">
                        <x-form.label for="label" block required>Nom du site</x-form.label>
                        <x-form.input name="label" placeholder="Nom du site" value="{{ old('label') }}"/>
                    </div>
                    <div class="flex w-2/12 justify-center">
                        <div class="pt-9">
                            <x-form.checkbox class="mr-1" name="can_sell">{{ old('can_sell')? 'checked' : '' }}</x-form.checkbox>
                            <x-form.label class="ml-1" for="can_sell">Site de vente ?</x-form.label>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <x-form.label for="url" block required>Url</x-form.label>
                    <x-form.input name="url" placeholder="Url" value="{{ old('url') }}"/>
                </div>
                <div class="flex items-center justify-between">
                    <x-form.btn type="submit">Ajouter le site</x-form.btn>
                    <x-form.cancel href="{{ route('websites.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
