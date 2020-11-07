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
    </div>
@endsection
