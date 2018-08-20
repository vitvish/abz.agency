@extends('layouts.employee-edit')

@section('content')
    <div class="row">

        <div class="col-2">
            <img class="card-img-top" src="{{$update_user['image'] or '/images/no-image.png'}}" alt="Card image cap">
        </div>
        <div class="col">
            <form action="{{ route('employee.update', ['id' => $update_user['id']]) }}" method="post"
                  enctype="multipart/form-data" id="edit-form-submit">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="full_name" class="col-2 col-form-label">Full Name</label>
                    <div class="col-4">
                        <input class="form-control" name="full_name" type="text" value=" {{$update_user['full_name']}} "
                               id="full_name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="datetimepicker" class="col-2 col-form-label">Work day first</label>
                    <div class="col-4">
                        <input class="form-control" name="employeementDay" type="text"
                               placeholder="click to change date" value="{{$update_user['employeementDay']}}"
                               id="datetimepicker">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="salary" class="col-2 col-form-label">Salary</label>
                    <div class="col-4">
                        <input class="form-control" name="salary" type="text" value="{{$update_user['salary']}}"
                               id="salary">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="chief" class="col-2 col-form-label">Chief</label>
                    <div class="col-4">
                        <select name="parent_id" required id="parent_id" class="selectpicker-parent" data-live-search="true">
                            <option style="background: #8ed4f1"  disabled value="{{$update_user['root']['id']}}">{{$update_user['root']['full_name']}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="position" class="col-2 col-form-label">Position</label>
                    <div class="col-4">
                        <select required name="position_id" class="selectpicker" data-live-search="true">
                            <option style="background: #8ed4f1"  disabled value="{{$update_user['position']['id']}}">{{$update_user['position']['name']}}</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-2 col-form-label">Photo</label>
                    <div class="col-4">
                        <input type="file" name="image" class="" id="image">
                    </div>
                </div>
                <input type="submit" name="submit" value="Update" class="btn btn-primary">
            </form>
        </div>
    </div>
    <div class="alert alert-success text-center success-update" role="alert">
        Employee updated!!!
    </div>
    <div class="alert alert-danger error-update" role="alert">
        Update error!!!
    </div>
    <div class="alert alert-info file-update" role="alert">
        File Uploaded!!!
    </div>
@endsection