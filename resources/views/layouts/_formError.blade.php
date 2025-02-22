


@if (session('success'))
    <div class="alert alert-success toast-message" style="display:none" >
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger toast-message" style="display:none">
        {{ session('error') }}
    </div>
@endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fonction pour afficher un toast
            const showToast = (message, type) => {
                const toast = document.createElement('div');
                toast.classList.add('toast', type);
                toast.innerText = message;
                document.body.appendChild(toast);

                // Ajouter un effet pour faire apparaître le toast
                setTimeout(() => {
                    toast.classList.add('show');
                }, 100);

                // Supprimer le toast après 4 secondes
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        toast.remove();
                    }, 300); // Attendre 300ms avant de supprimer complètement
                }, 4000);
            };

            // Vérifier et afficher les messages de session
            @if (session('success'))
            showToast("{{ session('success') }}", 'toast-success');
            @endif

            @if (session('error'))
            showToast("{{ session('error') }}", 'toast-error');
            @endif
        });
    </script>



    <style>
        /* Styles pour les toasts */
        .toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            z-index: 9999;
        }

        .toast.show {
            opacity: 1;
        }

        .toast-success {
            background-color: #28a745;
            color: white;
        }

        .toast-error {
            background-color: #dc3545;
            color: white;
        }
    </style>
