<form role="form" action="/orders/place" method="post" class="require-validation" data-cc-on-file="false">
    @csrf
    <h3 class="mb-5">Método de Pagamento</h3>
    <div class="row g-4 mb-7">
        <div class="col-12">
            <div class="row gx-lg-11">
                <div class="col-12 col-md-auto">
                    <div class="d-flex">
                        <div class="form-check">
                            <input class="form-check-input" id="cartaoCredito" type="radio" name="metodoPagamento"
                                checked="checked">
                            <label class="form-check-label fs-0 text-900 me-3" for="cartaoCredito">Cartão de
                                crédito</label>
                        </div>
                        <img class="h-100 me-2 ms-4 ms-md-0" src="{{ asset('assets/img/logos/visa.png') }}"
                            alt="">
                        <img class="h-100 me-2" src="{{ asset('assets/img/logos/discover.png') }}" alt="">
                        <img class="h-100 me-2" src="{{ asset('assets/img/logos/mastercard.png') }}" alt="">
                        <img class="h-100" src="{{ asset('assets/img/logos/american_express.png') }}" alt="">
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="form-check">
                        <input class="form-check-input" id="paypal" type="radio" name="metodoPagamento">
                        <label class="form-check-label fs-0 text-900" for="paypal">Paypal</label>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="form-check">
                        <input class="form-check-input" id="cupom" type="radio" name="metodoPagamento">
                        <label class="form-check-label fs-0 text-900" for="cupom">Cupom</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label fs-0 text-1000 ps-0 text-none" for="selecionarCartao">Selecionar cartão</label>
            <select class="form-select text-black" id="selecionarCartao">
                <option selected="selected">selecionar um cartão</option>
                <option value="visa">Visa</option>
                <option value="discover">Discover</option>
                <option value="mastercard">Mastercard</option>
                <option value="american-express">American Express</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label fs-0 text-1000 ps-0 text-none" for="inputNumeroCartao">Número do cartão</label>
            <input autocomplete='off' class="form-control card-number" id="inputNumeroCartao" type="text"
                placeholder="Digite o número do cartão" aria-label="Número do cartão">
        </div>
        <div class="col-12">
            <label class="form-label fs-0 text-1000 ps-0 text-none" for="inputNome">Nome
                completo</label>
            <input class="form-control" autocomplete='off' id="inputNome" type="text" placeholder="Nome Completo"
                aria-label="Nome completo">
        </div>
        <input type="text" name="delivery_option_id" value="2bc053de-80e2-4a65-ac11-1badae0c3100">
        <input type="text" name="payment_method_id" value="162acc7c-6e5e-41fa-95df-7ec99230f0a5">

        <div class="col-md-6">
            <label class="form-label fs-0 text-1000 ps-0 text-none">Expira em</label>
            <div class="d-flex">
                <select class="form-select text-black me-3 card-expiry-month">
                    <option selected="selected">Mês</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>

                <input autocomplete='off' class="form-control me-3 card-expiry-year" type="text" placeholder="Ano">
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label fs-0 text-1000 ps-0 text-none" for="inputCVC">CVC</label>
            <input autocomplete='off' class="form-control card-cvc" id="inputCVC" type="number"
                placeholder="Digite um CVC válido" aria-label="CVC">
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" id="checkSalvarCartao" type="checkbox">
                <label class="form-check-label text-black fs-0" for="checkSalvarCartao">Salvar
                    detalhes do cartão</label>
            </div>
        </div>
    </div>
    <div class="row g-2 mb-5 mb-lg-0">
        <div class="col-md-8 col-lg-9 d-grid">
            <button class="btn btn-primary" type="submit">Pagar</button>
        </div>
        <div class="col-md-4 col-lg-3 d-grid">
            <button class="btn btn-phoenix-secondary text-nowrap" type="submit">Salvar Pedido
                e Sair</button>
        </div>
    </div>



</form>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var $form = $(".require-validation");

        $form.on('submit', function(e) {
            e.preventDefault();

            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                var stripe = Stripe('{{ env('STRIPE_KEY') }}');
                var elements = stripe.elements();
                var card = elements.create(
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                );

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        console.error(result.error.message);
                    } else {
                        var stripeToken = result.token.id;
                        $form.find('input[type=text]').empty();
                        $form.append("<input type='hidden' name='stripeToken' value='" + stripeToken + "'/>");
                        $form.get(0).submit();
                    }
                });
            }
        });
    });
</script>
