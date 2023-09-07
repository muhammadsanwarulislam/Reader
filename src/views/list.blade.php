@extends('reader::template.layout')
@section('content')
    <table id="example" class="display" style="width:100%;">
        <thead>
            @foreach ($mergeColms as $col)
                <th>{{ $col }}</th>
            @endforeach
        </thead>
        <tbody>
            @if (!empty($result))
                <tr>
                    <th>Please define relation to get the data from the database</th>
                </tr>
            @else
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
            @endif

        </tbody>
    </table>
@endsection
