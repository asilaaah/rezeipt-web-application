@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="d-flex justify-content-between">
            <div style="margin-bottom:30px"><h2>Cashier ( {{ $cashier->count() }} )</h2></div>
            <div class="pull-right">
                <a class="btn btn-success" href="#"> Add new cashier</a>
            </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Role</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>

                @foreach ($cashier as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->role }}</td>
                        <td class="d-flex">
                            <div style="padding-right:5px;"><a href="#">Edit</div>
                            <div><a href="#">Delete</div>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>

</div>   
@endsection