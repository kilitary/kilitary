@extends('layouts.app')

@section('content')
    <div class="container page-content">
        <h2>{{$header}}</h2>
        <div>
            @markdown($content)
        </div>

        <div class="topheadmargin smallcaps">
            Views: {{$views}}
        </div>

        <div class="topheadmargin page-content">
            <a class="topheadmargin alignnmiddle" href="/delete/{{$code}}/0">
                DELETE THIS DOC (Free)</a><br/>
            <a class="topheadmargin alignnmiddle" href="/delete/{{$code}}/1">
                DELETE THIS DOC (24 writeS of 1/0 per byteS in file
                sectorS (inodes)
                24.95$)</a><br/>
            <a class="topheadmargin alignnmiddle" href="/delete/{{$code}}/2">
                DELETE THIS DOC (255 writeS of 1/0 per byteS in file
                sectorS and physical destroy
                of active RAID4 disk 94.95$)</a><br/>
            <a class="topheadmargin alignnmiddle" href="/">return back</a>
        </div>
    </div>

@endsection
