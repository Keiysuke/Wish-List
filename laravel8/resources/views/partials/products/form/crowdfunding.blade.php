<div>
    <h1 class="text-green-500">Projet participatif associé</h1>
    <hr class="border-green-500"/>

    <div class="flex gap-4 mb-4">
        <div class="w-1/3">
            <x-Form.Label for="project_name" block>Nom du projet</x-Form.Label>
            <x-Form.Input name="project_name" placeholder="Nom du projet participatif" value="{{ old('project_name') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="crowdfunding_website_id" block>Site web</x-Form.Label>
            <select name="crowdfunding_website_id" class="form-input w-full">
                <option value="">Sélectionner un site web</option>
                @foreach($websites as $website)
                    @if($website->is_crowdfunding)
                        <option value="{{ $website->id }}" @if(old('crowdfunding_website_id') == $website->id) selected @endif>{{ $website->label }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="state_id" block>Avancée du projet</x-Form.Label>
            <select name="state_id" class="form-input w-full">
                @foreach($crowdfundingStates as $state)
                    <option value="{{ $state->id }}" @if(old('state_id') == $state->id) selected @endif>{{ $state->label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="flex gap-4 mb-4">
        <div class="w-1/3">
            <x-Form.Label for="project_url" block>URL du projet</x-Form.Label>
            <x-Form.Input name="project_url" placeholder="https://kickstarter.com/..." value="{{ old('project_url') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="goal_amount" block>Montant visé (€)</x-Form.Label>
            <x-Form.Input name="goal_amount" placeholder="10000" value="{{ old('goal_amount') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="current_amount" block>Montant atteint (€)</x-Form.Label>
            <x-Form.Input name="current_amount" placeholder="5000" value="{{ old('current_amount') }}"/>
        </div>
    </div>
    <div class="flex gap-4 mb-4">
        <div class="w-1/3">
            <x-Form.Label for="start_date" block>Date de début</x-Form.Label>
            <x-Form.Date name="start_date" value="{{ old('start_date') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="end_date" block>Date de fin</x-Form.Label>
            <x-Form.Date name="end_date" value="{{ old('end_date') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="shipping_date" block>Date d'envoi des produits</x-Form.Label>
            <x-Form.Date name="shipping_date" value="{{ old('shipping_date') }}"/>
        </div>
    </div>
</div>
