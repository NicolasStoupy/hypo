<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {

        }
        .header{
            border: 1px solid black;
            display: grid;
            grid-template-columns: 1fr;
        }
        .company-info{
            display: grid;
            grid-template-columns: 1fr;
        }



    </style>
</head>
<body>

<div class="header">
    <div class="sub-grid"></div>
    <!-- Logo -->
    <div class="company-logo">
        <img src="path_to_logo.jpg" alt="Logo" style="width: 100%;">
    </div>

    <!-- Company and Client Info -->
    <div class="company-info">
        <h2>Nom de la Société</h2>
        <p><strong>Numéro de TVA:</strong> FR12345678901</p>
        <p><strong>Adresse:</strong> 123 Rue de l'Entreprise, 75001 Paris, France</p>
    </div>

    <div class="client-info">
        <h3>Client</h3>
        <p><strong>Nom:</strong> Nicolas</p>
        <p><strong>Adresse:</strong> rue bidon </p>
    </div>
</div>

<h1>Facture #{{ $facture->id }}</h1>
<p><strong>Date:</strong> {{ $facture->created_at }}</p>

<!-- Table with Items -->
<table>
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
        <tr class="{{ $loop->odd ? 'highlight' : '' }}">
            <td>{{ $evenement->date_evenement }}</td>
            <td>{{ $evenement->nombre_participant }}€</td>
            <td>{{ $evenement->prix }}€</td>
            <td>{{ $evenement->nombre_participant * $evenement->prix }}€</td>
        </tr>
    @endforeach
    <tr class="total-row">
        <td colspan="3" style="text-align: right;">Total:</td>
        <td>{{ $facture->evenements->sum('prix') }}€</td>
    </tr>
    </tbody>
</table>

<!-- Payment Terms -->
<div class="footer">
    <div class="payment-info">
        <p><strong>Date Limite de Paiement:</strong> {{ $facture->due_date }}</p>
        <p><strong>Conditions de Paiement:</strong> Paiement sous 30 jours.</p>
        <p><strong>Numéro de Compte:</strong> 1234567890123456</p>
    </div>

    <div class="bank-info">
        <p><strong>Banque:</strong> Banque XYZ</p>
        <p><strong>Code IBAN:</strong> FR7612345678901234567890123</p>
    </div>
</div>

</body>
</html>
