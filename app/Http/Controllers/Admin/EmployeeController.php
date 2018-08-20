<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.search');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_employees = DB::table('employees')->pluck('full_name', 'id');
        $all_positions = \App\Position::all();
        return view('admin.create', ['employees' => $all_employees, 'positions' => $all_positions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('new-image')) {
            $image = route('root') . '/images/';
            $image .= $request->file('new-image')->store('/uploads', 'public');
        } else {
            $image = '';
        }
        $employee = Employee::create([
            "full_name" => $request->full_name,
            "employeementDay" => $request->employeementDay,
            "salary" => $request->salary,
            "position_id" => $request->position_id,
            "parent_id" => $request->parent_id,
            "image" => $image

        ]);
        $employee->save();
        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $all_positions = \App\Position::all();
        $edit_user = \App\Employee::with('position', 'root')->where('id', $id)->get()->toArray();
        return view('admin.edit', ['update_user' => $edit_user[0], 'positions' => $all_positions]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* Upload user file */
        if ($request->hasFile('image')) {
            $image = route('root') . '/images/';
            $image .= $request->file('image')->store('/uploads', 'public');
            $updated = DB::table('employees')->where('id', $id)->update([
                "image" => $image
            ]);
        } else {
            /* Update user profile */
            $updated = DB::table('employees')->where('id', $id)->update([
                'full_name' => $request->full_name,
                'employeementDay' => $request->employeementDay,
                "position_id" => $request->position_id,
                "parent_id" => $request->parent_id,
                'salary' => $request->salary
            ]);
        }

        $result = $updated ? true : false;
        return response()->json([
            'success' => $result
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $id_user = \App\Employee::find($id);
        $delete = $id_user->delete($id);
        return response()->json([
            'success' => $delete
        ]);
    }

    /**
     * Searching action for ajax search
     * @param  Request $request
     * @return String output json format
     */
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $sorted = $request->get('sorted');
            $fieldName = 'id';
            $sort = 'desc';
            if ($sorted != '') {
                list($field, $sort) = explode('|', $sorted);
                switch ($field) {
                    case 0:
                        $fieldName = 'id';
                        break;
                    case 1:
                        $fieldName = 'full_name';
                        break;
                    case 2:
                        $fieldName = 'image';
                        break;
                    case 3:
                        $fieldName = 'employeementDay';
                        break;
                    case 4:
                        $fieldName = 'salary';
                        break;
                    case 5:
                        $fieldName = 'position_id';
                        break;
                    case 6:
                        $fieldName = 'parent_id';
                        break;
                    default:
                        $fieldName = 'id';
                        $sort = 'desc';
                }
            }
            $pos = '';

            if ($query != '') {
                /* Get id by name in table positions */
                $pos_id = \App\Position::where('name', $query)->get();
                if ($pos_id->count() != 0) {
                    $pos = $pos_id[0]->id;
                }

                /* Search request on employees on all field */
                $data = \App\Employee::with('position')
                    ->where('full_name', 'like', "%$query%")
                    ->orWhere('employeementDay', 'like', "%$query%")
                    ->orWhere('salary', 'like', "%$query%")
                    ->orWhere('position_id', 'like', $pos)
                    ->orderBy($fieldName, $sort)
                    ->paginate(10);
            } else {

                /* Get all employees in relationship with positions */
                $data = \App\Employee::with('position')
                    ->orderBy($fieldName, $sort)->paginate(10);
            }
            /* Count employees in DB */
            $total_data = $data->total();

            /* String for output on ajax request */
            $out = '';

            if ($total_data > 0) {
                /* Generate string response by request user */
                foreach ($data as $item) {
                    /* Ternarny operator php7 */
                    $image = $item->image ?: '/images/no-image.png';
                    $out .= "
                        <tr>
                            <td>{$item->id}</td>
                            <td>{$item->full_name}</td>
                            <td><img class='employee-photo' src='" . $image . "' alt='image'></td>
                            <td>{$item->employeementDay}</td>
                            <td>$item->salary</td>
                            <td>{$item->position->name}</td>
                            <td>{$item->root['full_name']}</td>
                            <td><a href='" . route('employee.edit', ['id' => $item->id]) . "'><img class='action-human' src='/images/edit.png' alt='edit'></a>
                            <form style='display: inline;' id='employee-delete' action='" . route('employee.destroy', ['id' => $item->id]) . "'>
                                <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                <a href='#' onclick='deleteEmployee(this); return false;' class='del-employee'><img class='action-human' src='/images/delete.png' alt='delete'></a>
                            </form>
                            </td>
                        </tr>
                    ";
                }
            } else {
                $out = '<h1 class="text-center">No found!!!</h1>';
            }
            $pagin = "<div class='center'>{$data->links()}</div>";

            $data = [
                'table_data' => $out,
                'total_data' => $total_data,
                'table_paginate' => $pagin
            ];

            return response()->json($data);
        }
    }

    // Return all employees name & id for select in edit template
    public function getEmployeesForSelect(Request $request) {
        $result = [];
        if($request->ajax()) {
            $search = $request->get('search');
            if ($search != '') {
                /* Search request on employees on all field */
                $data = \App\Employee::where('full_name', 'like', "%$search%")
                    ->paginate(10);

                if($data->total() > 0) {
                    foreach ($data as $value) {
                        array_push($result, ['id' => $value->id, 'text' => $value->full_name]);
                    }                    
                }
            }
        }

        $result = [
            "results" => $result,
            "pagination" => [
                "more" => $data->lastPage()
            ]
        ];
        return response()->json($result);
    }

}
