<div class="sidebar_content" id="left_sidebar_help">
    <p><x-svg.help class="icon-sm text-green-400"/> Simuler un bénéfice</p>
    <div id="ls_help_benefit" class="w-full px-4">
        <div class="flex flex-col w-full">
            <div class="pb-2">
                <x-form.checkbox class="mr-1" name="ls_benefit_commission">{{ old('commission')? 'checked' : '' }}</x-form.checkbox>
                <x-form.label class="ml-1" for="ls_benefit_commission">Commission ?</x-form.label>
            </div>
        </div>
        <div class="flex flex-col w-full gap-2">
            <div class="flex inline-flex gap-2">
                <div class="flex flex-col">
                    <x-form.label for="ls_benefit_payed" block>Acheté à</x-form.label>
                    <x-form.input name="ls_benefit_payed" id="ls_benefit_payed" placeholder="15"/>
                </div>
                <div class="flex flex-col">
                    <x-form.label for="ls_benefit_sold" block>Vendu à</x-form.label>
                    <x-form.input name="ls_benefit_sold" id="ls_benefit_sold" placeholder="30"/>
                </div>
            </div>
            <x-form.btn id="ls_simulate_benefit" type="submit" onClick="ls_benefit_help()">Simuler</x-form.btn>
        </div>
        
        <div id="ls_benefit_results_benef" class="pt-8 flex justify-center text-2xl">
        </div>
    </div>

    <p class="ls_title mt-4"><x-svg.euro class="icon-sm text-green-400"/> Convertisseur $ -> €</p>
    <div id="ls_help_convert" class="w-full px-4 flex inline-flex gap-2">
        <x-form.input name="ls_convert_text" placeholder="30 $" onChange="document.querySelector('#ls_convert_result').value = (this.value * 0.94814).toFixed(4);"/>
        <x-form.input readonly name="ls_convert_result" placeholder="28.4442 €"/>
    </div>
</div>