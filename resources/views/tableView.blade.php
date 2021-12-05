@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <div>
                            <h1>Table View {{$tableName}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                    <form action="/home/problemtypes" method="POST" >
                        @csrf
                        <label for="fname">First name:</label>
                        <input type="text" id="fname" name="fname"><br><br>
                        <label for="lname">Last name:</label>
                        <input type="text" id="lname" name="lname"><br><br>
                        <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
@endsection
