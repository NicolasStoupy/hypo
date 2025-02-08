@php use App\Helpers\ConfigHelper; @endphp
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <!-- Ajout de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style pour le container principal */
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        /* En-tête de la facture */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .company-logo img {
            width: 120px;
            height: auto;
        }

        .company-info {
            text-align: right;
        }

        .company-info h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .company-info p {
            margin: 5px 0;
        }

        /* Information du client */
        .client-info {
            margin-bottom: 20px;
        }

        .client-info h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .client-info p {
            margin: 5px 0;
        }

        /* Titre de la facture */
        h1 {
            font-size: 28px;
            text-align: center;
            margin: 20px 0;
        }

        /* Détails de la facture */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        td[colspan="3"] {
            text-align: center;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
            text-align: right;
        }

        .text-end {
            text-align: right;
        }

        table td:nth-child(6), table td:nth-child(7) {
            text-align: right;
        }

        table .total-row td {
            background-color: #e9ecef;
        }

        /* Style pour la section footer */
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .footer div {
            width: 48%;
        }

        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }

        /* Si tu veux que les montants négatifs apparaissent en rouge */
        td:nth-child(7):not(:empty) {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header d-flex justify-content-between">
        <div class="company-logo">
            <img src="data:image/png;base64,{{ $logo }}" />

        </div>
        <div class="company-info">
            <h2>{{ConfigHelper::get('INVOICE_ORGANISATION')}}</h2>
            <p><strong>Numéro de TVA:</strong>{{ConfigHelper::get('INVOICE_INTERPRISE_ID')}}</p>
            <p><strong>Adresse:</strong>{{ConfigHelper::get('ADDRESS')}}</p>
        </div>
    </div>

    <div class="client-info">
        <h3>Client</h3>
        <p><strong>Nom:</strong> {{$facture->client->nom}}</p>
        <p><strong>Email:</strong> {{$facture->client->email}}</p>
    </div>

    <h1>{{ConfigHelper::get('INVOICE_NUMBER_PREFIX')}}{{ $facture->id }}</h1>
    <p><strong>Date:</strong> {{ $facture->created_at }}</p>

    <!-- Table avec les éléments -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nom evenement</th>
            <th>Date evenement</th>
            <th>Prix Total Evenement</th>
            <th>Cavalier</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>


        </tr>
        </thead>
        <tbody>

        <tr>
            @php
                $htva= number_format(($cavalier->facture->amount - ($cavalier->facture->amount* ConfigHelper::get('INVOICE_TAX_RATE')) / 100), 2);
            @endphp
            <td>{{ $cavalier->evenement->nom }}</td>
            <td>{{ $cavalier->evenement->date_evenement }}</td>
            <td>{{  $cavalier->evenement->prix }}{{ConfigHelper::get('INVOICE_CURRENCY')}}</td>
            <td>{{  $cavalier->nom}}</td>
            <td>1</td>
            <td>{{ $htva}}{{ConfigHelper::get('INVOICE_CURRENCY')}}</td>


        </tr>
        <tr class="total-row">
            <td colspan="5" class="text-end">TVA {{ConfigHelper::get('INVOICE_TAX_RATE')}}%:</td>
            <td>{{ $cavalier->facture->amount - $htva}}{{ConfigHelper::get('INVOICE_CURRENCY')}}</td>
        </tr>
        <tr class="total-row">
            <td colspan="5" class="text-end">Total:</td>
            <td>{{$cavalier->facture->amount }}{{ConfigHelper::get('INVOICE_CURRENCY')}}</td>
        </tr>
        </tbody>
    </table>

    <!-- Conditions de paiement -->
    <div class="footer row">
        <div class="col-md-6">
            <p><strong>Date Limite de Paiement:</strong> {{ $facture->created_at->addDays((int)ConfigHelper::get('INVOICE_PAYMENT_TERMS'))->format('d/m/Y') }}</p>

            <p><strong>Conditions de Paiement:</strong> Paiement sous {{ConfigHelper::get('INVOICE_PAYMENT_TERMS')}} jours.</p>
            <p><strong>Numéro de Compte:</strong> {{ConfigHelper::get('INVOICE_BANKNUMBER')}}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Banque:</strong> {{ConfigHelper::get('INVOICE_BANK')}}</p>
            <p><strong>Code IBAN:</strong> {{ConfigHelper::get('INVOICE_EURBANKNUMBER')}}</p>
        </div>
    </div>
</div>
</body>
</html>
