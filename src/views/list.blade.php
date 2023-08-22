@extends('reader::template.layout')
@section('content')

<table id="example" class="display" style="width:100%;">
    <thead>
        <th width="5%">Id</th>
        <th width="5%">Domain Id</th>
        <th width="10%">Name</th>
        <th width="5%">Subdomain</th>
        <th width="5%">Change</th>
        <th width="20%">Change Time</th>
    </thead>
    <tbody>
        @foreach ($audit_logs as $au)
        <tr>
            <th scope="row">{{$au->id}}</th>
            <td>{{$au->domain_id}}</td>
            <td>{{$au->name}}</td>
            <td>{{$au->subdomain}}</td>
            <td>{{$au->changes}}</td>
            <td>{{$au->change_time}}</td>
        </tr>
        @endforeach

    </tbody>
</table>

@endsection
