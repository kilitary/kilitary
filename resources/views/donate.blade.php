@extends('layouts.app')

@section('content')
    <div class="container page-content">
        <a href="/"><-index</a> Wind: {{mt_rand(11, 22)}}<br/>
        <div class="marginbottom donate-area">
            by credit card:<br/>
            <iframe
                src="https://yoomoney.ru/quickpay/button-widget?targets=%D1%80%D0%B0%D0%B7%D0%B2%D0%B8%D1%82%D0%B8%D0%B5%20%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D0%B0&default-sum=5000&button-text=14&any-card-payment-type=on&button-size=l&button-color=orange&successURL=https%3A%2F%2Fkilitary.ru%2Fsync&quickpay=small&account=410011883775956&"
                width="227" height="48" frameborder="0" allowtransparency="true" scrolling="no"></iframe>
        </div>
        <div class="marginbottom donate-area">
            bitcoin address:<br/>
            1NEBErkfreiSAoERiTGaLtwCiT2vjZ7sEP<br/>
            <img src="/images/bitoinaddr.png">
        </div>
        <div class="marginbottom donate-area">
            by perfect money:<br/>
            <form action="https://perfectmoney.com/api/step1.asp" method="POST">
                <input type="hidden" name="PAYEE_ACCOUNT" value="E26648808">
                <input type="hidden" name="PAYEE_NAME" value="deconf">
                <input type="hidden" name="PAYMENT_ID" value="anytext">
                <input type="hidden" name="PAYMENT_AMOUNT" value="49.95">
                <input type="hidden" name="PAYMENT_UNITS" value="EUR">
                <input type="hidden" name="STATUS_URL" value="https://kilitary.ru/payment/status">
                <input type="hidden" name="PAYMENT_URL" value="https://kilitary.ru/payment/ok">
                <input type="hidden" name="PAYMENT_URL_METHOD" value="post">
                <input type="hidden" name="NOPAYMENT_URL" value="https://kilitary.ru/payment/failed">
                <input type="hidden" name="NOPAYMENT_URL_METHOD" value="post">
                <input type="hidden" name="SUGGESTED_MEMO" value="">
                <input type="hidden" name="BAGGAGE_FIELDS" value="">
                <input type="submit" name="PAYMENT_METHOD" value="Pay Now or Die">
            </form>
        </div>
    </div>
@endsection
