require('./bootstrap')

require('alpinejs')

window.addEventListeners = function(element, events, handler) {
    if (!Array.isArray(events)) {
        console.error('Les types d\'événements doivent être fournis sous forme de tableau.')
        return
    }

    events.forEach(function(eventType) {
        element.addEventListener(eventType, handler)
    })
}

window.scrollDown = function(e) {
    e.scrollTop = e.scrollHeight
}

window.riseIcon = function(event, kind, v) {
    getFetch('render_icon/' + (v ? 'un' : '') + kind)
    .then(res => {
        const icon = document.createElement('div')
        icon.classList.add('animated-icon')
        icon.style.scale = 3
        icon.innerHTML = res.html

        // On positionne l'icône à l'endroit du clic
        icon.style.left = event.clientX + window.scrollX + 'px'
        icon.style.top = event.clientY + window.scrollY + 'px'
        document.getElementById('top-page').appendChild(icon)
        
        // On upprimee l'icône après l'animation
        icon.addEventListener('animationend', () => {
            icon.remove()
        })
    }).catch(error => notyfJS('Erreur lors de la récupération de l\'icône: ' + error, 'error'))
}

window.onload = function() {
    //Allows to show nb chars from an input with the showNbChars dataset property that refers to an input id
    Array.from(document.getElementsByClassName('show-nb-chars')).forEach(e => {
        const id = e.dataset.nbChars
        const el = document.getElementById(id)
        document.getElementById('show-nb-chars-' + id).innerHTML = '(' + el.value.length + ' caractères)'
        el.addEventListener('input', (el) => {
            document.getElementById('show-nb-chars-' + id).innerHTML = '(' + el.target.value.length + ' caractères)'
        })
    })
}

window.share = function (id, type) {
    event.stopPropagation()
    let friends = Array()
    Array.from(document.querySelectorAll('[name^="share_friend_"]')).forEach(el => {
        if (el.checked) friends.push(parseInt(el.dataset.friendId))
    })
    if (friends.length === 0) {
        notyfJS('Veuillez sélectionner au moins l\'un de vos amis', 'error')
        return
    }
    myFetch('http://localhost/00%20-%20API/products-managing/laravel8/public/share', { method: 'post', csrf: true }, {
        id: parseInt(id),
        type: type,
        friends: friends,
    }).then(response => {
        if (response.ok) return response.json()
    }).then(res => {
        myNotyf(res)
        if (res.success) {
            toggleShare(type)
        }
    })
}

window.toggleShare = function (type) {
    if (event) event.stopPropagation()
    document.getElementById('content-share-' + type).classList.toggle('flex')
    document.getElementById('content-share-' + type).classList.toggle('hidden')
    document.getElementById('main').classList.toggle('pointer-events-none')
}

window.showShare = function (id, type) {
    getFetch('user/friends/share/' + type + '/' + id)
        .then(res => {
            if (res.success) {
                document.getElementById('content-share-' + type).innerHTML = res.html
                toggleShare(type)
            }
        })
}

/** 
 * Met à jour les données dynamiques de l'objet sélectionné
*/
window.setSelectData = function(){
    const e = this
    for(const opt of e.options) {
        if(e.value == opt.value) document.getElementById(e.id+'_'+opt.value).setAttribute('selected', 'selected')
        else document.getElementById(e.id+'_'+opt.value).removeAttribute('selected')
    }
}

window.setValueData = function(){
    const e = this
    document.getElementById(e.id).setAttribute('value', e.value)
}

window.webSearch = function(search, website = 'google') {
    const idSearch = search.replace('_', '-')
    if(website === 'google') {
        window.open('https://www.google.com/search?q=' + encodeURIComponent(document.getElementById(idSearch).value), '_blank');
    }
}