<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\EmployeRequest;


class EmployeController extends Controller
{

    public function index(Request $request)
    {
        $emps = Employe::latest()->get();
        if( $request->ajax() ){
            return DataTables::of($emps)
             ->addIndexColumn()
             ->addColumn('post',function($row){
                $limit = Str::limit($row->post,20,'....');
                return $limit;
             })
             ->addColumn('action', function($row){
                $btn = '<a href="#" id="'. $row->id .'" class="editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>';
                $btn .= '<a href="#" id="' . $row->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>';
                return $btn;
             })
             ->rawColumns(['post','action'])
             ->make(true);
         }
         return view('employe.index');
    }

    public function create()
    {
        //
    }

    public function store(EmployeRequest $request)
    {
        Employe::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'post' => $request->get('post')
        ]);
            return response()->json([
                'status' => 200,
            ]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request)
    {
        $id = $request->id;
		$emp = Employe::find($id);
		return response()->json($emp);
    }

    public function update(Request $request, $id)
    {
        $employe = Employe::find($id);
        $params = $request->only(['name','email','phone','post']);
        $employe->update($params);
            return response()->json([
                'status' => 200,
            ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
		$emp = Employe::find($id);
        $emp->delete();
    }
}
