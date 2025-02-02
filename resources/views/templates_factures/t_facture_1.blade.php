<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <!-- Ajout de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }
        .company-info, .client-info {
            margin-bottom: 15px;
        }
        .table th, .table td {
            text-align: center;
        }
        .total-row td {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            border-top: 2px solid #000;
            padding-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header d-flex justify-content-between">
        <div class="company-logo">
            <img src="path_to_logo.jpg" alt="Logo" style="width: 150px;">
        </div>
        <div class="company-info">
            <h2>Nom de la Société</h2>
            <p><strong>Numéro de TVA:</strong> FR12345678901</p>
            <p><strong>Adresse:</strong> 123 Rue de l'Entreprise, 75001 Paris, France</p>
        </div>
    </div>

    <div class="client-info">
        <h3>Client</h3>
        <p><strong>Nom:</strong> Nicolas</p>
        <p><strong>Adresse:</strong> rue bidon</p>
    </div>

    <h1>Facture #{{ $facture->id }}</h1>
    <p><strong>Date:</strong> {{ $facture->created_at }}</p>

    <!-- Table avec les éléments -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Description</th>
            <th>Quantité</th>
            <th>Prix Unitaire</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($facture->evenements as $evenement)
            <tr class="{{ $loop->odd ? 'table-light' : '' }}">
                <td>{{ $evenement->date_evenement }}</td>
                <td>{{ $evenement->nombre_participant }}€</td>
                <td>{{ $evenement->prix }}€</td>
                <td>{{ $evenement->nombre_participant * $evenement->prix }}€</td>
            </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="3" class="text-end">Total:</td>
            <td>{{ $facture->evenements->sum('prix') }}€</td>
        </tr>
        </tbody>
    </table>

    <!-- Conditions de paiement -->
    <div class="footer row">
        <div class="col-md-6">
            <p><strong>Date Limite de Paiement:</strong> {{ $facture->due_date }}</p>
            <p><strong>Conditions de Paiement:</strong> Paiement sous 30 jours.</p>
            <p><strong>Numéro de Compte:</strong> 1234567890123456</p>
        </div>
        <div class="col-md-6">
            <p><strong>Banque:</strong> Banque XYZ</p>
            <p><strong>Code IBAN:</strong> FR7612345678901234567890123</p>
        </div>
    </div>
</div>

<!-- Ajout de Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
