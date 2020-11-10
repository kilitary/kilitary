@extends('layouts.app')

@section('content')
    <a href="/"><-index</a><br/>
    <div class="container page-content">
        <table>
            <tr>
                <th>ip</th>
                <th>пушо</th>
            </tr>
            @foreach ($gays as $gay)
                <tr>
                    <td>
                        {{$gay->ip}}
                    </td>
                    <td>
                        {{$gay->reason}}
                    </td>
                </tr>
            @endforeach
        </table>
        <div>
            Debun info - ask admin via <a href="mailto:deconf@kilitary.ru">email</a>, or create <a
                href="/view/debun-info-post-thre">comment</a>.
        </div>
    </div>

@endsection
