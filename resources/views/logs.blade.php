@extends('layouts.app')

@section('content')
  <div class="container">
    <a href="/"><-index</a><br/>
    @foreach ($logs as $log)
      <div class="log-record">
        <span class="log-date">{{$log->created_at->format('d/m/Y H:i:s')}}</span>
        <span class="log-ip">{{$log->ip}}</span>
        <span class="log-ua">{{$log->ua}}</span>
        <span class="log-method">{{$log->method}}</span>
        <span class="log-url">{{$log->url}}</span>
        <span class="log-code">{{$log->http_code}}</span>
        <span class="log-info"><pre
            class="log-info">{{json_encode(json_decode($log->info),JSON_PRETTY_PRINT)}}</pre></span>
        @if ($log->ipInfo)
          <span class="ip-info"><pre
              class="ip-info">{{json_encode(json_decode($log->ipInfo->info),JSON_PRETTY_PRINT)}}</pre></span>
        @endif
      </div>
    @endforeach
  </div>
@endsection
