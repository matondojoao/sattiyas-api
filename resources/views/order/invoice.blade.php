<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essence - Fatura</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 0;
            margin-bottom: 20px;
            box-shadow: none;
        }

        .table-container {
            display: flex;
            justify-content: flex-start;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            padding: 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            vertical-align: top;
            border: 1px solid #000;
        }

        .table thead th {
            vertical-align: bottom;
        }

        .table tbody+tbody {
            border-top: 2px solid #000;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .strong {
            font-weight: bold;
        }

        .table-clear {
            width: 400px;
            text-align: left;
            /* Alinha a tabela à esquerda */
        }

        .table-clear td {
            border-top: none;
        }

        .card-footer {
            background-color: #fff;
            padding: 1.25rem;
        }
    </style>
</head>

<body>
    <div>
        <h2>ESSENCE</h2>
        <div class="float-right">
            <h3 class="mb-0">Fatura #BBB10234</h3>
            {{ \App\Helpers\ptBRHelper::data($order->created_at) }}
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-sm-6">
            <h4 class="mb-3">Endereço de Cobrança:</h4>
            <div style="margin-bottom: 1px"><strong>$order->user->name</strong></div>
            <div>{{ $order->user->billingAddress->address }}</div>
            <div>{{ $order->user->billingAddress->city->name }},
                {{ $order->user->billingAddress->city->state->name }}
                {{ $order->user->billingAddress->zip_code }}</div>
            <div>Email: {{ $order->user->email }}</div>
            <div>Telefone: {{ $order->user->phone }}</div>
        </div>
        <div class="col-sm-6 ">
            <h4 class="mb-3">Endereço de Entrega:</h4>
            <div style="margin-bottom: 1px"><strong>$order->user->name</strong></div>
            <div>{{ $order->user->shippingAddress->address }}</div>
            <div>{{ $order->user->shippingAddress->city->name }},
                {{ $order->user->shippingAddress->city->state->name }}
                {{ $order->user->shippingAddress->zip_code }}</div>
            <div>Email: {{ $order->user->email }}</div>
            <div>Telefone: {{ $order->user->phone }}</div>
        </div>
    </div>

    @if ($order->payment_status == 'pending')
    <?php $paymentStatus = 'Pendente'; ?>
@elseif ($order->payment_status == 'completed')
    <?php $paymentStatus = 'Completo'; ?>
@else
    <?php $paymentStatus = 'Falhou'; ?>
@endif

@if ($order->fulfillment_status == 'pending')
    <?php $fulfillmentStatus = 'Pendente'; ?>
@elseif ($order->fulfillment_status == 'processing')
    <?php $fulfillmentStatus = 'Processando'; ?>
@elseif ($order->fulfillment_status == 'completed')
    <?php $fulfillmentStatus = 'Completo'; ?>
@else
    <?php $fulfillmentStatus = 'Cancelado'; ?>
@endif

    <div class="table-responsive-sm">
        <table class="table">
            <thead>
                <tr>
                    <th class="center">#</th>
                    <th class="center">Item</th>
                    <th class="center">Preço</th>
                    <th class="center">Qtde</th>
                    <th class="center" colspan="2">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalGeral = 0;
                    $subTotal = 0;
                @endphp

                @foreach ($order->orderItems as $key => $item)
                    @php
                        $subTotal = $item->quantity * $item->price;
                        $totalGeral += $subTotal;
                    @endphp

                    <tr>
                        <td class="center">{{ $key + 1 }}</td>
                        <td class="center">{{ $item->product->name }}</td>
                        <td class="center">{{ \App\Helpers\ptBRHelper::real($item->price) }}</td>
                        <td class="center">{{ $item->quantity }}</td>
                        <td class="center">{{ \App\Helpers\ptBRHelper::real($subTotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-lg-4 col-sm-5">
        </div>
        <div class="col-lg-4 col-sm-5 ml-auto">
            <div class="table-container" style="margin-left: 300px;">
                <table class="table table-clear" style="width: 400px; text-align: left;">
                    <tbody>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Status de Pagamento</strong>
                            </td>
                            <td class="right">{{ $paymentStatus }}
                            </td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Status de Cumprimento</strong>
                            </td>
                            <td class="right">{{ $fulfillmentStatus }}
                            </td>
                        </tr>

                        <tr>
                            <td class="left">
                                <strong class="text-dark">Subtotal</strong>
                            </td>
                            <td class="right">{{ \App\Helpers\ptBRHelper::real($totalGeral - $order->discount) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Opção de entrega</strong>
                            </td>
                            <td class="right">{{ $order->deliveryOption->name }} - {{ \App\Helpers\ptBRHelper::real($order->deliveryOption->price) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Método de pagamento</strong>
                            </td>
                            <td class="right">{{ $order->paymentMethod->name}}
                            </td>
                        </tr>
                        <tr>
                            <td class="left">
                                @php
                                    $percentagem = $totalGeral !== 0 ? ($order->discount / $totalGeral) * 100 : 0;
                                @endphp
                                <strong class="text-dark">Desconto ({{ $percentagem }} %)</strong>
                            </td>
                            <td class="right">{{ \App\Helpers\ptBRHelper::real($order->discount) }}</td>

                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Total</strong>
                            </td>
                            <td class="right">
                                <strong class="text-dark">{{ \App\Helpers\ptBRHelper::real($totalGeral- $order->discount + $order->deliveryOption->price) }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
