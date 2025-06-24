<div>
    <h1 class="text-green-500">Projet participatif associé</h1>
    <hr class="border-green-500"/>

    <div class="flex gap-4 mb-4">
        <div class="w-1/3">
            <x-Form.Label for="crowdfunding_project_name" block>Nom du projet</x-Form.Label>
            <x-Form.Input name="crowdfunding_project_name" placeholder="Nom du projet participatif" value="{{ old('crowdfunding_project_name') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="crowdfunding_project_url" block>URL du projet</x-Form.Label>
            <x-Form.Input name="crowdfunding_project_url" placeholder="https://kickstarter.com/..." value="{{ old('crowdfunding_project_url') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="crowdfunding_goal_amount" block>Montant visé (€)</x-Form.Label>
            <x-Form.Input name="crowdfunding_goal_amount" placeholder="10000" value="{{ old('crowdfunding_goal_amount') }}"/>
        </div>
    </div>
    <div class="flex gap-4 mb-4">
        <div class="w-1/3">
            <x-Form.Label for="crowdfunding_current_amount" block>Montant atteint (€)</x-Form.Label>
            <x-Form.Input name="crowdfunding_current_amount" placeholder="5000" value="{{ old('crowdfunding_current_amount') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="crowdfunding_start_date" block>Date de début</x-Form.Label>
            <x-Form.Date name="crowdfunding_start_date" value="{{ old('crowdfunding_start_date') }}"/>
        </div>
        <div class="w-1/3">
            <x-Form.Label for="crowdfunding_end_date" block>Date de fin</x-Form.Label>
            <x-Form.Date name="crowdfunding_end_date" value="{{ old('crowdfunding_end_date') }}"/>
        </div>
    </div>
    <div class="flex gap-4 mb-4">
        <div class="w-1/3">
            <x-Form.Label for="crowdfunding_status_id" block>Avancée du projet</x-Form.Label>
            <select name="crowdfunding_status_id" class="form-input w-full">
                @foreach($crowdfundingStates as $status)
                    <option value="{{ $status->id }}" @if(old('crowdfunding_status_id') == $status->id) selected @endif>{{ $status->label }}</option>
                @endforeach
            </select>
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
    </div>
</div>
