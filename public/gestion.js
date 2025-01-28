// Fonction pour afficher/masquer le contenu d'un événement
function toggleAssignment(contentId) {
    var content = document.getElementById(contentId);
    content.style.display = (content.style.display === "none") ? "block" : "none";
}

// Afficher le contenu du premier événement au chargement de la page
window.onload = function () {

    var evenementId = document.querySelector('[name="evenement_id_show"]').value;

    var contentId = "assignmentContent_" + evenementId;
    var content = document.getElementById(contentId);
    if (content) {
        content.style.display = "block";
    }
};
