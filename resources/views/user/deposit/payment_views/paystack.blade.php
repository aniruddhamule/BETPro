<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{@$general->web_name}}</title>
</head>
<body>
<form method="POST" id="PayForm" action="{{ route('paystack.pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
{{ csrf_field() }} 
    <div class="row pay_margin">
        <div class="col-md-8 col-md-offset-2">
            @php $amt = floatval($deposit_table->amount) + floatval($deposit_table->charge); @endphp
            <input type="hidden" name="email" value="{{optional($deposit_table->user)->email}}"> 
            <input type="hidden" name="orderID" value="{{$deposit_table->trx}}">
            <input type="hidden" name="amount" value="{{$amt}}">
            <input type="hidden" name="quantity" value="100">
            <input type="hidden" name="currency" value="NGN"> 
            <input type="hidden" name="reference" value="{{ Unicodeveloper\Paystack\Facades\Paystack::genTranxRef() }}">

        </div>
    </div>
</form>
<script>
    document.getElementById("PayForm").submit();
</script>
</body>
</html>
