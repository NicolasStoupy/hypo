function toggleAssignment(contentId) {
    // Sélectionne le contenu avec l'ID passé en paramètre et change son affichage
    var content = document.getElementById(contentId);
    content.style.display = content.style.display === "none" ? "block" : "none";
}
