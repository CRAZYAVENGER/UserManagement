@extends('users.layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit user</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('users.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" class="form-control" value="{{ $user->email }}" name="email" placeholder="Email">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Password:</strong>
                <input type="password" class="form-control" value="{{ $user->password }}" name="password" placeholder="Password"></input>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>Mobile:</strong>
                <input type="number" class="form-control" value="{{ $user->mobile }}" name="mobile" placeholder="Mobile"></input>
            </div>
        </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="country" class="form-label">Country</label>
                        <select id="country-dropdown" class="form-control" name="country">
                            <option hidden>Choose Country</option>
                            @foreach ($countries as $item)
                            <option value="{{ $item->id }}" {{($item->id==$user->country)?'selected':null}} >{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="state" class="form-label">State</label>
                        <select class="form-control" name="" id="state-dropdown">
                            <option hidden>Choose State</option>
                           
                        </select>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="city" class="form-label">City</label>
                        <select class="form-control" name="" id="city-dropdown">
                            <option hidden>Choose City</option>
                           
                        </select>
                    </div>
            <div class="col-xs-3 col-sm-3 col-md-3 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
   
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
  
            /*------------------------------------------
            --------------------------------------------
            Country Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#country-dropdown').on('change', function () {
                var idCountry = this.value;
                $("#state-dropdown").html('');
                $.ajax({
                    url: "{{url('api/fetch-states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#state-dropdown').html('<option value="">-- Select State --</option>');
                        $.each(result.states, function (key, value) {
                            $("#state-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });
            });
  
            /*------------------------------------------
            --------------------------------------------
            State Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#state-dropdown').on('change', function () {
                var idState = this.value;
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{url('api/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function (key, value) {
                            $("#city-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
  
        });
    </script>
@endsection

    
