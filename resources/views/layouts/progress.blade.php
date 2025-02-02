<style>
    /* Spinner styles */
    #loadingSpinner {
        display: none; /* Hidden by default */
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }

    #loadingSpinner .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid rgba(0, 0, 0, 0.1);
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /* Dim background when loading */
    #loadingOverlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);  /* Légèrement transparent pour l'effet flou */
        backdrop-filter: blur(5px); /* Applique un flou de 5px sur l'arrière-plan */
        -webkit-backdrop-filter: blur(5px); /* Pour Safari et certains anciens navigateurs */
        z-index: 9998;
    }

</style>

<div id="loadingOverlay"></div>
<div id="loadingSpinner">
    <div class="spinner"></div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const spinner = document.getElementById('loadingSpinner');
        const overlay = document.getElementById('loadingOverlay');

        // Afficher le spinner et l'overlay avant la soumission du formulaire
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (event) => {
                overlay.style.display = 'block';
                spinner.style.display = 'block';

                // Vérifier si la soumission échoue
                setTimeout(() => {
                    if (document.body.contains(spinner)) {
                        overlay.style.display = 'none';
                        spinner.style.display = 'none';
                    }
                }, 300); // Masquer après 5s si pas de rechargement
            });
        });

        // Masquer le spinner après le chargement de la page
        window.addEventListener('load', function () {
            setTimeout(function () {
                overlay.style.display = 'none';
                spinner.style.display = 'none';
            }, 250);
        });
    });




</script>
