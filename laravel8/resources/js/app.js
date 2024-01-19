require('./bootstrap');

require('alpinejs');

window.addEventListeners = function(element, events, handler) {
    if (!Array.isArray(events)) {
        console.error('Les types d\'événements doivent être fournis sous forme de tableau.');
        return;
    }

    events.forEach(function(eventType) {
        element.addEventListener(eventType, handler);
    });
}

window.scrollDown = function(e) {
    e.scrollTop = e.scrollHeight;
}