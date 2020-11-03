@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/"><-index</a> Wind: {{\App\XRandom::scaled(11, 22)}}<br/>
        <table class="proxy-table">
            <tr class="proxy-header">
                <th width="100px">host</th>
                <th>port</th>
                <th width="70px">type</th>
                <th width="100px">anonymity</th>
                <th width="70px">speed</th>
                <th width="210px">added</th>
                <th width="170px">checked</th>
            </tr>
            @foreach ($proxys as $proxy)
                <tr class="proxy-item proxy-type-{{$proxy['type']}}">
                    <td><a href="/proxy"
                           data-pt-gravity="top 10 15; bottom 0 55" data-pt-animate="bounceIn"
                           data-pt-title="<span class='protip-on-main'>info:???</span>"
                           class="protip interestlink" data-pt-gravity="top-right" data-pt-scheme="white"
                           title="proxy/socks {{$proxy['host'].':'.$proxy['port']}}">{{\App\Models\Tools::ipInfo($proxy['host'])}}
                        </a>
                    </td>
                    <td>{{$proxy['port']}}</td>
                    <td>{{$proxy['type']}}</td>
                    <td>{{$proxy['anonymity']}}</td>
                    <td>{{$proxy['speed']??'?'}}</td>
                    <td>{{$proxy['created_at']->format('h:m:s d/m/Y')}}</td>
                    <td>{{$proxy['checked_at']??'?'}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
