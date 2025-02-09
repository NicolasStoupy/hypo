<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des créneaux horaires</title>
    <style>
        .time-grid {
            display: grid;
            grid-template-columns: repeat(9, 1fr);
            gap: 10px;
            max-width: 800px;
            margin: 0 auto;
        }
        .time-slot {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            cursor: pointer;
            background-color: #f0f0f0;
        }
        .time-slot.selected {
            background-color: #8BC34A;
            color: white;
        }
        .time-slot.disabled {
            background-color: #e0e0e0;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="time-grid" id="time-grid">
    <div class="time-slot" data-hour="08:00">08:00</div>
    <div class="time-slot" data-hour="09:00">09:00</div>
    <div class="time-slot" data-hour="10:00">10:00</div>
    <div class="time-slot" data-hour="11:00">11:00</div>
    <div class="time-slot" data-hour="12:00">12:00</div>
    <div class="time-slot" data-hour="13:00">13:00</div>
    <div class="time-slot" data-hour="14:00">14:00</div>
    <div class="time-slot" data-hour="15:00">15:00</div>
    <div class="time-slot" data-hour="16:00">16:00</div>
</div>

<script>
    // Liste des créneaux déjà réservés en format [début, fin]
    const unavailableSlots = [
        { start: "08:00", end: "11:00" },  // Créneau réservé de 8h à 11h
        { start: "13:00", end: "14:00" }   // Créneau réservé de 13h à 14h
    ];

    // Fonction pour vérifier si un créneau se chevauche
    function isOverlapping(start1, end1, start2, end2) {
        return (start1 < end2 && end1 > start2); // Vérifie le chevauchement
    }

    // Fonction pour vérifier si une plage horaire est disponible
    function isSlotAvailable(start, duration) {
        const end = getEndTime(start, duration);
        for (const unavailable of unavailableSlots) {
            if (isOverlapping(start, end, unavailable.start, unavailable.end)) {
                return false; // Si chevauchement avec une plage réservée, retour false
            }
        }
        return true; // Si pas de chevauchement, la plage est disponible
    }

    // Fonction pour calculer l'heure de fin en fonction de la durée (en heures)
    function getEndTime(start, duration) {
        const [h, m] = start.split(':').map(Number);
        const endHour = h + duration;
        return `${endHour.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
    }

    document.addEventListener("DOMContentLoaded", () => {
        const timeSlots = document.querySelectorAll('.time-slot');

        // Ajouter un événement de clic à chaque créneau
        timeSlots.forEach(slot => {
            const startTime = slot.getAttribute('data-hour');
            const duration = 1;  // Durée par défaut de 1 heure pour chaque créneau affiché

            // Vérifier si le créneau est disponible
            if (!isSlotAvailable(startTime, duration)) {
                slot.classList.add('disabled');
            }

            // Ajouter un écouteur de clic pour les créneaux sélectionnables
            slot.addEventListener('click', () => {
                if (!slot.classList.contains('disabled')) {
                    slot.classList.toggle('selected');
                }
            });
        });
    });
</script>

</body>
</html>
