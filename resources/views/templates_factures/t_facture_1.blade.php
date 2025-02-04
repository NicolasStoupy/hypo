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
            <img src="{{ ConfigHelper::get('INVOICE_LOGO_PATH') }}" alt="Logo" style="width: 150px;">

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

<!-- Ajout de Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
