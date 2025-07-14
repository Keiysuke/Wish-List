<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="vg_developers"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('vg_developers.store') }}" method="POST">
                @csrf
                <h1>Création d'un Studio de développement (JV)</h1>
                <hr/>

                <div class="w-full flex inline-flex justify-between mb-4 gap-4">
                    <div class="w-3/4">
                        <div class="relative flex inline-flex justify-between w-full">
                            <x-Form.Label for="label" block required>Studio de développement</x-Form.Label>
                            <x-svg.search class="icon-xs cursor-pointer" onClick="webSearch('label')"/>
                        </div>
                        <x-Form.Input name="label" placeholder="Naughty Dog" value="{{ old('label') }}"/>
                    </div>
                    <div class="w-1/4">
                        <x-Form.Label for="year-created" block required>Année de création</x-Form.Label>
                        <x-Form.Input name="year_created" placeholder="2000" value="{{ old('year_created') }}"/>
                    </div>
                </div>
                <div class="my-4">
                    <x-Form.Label for="description" block>Description</x-Form.Label>
                    <x-Form.Textarea name="description">{{ old('description') }}</x-Form.Textarea>
                </div>

                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Ajouter le studio</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('vg_developers.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
