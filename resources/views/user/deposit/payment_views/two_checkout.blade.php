<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ @$general->web_name }}</title>
</head>
<body>
    <form action="https://www.2checkout.com/checkout/purchase" method="POST" id="auto_submit">
        <input type="hidden" name="sid" value="{{$gateway->gateway_key_one}}"/>
        <input type="hidden" name="mode" value="2CO"/>
        <input type="hidden" name="li_0_type" value="Product"/>
        <input type="hidden" name="li_0_name" value="{{ @$general->web_name }}"/>
        <input type="hidden" name="li_0_price" value="{{ round($deposit_table->usd_amo) }}"/>
        <input type="hidden" name="li_0_product_id" value="{{ $deposit_table->trx }}"/>
        <input type="hidden" name="li_0_quantity" value="1"/>
        <input type="hidden" name="li_0_tangible" value="N"/>
        <input type="hidden" name="currency_code" value="USD"/>
        <input type="hidden" name="demo" value="Y" />
    </form>
<script>
    document.getElementById("auto_submit").submit();
</script>
</body>

</html>