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
        const icon = document.createElement('div');
        icon.classList.add('animated-icon')
        icon.style.scale = 3;
        icon.innerHTML = res.html

        // On positionne l'icône à l'endroit du clic
        icon.style.left = event.clientX + window.scrollX + 'px';
        icon.style.top = event.clientY + window.scrollY + 'px';
        document.getElementById('top-page').appendChild(icon);
        
        // On upprimee l'icône après l'animation
        icon.addEventListener('animationend', () => {
            icon.remove();
        });
    }).catch(error => notyfJS('Erreur lors de la récupération de l\'icône: ' + error, 'error'));
}