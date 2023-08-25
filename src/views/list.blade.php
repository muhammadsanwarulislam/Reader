@extends('reader::template.layout')
@section('content')
    <table id="example" class="display" style="width:100%;">
        <thead>
            @foreach ($colms as $col)
                <th>{{ $col }}</th>
            @endforeach
            <th>Domain</th>
        </thead>
        <tbody>
            @foreach ($results as $key => $value)
                <tr>
                    @if (is_object($value) || is_array($value))
                        @foreach ($value as $property => $propertyValue)
                            <th>{{ $propertyValue }}</th>
                        @endforeach
                    @else
                        <th>{{ $value }}</th>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
