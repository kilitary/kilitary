@extends('layouts.app')

@section('content')
    <div>
        <h3>Cart items:</h3>
    </div>
    @foreach ($cart as $item)
        <div class="cart-item">
            <span class="cart-item-name"><a href="/view/{{$item['name']}}" target="_blank">{{$item['name']}}</a></span><span
                class="cart-item-cost">${{$item['cost']}}</span>
        </div>
    @endforeach
    <div class="cart-total">
        Total: ${{ $total }}
    </div>
    <div class="cart-button-submit">
        [<a href="/cart/final-submit">final submit</a>]
    </div>
@endsection
