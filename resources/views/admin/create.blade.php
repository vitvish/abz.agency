@extends('layouts.employee-edit')

@section('content')
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col">
            <form action="{{ route('employee.store') }}" method="post"
                  enctype="multipart/form-data" id="create-form-submit">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="full_name" class="col-2 col-form-label">Full Name</label>
                    <div class="col-4">
                        <input class="form-control" name="full_name" required type="text" value=""
                               id="full_name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="datetimepicker" class="col-2 col-form-label">Work day first</label>
                    <div class="col-4">
                        <input required class="form-control" name="employeementDay" type="text"
                               placeholder="click to change date" value=""
                               id="datetimepicker">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="salary" class="col-2 col-form-label">Salary</label>
                    <div class="col-4">
                        <input required class="form-control" name="salary" type="text" value=""
                               id="salary">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="position" class="col-2 col-form-label">Position</label>
                    <div class="col-4">

                        <select required name="position_id" class="selectpicker" data-live-search="true">
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="chief" class="col-2 col-form-label">Chief</label>
                    <div class="col-4">
                        <select required name="parent_id" id="parent_id" class="selectpicker-parent"
                                data-live-search="true"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="new-image" class="col-2 col-form-label">Photo</label>
                    <div class="col-4">
                        <input type="file" name="new-image" class="" id="new-image">
                    </div>
                </div>
                <input type="submit" name="submit" value="Save" class="btn btn-primary">
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