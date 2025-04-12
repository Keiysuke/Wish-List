(function () {
    toggle_filters = function () {
        document.getElementById('content-filters').classList.toggle('hidden')
    }

    Array.from(document.getElementsByClassName('delete-list')).forEach(e => {
        e.addEventListener('click', (e) => {
            const listId = e.target.dataset.list_id
            getFetch('lists/' + listId + '/destroy')
                .then(res => {
                    document.getElementById("list-" + res.deletedId).remove()
                    myNotyf(res)
                    if (res.list_id > 0) document.onload = getProducts(res.listId) //There's still one other list
                    else { //No more list for the user
                        document.getElementById("my-lists").innerHTML = "<span>Vous n'avez pas encore créé de liste...</span>"
                    }
                })
        })
    })

    leaveList = function (listId) {
        getFetch('lists/' + listId + '/leave')
            .then(res => {
                if (res.success) location.reload()
            })
    }

    downloadList = function (listId) {
        getFetch('lists/' + listId + '/download')
            .then(res => {
                const link = document.createElement('a')
                link.href = window.URL.createObjectURL(new Blob([res.blob]))
                link.setAttribute('download', res.filename + '.csv')
                document.body.appendChild(link)
                link.click()
            })
    }

    /**
     * Met à jour les mesages affichés dans le tchat
     * @param {object} res - Résultat contenant le html de la liste des messages
     */
    showMessages = function () {
        const listId = document.getElementById('list-selected').value
        getFetch('lists/' + listId + '/messages/get')
        .then(res => {
            toggleShowMessages(res)
        })
    }

    /**
     * Affiche/Cache la liste des messages
     * @param {object} res - Résultat contenant le html de la liste des messages
     */
    toggleShowMessages = function (res) {
        const contentMsg = document.getElementById('content-msg')
        const wrapListProducts = document.getElementById('wrap-list-products')
        if (res.htmlMsg !== null && res.shared_list) { //Il y a des messages
            contentMsg.innerHTML = res.htmlMsg
            contentMsg.classList.remove('hidden')
            wrapListProducts.classList.remove('extend')
            wrapListProducts.classList.add('with-msg')

            scrollDown(document.getElementById('v-list-msg'))
            maj_reactions()
        } else if (!contentMsg.classList.contains('hidden')) {
            wrapListProducts.classList.remove('with-msg')
            wrapListProducts.classList.add('extend')
            contentMsg.classList.add('hidden')
        }
    }

    /**
     * 
     * @param {int} listId - Identifiant de la liste
     * @param {int} productId - Identifiant du produit
     */
    toggleList = function (listId, productId) {
        myFetch('lists/products/toggle', { method: 'post', csrf: true }, {
            list_id: parseInt(listId),
            product_id: parseInt(productId),
            change_checked: true
        }).then(response => {
            if (response.ok) return response.json()
        }).then(res => {
            document.getElementById("list-" + listId + "-product-" + productId).remove()
            let nb_results = document.getElementById('nb-results').getAttribute('data-nb') - 1
            if (nb_results > 0) {
                document.getElementById('nb-results').setAttribute('data-nb', nb_results)
                document.getElementById('nb-results').innerHTML = nb_results + ' Résultat(s)'
                document.getElementById('total-price').innerHTML = 'Montant total : ' + res.total_best_price + ' €'
                document.getElementById('total-price').title = 'Montant réel : ' + res.total_price + ' €'
            } else getProducts(listId)
        })
    }

    /**
     * Récupère les produits d'une liste
     * @param {int} listId - Identifiant de la liste
     */
    getProducts = function (listId, pageChanged = false) {
        const oldListId = document.getElementById('list-selected').value
        if (oldListId == listId && !pageChanged) return

        myFetch('lists/' + listId + '/products/show', {method: 'post', csrf: true}, {
            user_id: parseInt(document.getElementById('user-id').value),
            page: document.getElementById('page').value,
        }).then(response => {
            if (response.ok) return response.json()
        }).then(products => {
            if (document.getElementById('list-selected').value != '' && document.getElementById('list-' + document.getElementById('list-selected').value) != undefined)
                document.getElementById('list-' + document.getElementById('list-selected').value).classList.toggle('selected')
            document.getElementById('list-selected').value = listId
            document.getElementById('list-' + listId).classList.toggle('selected')
            document.getElementById('content-results').innerHTML = products.html
            document.getElementById('btn-go-up').click();
            extendListMsg(true)
            toggleShowMessages(products)
        })
    }

    /**
     * Affiche les listes d'un utilisateur
     * @param {int} userId - Identifiant de l'utilisateur dont on affiche les listes
     */
    showLists = function (userId) {
        const oldUserId = document.getElementById('lists-user-id').value
        if (oldUserId == userId) return

        if (userId == 0) {
            document.getElementById('title-others-lists').classList.toggle('active')
            document.getElementById('title-my-lists').classList.toggle('active')
        } else {
            document.getElementById('title-others-lists').classList.remove('active')
            document.getElementById('title-my-lists').classList.add('active')
        }

        document.getElementById('lists-user-id').value = userId
        getFetch('lists/users/' + userId)
        .then(lists => {
            document.getElementById('wrap-lists').innerHTML = lists.html
            getProducts(lists.first_list_id)
        })
    }

    /**
     * Affiche la fenête d'édition d'un produit d'une liste
     * @param {int} listId - Identifiant de la liste
     * @param {int} productId - Identifiant du produit
     */
    showProductEdit = function (listId, productId) {
        getFetch('shared/lists/' + listId + '/products/' + productId + '/edit')
        .then(res => {
            if (res.success) {
                document.getElementById('content-edit-product-list').innerHTML = res.html
                document.getElementById('content-edit-product-list').classList.toggle('hidden')
                document.getElementById('content-edit-product-list').classList.toggle('flex')
                document.getElementById('main').classList.toggle('pointer-events-none')
            }
        })
    }

    /**
     * Edite le produit d'une liste
     * @param {int} listId - Identifiant de la liste
     * @param {int} productId - Identifiant du produit
     */
    editProductList = function (listId, productId) {
        event.stopPropagation()
        const oldNb = document.getElementById('edit-product-list-old-nb').value
        const nb = document.getElementById('edit-product-list-nb').value
        if (oldNb === nb) {
            notyfJS('Aucun changement apporté', 'success')
            return
        }
        myFetch('lists/products/toggle', { method: 'post', csrf: true }, {
            list_id: parseInt(listId),
            product_id: parseInt(productId),
            nb: nb,
        }).then(response => {
            if (response.ok) return response.json()
        }).then(res => {
            toggleEditProductList()
            notyfJS('Produit de la liste édité', 'success')
            getProducts(listId, true)
        })
    }

    toggleEditProductList = function() {
        document.getElementById('content-edit-product-list').classList.toggle('flex')
        document.getElementById('content-edit-product-list').classList.toggle('hidden')
        document.getElementById('main').classList.toggle('pointer-events-none')
    }

    // setInterval(showMessages, 5000)
})()
