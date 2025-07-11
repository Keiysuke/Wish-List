<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="websites"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <form class="bg-white rounded px-8 pt-2 pb-8 mb-4" action="{{ route('websites.update', $website->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="relative flex border-b-2 mb-4">
                    <h1>Edition du site</h1>
                    <div class="absolute right-0">
                        <a title="Créer un site" href="{{ route('websites.create') }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                </div>

                <div class="flex gap-4 mb-4">
                    <div class="w-8/12">
                        <x-Form.Label for="label" block required>Nom du site</x-Form.Label>
                        <x-Form.Input name="label" placeholder="Nom du site" value="{{ old('label', $website->label) }}"/>
                    </div>
                    <div class="flex w-4/12 justify-around">
                        <div class="pt-7">
                            <x-Form.Checkbox name="can_sell">{{ old('can_sell', $website->can_sell)? 'checked' : '' }}</x-Form.Checkbox>
                            <x-Form.Label class="ml-1" for="can-sell">de vente</x-Form.Label>
                        </div>
                        <div class="pt-7">
                            <x-Form.Checkbox class="mr-1" name="is_vg">{{ old('is_vg', $website->is_vg)? 'checked' : '' }}</x-Form.Checkbox>
                            <x-Form.Label class="ml-1" for="is-vg">de JV</x-Form.Label>
                        </div>
                        <div class="pt-7">
                            <x-Form.Checkbox class="mr-1" name="is_crowdfunding">{{ old('is_vg', $website->is_crowdfunding)? 'checked' : '' }}</x-Form.Checkbox>
                            <x-Form.Label class="ml-1" for="is-crowdfunding">Projets Associatifs</x-Form.Label>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <x-Form.Label for="url" block required>Url</x-Form.Label>
                    <x-Form.Input name="url" placeholder="Url" value="{{ old('url', $website->url) }}"/>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier le site</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('websites.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
