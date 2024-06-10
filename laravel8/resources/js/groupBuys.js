(function() {
    /** 
     * Ajoute des écouteurs sur les options dynamiques 
     * @param {event} event - évènement cliqué
    */
    setListeners = function(){
        for(const el of document.getElementsByClassName('product-bought')) el.addEventListener('change', handleProductChange)
        for(const el of document.getElementsByClassName('dynamic-selected-product')) el.addEventListener('change', setSelectData)
    }

    /** 
     * Met à jour les données dynamiques du produit sélectionné
    */
    setSelectData = function(){
        const e = this
        for(const opt of e.options) {
            if(e.value == opt.value) document.getElementById(e.id+'_'+opt.value).setAttribute('selected', 'selected')
            else document.getElementById(e.id+'_'+opt.value).removeAttribute('selected')
        }
    }

    /** 
     * Ajoute un nouveau produit sélectionnable pour l'achat groupé
     * @param {event} event - évènement cliqué
    */
    getProducts = function(event){
        event.preventDefault()
        for(let i = 0; i < document.getElementById('product-nb-to-add').value; i++){
            let nb = document.getElementById('max-nb-products').value++
            let userId = document.getElementById('user-id').value
            getFetch('user/' + userId + '/group_buys/products/' + nb)
            .then(res => {
                document.getElementById('all-products-bought').innerHTML += res.html
            }).then(() => {
                setListeners()
            })
        }
    }
    
    /** 
     * Met à jour l'affichage lorsque l'on sélectionne un produit dans la liste
     * @param {event} event - évènement cliqué
    */
    handleProductChange = function(event){
        event.preventDefault()
        const product_id = event.target.value
        const nb = event.target.dataset.nb
        getFetch('products/' + product_id + '/picture')
        .then(res => {
            document.getElementById('img-product-bought-'+nb).src = res.html
            document.getElementById('product-link-'+nb).href = res.link
        })
        
        getProductDatas(product_id, nb)
    }

    /** 
     * Gère le moment où l'on affiche/ou non, un achat existant
     * @param {event} event - évènement cliqué
     * @param {string} nb - numéro de la ligne
    */
    handleExistingBuy = function(event, nb){
        if(event.checked){
            document.getElementById('product-bought-exists-'+nb).setAttribute('checked', true)
            document.getElementById('product-bought-purchase-'+nb).classList.remove('hidden')
            document.getElementById('product-bought-offer-'+nb).classList.add('hidden')
            document.getElementById('div-product-bought-nb-'+nb).classList.add('hidden')
            document.getElementById('product-bought-discount-'+nb).classList.add('hidden')
            document.getElementById('product-bought-customs-'+nb).classList.add('hidden')
        }else{
            document.getElementById('product-bought-exists-'+nb).removeAttribute('checked')
            document.getElementById('product-bought-purchase-'+nb).classList.add('hidden')
            document.getElementById('product-bought-offer-'+nb).classList.remove('hidden')
            document.getElementById('div-product-bought-nb-'+nb).classList.remove('hidden')
            document.getElementById('product-bought-discount-'+nb).classList.remove('hidden')
            document.getElementById('product-bought-customs-'+nb).classList.remove('hidden')
        }
    }

    /** 
     * Récupère les données (offres, achats existants) du produit passé
     * @param {int} productId - Identifiant du produit
     * @param {string} nb - numéro de la ligne
    */
    getProductDatas = function(productId, nb){
        getFetch('group_buys/offer/' + nb + '/product/' + productId + '/datas/')
        .then(res => {
            document.getElementById('product-bought-offer-'+nb).innerHTML = res.html.offers
            document.getElementById('product-bought-purchase-'+nb).innerHTML = res.html.purchases
        }).then(() => {
            setListeners()
        })
    }

    document.getElementById('add-product').addEventListener('click', getProducts)
    setListeners()
})()
