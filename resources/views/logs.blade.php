@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/"><-index</a><br/>
        @foreach ($logs as $log)
            <div class="log-record">
                <span class="log-date">{{$log->created_at->format('d/m/Y H:i:s')}}</span>
                <span class="log-code">{{$log->http_code}}</span>
                <span class="log-ip">{{$log->ip}}</span>
                <span class="log-method">{{$log->method}}</span>
                <span class="log-url">{{$log->url}}</span>
                <span class="log-info"><pre>{{json_encode(json_decode($log->info),JSON_PRETTY_PRINT)}}</pre></span>
            </div>
        @endforeach
    </div>
@endsection
