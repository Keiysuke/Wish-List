//Retourne le texte sélectionné
window.setClipboard = function(value) {
    var tempInput = document.createElement("input")
    tempInput.style = "position: absolute; left: -1000px; top: -1000px"
    tempInput.value = value
    document.body.appendChild(tempInput)
    tempInput.select()
    document.execCommand('copy')
    document.body.removeChild(tempInput)
    notyfJS('Le lien du dossier a été copié', 'success')
}