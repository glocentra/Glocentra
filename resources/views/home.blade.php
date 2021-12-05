@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            @if(isset (Auth::user()->client_reference) )
                                CLIENT:  {{ Auth::user()->client_reference }}
                                <div>
                                    <a href="/h" class="btn btn-primary"> Generate Axxerion Tables</a>
                                </div>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-3">
                                            <strong>Table</strong>
                                        </div>
                                        <div class="col-3">
                                            <strong>Columns</strong>
                                        </div>
                                        <div class="col-3">
                                            <strong>Table Row Count</strong>
                                        </div>

                                    </div>
                                    <hr>
                                @foreach ($tables as $table)
                                        <div class="row">
                                            <div class="col-3">
                                               <a href={{url()->current()."/".$table->Tables_in_Axxerion}}> {{ $table->Tables_in_Axxerion}}</a>
                                            </div>
                                            <div class="col-3">
                                                {{count(DB::getSchemaBuilder()->getColumnListing($table->Tables_in_Axxerion))}}
                                            </div>
                                            <div class="col-3">
                                                {{DB::table($table->Tables_in_Axxerion)->count()}}
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach

                                </div>

                            @else
                                {{ __('Set up the client') }}
                                <div class="card-body">
                                <form method="POST" action="/connectToClient">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus>

                                            @error('user_name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="client_password" class="col-md-4 col-form-label text-md-right">{{ __('Client Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="client_password" type="password" class="form-control @error('client_password') is-invalid @enderror" name="client_password" required autocomplete="client_password">

                                            @error('client_password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="client_reference" class="col-md-4 col-form-label text-md-right">{{ __('Client Reference') }}</label>

                                        <div class="col-md-6">
                                            <input id="client_reference" type="text" value="{{ old('client_reference') }}" class="form-control @error('client_reference') is-invalid @enderror" name="client_reference" required autocomplete="client_reference">

                                            @error('client_reference')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary"  >
                                                {{ __('Connect to client') }}
                                            </button>
                                            @error('client_auth')
                                            <span style="color: red"  role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            @error('client_auth_connected')
                                            <span style="color: green"  role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
