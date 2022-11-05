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
                <th width="70px">software</th>
                <th width="170px">country</th>
                <th width="210px">added</th>
                <th width="170px">checked</th>
            </tr>
            @foreach ($proxys as $proxy)
                <tr class="proxy-item proxy-type-{{$proxy['type']}}">
                    <td align="right">
                        <span class="ips" style="display:none">{{$proxy['host'] . ':' . $proxy['port']}}</span>

                        <a href="/proxy"
                           data-pt-animate="bounceIn" data-pt-width="900px"
                           data-pt-title="<pre class='protip-ip-info'>{{\Tools::ipInfo($proxy['host'])}}</pre>"
                           class="protip iplink" data-pt-scheme="white"
                           title="{{\App\XRandom::get(100,400) . 'ms'}}">{{$proxy['host']}}
                        </a>
                    </td>
                    <td>{{$proxy['port']}}</td>
                    <td>{{$proxy['type']}}</td>
                    <td>{{$proxy['anonymity']}}</td>
                    <td>{{$proxy['speed']??'?'}}</td>
                    <td>{{$proxy['software']??'?'}}</td>
                    <td>{{\Tools::getCountry($proxy['host'])}}</td>
                    <td>{{isset($proxy['created_at']) ? $proxy['created_at']->format('h:m:s d/m/Y') :'?'}}</td>
                    <td>{{$proxy['checked_at']??'?'}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
