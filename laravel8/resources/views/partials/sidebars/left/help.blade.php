<div class="sidebar-content" id="left-sidebar-help">
    <p><x-svg.help class="icon-sm text-green-400"/> Simuler un bénéfice</p>
    <div id="ls-help-benefit" class="w-full px-4">
        <div class="flex flex-col w-full">
            <div class="pb-2">
                <x-Form.Checkbox name="ls_benefit_commission">{{ old('commission')? 'checked' : '' }}</x-Form.Checkbox>
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

    <p class="ls_title"><x-svg.help class="icon-sm text-green-400"/> Calcul de réduction (%)</p>
    <span class="text-sm italic text-orange-600">(Prix réduit / prix) * 100</span>
    <div id="ls-help-discount" class="w-full px-4 gap-2">
        <div class="flex flex-col w-full gap-2">
            <div class="flex inline-flex gap-2">
                <div class="flex flex-col">
                    <x-Form.Label for="ls-discount-price" block>Prix original</x-Form.Label>
                    <x-Form.Input name="ls-discount_price" id="ls-discount-price" placeholder="100"/>
                </div>
                <div class="flex flex-col">
                    <x-Form.Label for="ls-discount-sum" block>Réduction (en €)</x-Form.Label>
                    <x-Form.Input name="ls-discount_sum" id="ls-discount-sum" placeholder="25"/>
                </div>
            </div>
            <x-Form.Btn id="ls-simulate-discount" type="submit" onClick="lsDiscountHelp()">Simuler</x-Form.Btn>
        </div>
        
        <div id="ls-discount-results-percent" class="pt-8 flex justify-center text-2xl text-green-400">
        </div>
    </div>

    <p class="ls_title"><x-svg.euro class="icon-sm text-green-400"/> Convertisseur $ -> €</p>
    <div id="ls-help-convert" class="w-full px-4 mb-4 flex inline-flex gap-2">
        <x-Form.Input name="ls_convert_text" placeholder="30 $" onChange="lsConvert()"/>
        <x-Form.Input readonly name="ls_convert_result" placeholder="28.4442 €"/>
    </div>

    <p class="ls_title"><x-svg.cmd class="icon-sm text-purple-400"/> Lancement de scripts</p>
    <x-Form.Btn color="warm_gray" id="ls-link-publishers" class="inline-flex text-xs gap-2" type="submit" onClick="lsLinkPublishers()">
        <x-svg.book class="icon-xs"/>
        Lier produits & Maisons d'éditions
    </x-Form.Btn>
</div>