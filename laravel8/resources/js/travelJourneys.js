(function() {
    /** 
     * Ajoute des écouteurs sur les options dynamiques 
     * @param {event} event - évènement cliqué
    */
    setListeners = function(){
        for(const el of document.getElementsByClassName('travel-step-city')) el.addEventListener('change', handleCityChange)
        for(const el of document.getElementsByClassName('dynamic-selected-travel-step')) el.addEventListener('change', setSelectData)
        for(const el of document.getElementsByClassName('dynamic-value-travel-step')) el.addEventListener('change', setValueData)
    }

    /** 
     * Ajoute une nouvelle étape
     * @param {event} event - évènement cliqué
    */
    getSteps = function(event){
        event.preventDefault()
        for(let i = 0; i < document.getElementById('travel-step-nb-to-add').value; i++){
            let nb = document.getElementById('max-nb-travel-steps').value++
            let userId = document.getElementById('user-id').value
            getFetch('user/' + userId + '/travel_journeys/steps/' + nb)
            .then(res => {
                document.getElementById('all-travel-steps').innerHTML += res.html
            }).then(() => {
                setListeners()
            })
        }
    }

    /** 
     * Met à jour l'affichage lorsque l'on sélectionne une ville dans la liste
     * @param {event} event - évènement cliqué
    */
    handleCityChange = function(event){
        event.preventDefault()
        const nb = event.target.dataset.nb
        const nbStep = parseInt(nb, 10) + 1
        const select = document.getElementById('travel-step-city-id-' + nb)
        const cityName = select.options[select.selectedIndex].text
        
        document.getElementById('travel-step-name-' + nb).innerHTML = nbStep + ' - Arrêt à ' + cityName
    }

    document.getElementById('add-travel-step').addEventListener('click', getSteps)
    for(const el of document.getElementsByName('add-travel-step-products')) el.addEventListener('click', function(event) {
        event.preventDefault()
        getStepProducts(event, event.target.dataset.step)
    })
    setListeners()
})()
