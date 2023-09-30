@extends('layouts.app')

@section('content')
<h2>Customers</h2>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Memo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->age }}</td>
                <td>{{ $customer->memo }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
