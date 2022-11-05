@extends('layouts.app')

@section('content')
  <a href="/"><-index</a><br/>
  <div class="container page-content">
    <table class="abuser-list-table">
      <tr>
        <th>ip</th>
        <th>пушо</th>
        <th>ордер</th>
        <th>унбано</th>
      </tr>
      @foreach ($abusers as $abuser)
        <tr>
          <td>
                        <span data-pt-placement="corner-right-top" data-pt-width='800'
                              data-pt-title="<pre class='protip-mine'>{{ \Tools::ipInfo($abuser->ip) }}</pre>"
                              class="protip interestlink" data-pt-scheme="white">{{$abuser->ip}}</span>
          </td>
          <td>
            {{$abuser->reason}}
          </td>
          <td>
            {{$abuser->nick}}
          </td>
          <td>
            {{$abuser->deabusertime}}
          </td>
        </tr>
      @endforeach
    </table>
    <div>
      Debun info - ask admin via <a href="mailto:deconf@kilitary.ru">email</a>, or create <a
        href="/view/debun-info-post-thre?precomment=please%20unban%20{{request()->ip()}}">comment</a>.
    </div>
  </div>

@endsection
