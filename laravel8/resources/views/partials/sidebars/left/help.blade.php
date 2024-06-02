<div class="sidebar-content" id="left-sidebar-help">
    <p><x-svg.help class="icon-sm text-green-400"/> Simuler un bénéfice</p>
    <div id="ls-help-benefit" class="w-full px-4">
        <div class="flex flex-col w-full">
            <div class="pb-2">
                <x-Form.Checkbox class="mr-1" name="ls_benefit_commission">{{ old('commission')? 'checked' : '' }}</x-Form.Checkbox>
                <x-Form.Label class="ml-1" for="ls-benefit-commission">Commission ?</x-Form.Label>
            </div>
        </div>
        <div class="flex flex-col w-full gap-2">
            <div class="flex inline-flex gap-2">
                <div class="flex flex-col">
                    <x-Form.Label for="ls-benefit-payed" block>Acheté à</x-Form.Label>
                    <x-Form.Input name="ls_benefit_payed" id="ls-benefit-payed" placeholder="15"/>
                </div>
                <div class="flex flex-col">
                    <x-Form.Label for="ls-benefit-sold" block>Vendu à</x-Form.Label>
                    <x-Form.Input name="ls_benefit_sold" id="ls-benefit-sold" placeholder="30"/>
                </div>
            </div>
            <x-Form.Btn id="ls-simulate-benefit" type="submit" onClick="lsBenefitHelp()">Simuler</x-Form.Btn>
        </div>
        
        <div id="ls-benefit-results-benef" class="pt-8 flex justify-center text-2xl">
        </div>
    </div>

    <p class="ls_title mt-4"><x-svg.euro class="icon-sm text-green-400"/> Convertisseur $ -> €</p>
    <div id="ls_help_convert" class="w-full px-4 flex inline-flex gap-2">
        <x-Form.Input name="ls_convert_text" placeholder="30 $" onChange="document.getElementById('ls_convert_result').value = (this.value * 0.94814).toFixed(4);"/>
        <x-Form.Input readonly name="ls_convert_result" placeholder="28.4442 €"/>
    </div>
</div>