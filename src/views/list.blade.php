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
        @foreach ($results as $result)
        <tr>
            <th scope="row">{{$result->id}}</th>
            <td>{{$result->domain_id}}</td>
            <td>{{$result->name}}</td>
            <td>{{$result->subdomain}}</td>
            <td>{{$result->changes}}</td>
            <td>{{$result->change_time}}</td>
        </tr>
        @endforeach

    </tbody>
</table>

@endsection
