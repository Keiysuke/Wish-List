<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="websites"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <form class="bg-white rounded px-8 pt-2 pb-8 mb-4" action="{{ route('websites.update', $website->id) }}" method="POST">
                @csrf
                @method('put')
                <h1>Edition de site</h1>
                <hr/>

                <div class="flex gap-4 mb-4">
                    <div class="w-9/12">
                        <x-Form.Label for="label" block required>Nom du site</x-Form.Label>
                        <x-Form.Input name="label" placeholder="Nom du site" value="{{ old('label', $website->label) }}"/>
                    </div>
                    <div class="flex w-3/12 justify-around">
                        <div class="pt-9">
                            <x-Form.Checkbox name="can_sell">{{ old('can_sell', $website->can_sell)? 'checked' : '' }}</x-Form.Checkbox>
                            <x-Form.Label class="ml-1" for="can-sell">de vente ?</x-Form.Label>
                        </div>
                        <div class="pt-9">
                            <x-Form.Checkbox class="mr-1" name="is_vg">{{ old('is_vg', $website->is_vg)? 'checked' : '' }}</x-Form.Checkbox>
                            <x-Form.Label class="ml-1" for="is-vg">de JV ?</x-Form.Label>
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
