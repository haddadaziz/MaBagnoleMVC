const success_notification = document.getElementById("success_notification");
const error_notification = document.getElementById("error_notification");

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success_add_vehicle') {
        display_green_notification("Véhicule ajouté avec succès !");
        window.history.replaceState({}, document.title, "admin_vehicules.php");
    }
    else if (urlParams.get('status') === 'success_login') {
        display_green_notification("Connecté avec succès !");
        window.history.replaceState({}, document.title, "index.php");
    }
    else if (urlParams.get('status') === 'success_modifier_vehicule') {
        display_green_notification("Véhicule modifié avec succès !");
        window.history.replaceState({}, document.title, "admin_vehicules.php");
    }
    else if (urlParams.get('status') === 'echec_modifier_vehicule') {
        display_red_notification("Véhicule modifié avec succès !");
        window.history.replaceState({}, document.title, "admin_vehicules.php");
    }
    else if (urlParams.get('status') === 'succes_delete_vehicule') {
        display_green_notification("Véhicule supprimé avec succès !");
        window.history.replaceState({}, document.title, "admin_vehicules.php");
    }
    else if (urlParams.get('status') === 'error_champs_manquants') {
        display_red_notification("Champs obligatoires manquants !");
        window.history.replaceState({}, document.title, "admin_vehicules.php");
    }
    else if (urlParams.get('status') === 'all_field_required') {
        display_red_notification("Tous les champs sont obligatoires!");
        window.history.replaceState({}, document.title, "register.php");
    }
    else if (urlParams.get('status') === 'invalid_email_format') {
        display_red_notification("Tous les champs sont obligatoires!");
        window.history.replaceState({}, document.title, "register.php");
    }
    else if (urlParams.get('status') === 'success_register') {
        display_green_notification("Inscrit avec succès !");
        window.history.replaceState({}, document.title, "login.php");
    }
    else if (urlParams.get('status') === 'login_failed') {
        display_red_notification("Informations incorrecte !");
        window.history.replaceState({}, document.title, "login.php");
    }
})


function display_green_notification(msg) {
    error_notification.classList.add("hidden")
    success_notification.textContent = msg
    success_notification.classList.remove("hidden");
    setTimeout(() => {
        success_notification.classList.add("hidden")
    }, 3000)
}
function display_red_notification(msg) {
    success_notification.classList.add("hidden")
    error_notification.textContent = msg
    error_notification.classList.remove("hidden");
    setTimeout(() => {
        error_notification.classList.add("hidden")
    }, 3000)
}

// --- C'EST ICI QUE J'AI CORRIGÉ ---
function toggleModal(modalID) {
    const modal = document.getElementById(modalID);
    if (modal) {
        modal.classList.toggle("hidden");
        // J'ai supprimé la ligne : modal.classList.toggle("flex");
        // Car "flex" est déjà dans ton HTML pour centrer la modale.
    } else {
        console.error("Modale introuvable : " + modalID);
    }
}

window.onclick = function (event) {
    const modal = document.getElementById('addVehicleModal');
    if (event.target == modal) {
        toggleModal('addVehicleModal');
    }
}

function openEditModal(button) {
    // 1. Récupérer les données stockées dans les attributs data- du bouton
    const id = button.getAttribute('data-id');
    const marque = button.getAttribute('data-marque');
    const modele = button.getAttribute('data-modele');
    const prix = button.getAttribute('data-prix');
    const categorie = button.getAttribute('data-categorie');

    // 2. Remplir les champs du formulaire de modification
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_marque').value = marque;
    document.getElementById('edit_modele').value = modele;
    document.getElementById('edit_prix').value = prix;
    document.getElementById('edit_categorie').value = categorie;

    // 3. Ouvrir la modale (en utilisant ta fonction existante)
    toggleModal('editVehicleModal');
}