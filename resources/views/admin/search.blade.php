@extends('layouts.employee')

@section('content')
    <div class="form-group">
        <label for="usr">Search:</label>
        <form>
            {{ csrf_field() }}
            <input type="search" name="search" id="search" class="form-control" placeholder="Searching on any field">
        </form>
    </div>
    <p>Найдено сотрудников: <span class="total_records">Total count</span></p>
    <table class="table sortable">
        <thead>
        <tr class="gradient">
            <th class="head gradient" scope="col"><h3>#ID</h3></th>
            <th class="head" scope="col"><h3>Full Name</h3></th>
            <th class="head" scope="col"><h3>Photo</h3></th>
            <th class="head" scope="col"><h3>Employeement Day</h3></th>
            <th class="head" scope="col"><h3>Salary</h3></th>
            <th class="head" scope="col"><h3>Position</h3></th>
            <th class="head" scope="col"><h3>Chief</h3></th>
            <th class="head" scope="col"><h3>Edit | Delete</h3></th>
        </tr>
        </thead>
        <tbody>
            {{--Output result request--}}
        </tbody>
    </table>
    <div class="alert alert-success text-center success-delete" role="alert">
        Employee delete!!!
    </div>
    <div class="tbl-paginate"></div>

@endsection
