@extends('layouts.app')

@section('content')
    <a href="/"><-index</a><br/>
    <div class="container page-content">

        <h2 class="page-header">{{$header}}</h2>
        <div>
            @markdown($content)
        </div>
        <h2 class="page-header"> </h2>
        <div class="topheadmargin smallcaps">
            √iews: {{$views}}
        </div>

        <div class="topheadmargin page-content">
            <ul>
                <li>
                    <a class="topheadmargin alignnmiddle" href="/delete/{{$code}}/0">DELETE THIS DOC (free)</a>
                </li>
                <li>
                    <a class="topheadmargin alignnmiddle" href="/delete/{{$code}}/1">
                        DELETE THIS DOC (24 writes of 1/0 per bytes in file
                        sectors (inodes)
                        24.95$)</a>
                </li>
                <li>
                    <a class="topheadmargin alignnmiddle" href="/delete/{{$code}}/2">
                        DELETE THIS DOC (255 writeS of 1/0 per bytes in file
                        sectors and physically destroy
                        ONE of active RAID1 disk 94.95$)</a>
                </li>
                <li>
                    <a class="topheadmargin alignnmiddle" href="/">return</a>
                </li>
            </ul>
        </div>


    </div>

@endsection
