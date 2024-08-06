<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GamesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PlayersDataTable;
use Yajra\DataTables\DataTables;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete|user-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:user-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:user-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index(GamesDataTable $dataTable)
    {
        //
        return $dataTable->render('admin.games.index');
    }


    public function getGamesDatatable()
    {
        $data = Game::select('*');
        return   DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if(AdminCan('user-delete')) {
                    $btn .= '<a class="action_link" id="deleteBtn" data-toggle="modal" data-target="#deletemodal" data-id="' . $row->id . '"  data-color="#e95959" style="color: rgb(233, 89, 89);  cursor: pointer;"><i class="icon-copy dw dw-delete-3"></i></a>';
                }

                if(AdminCan('user-edit')){
                    $btn .= '<a class="action_link" href="' . Route('admin.games.edit', $row->id) . '"  data-color="#265ed7" style="color: rgb(38, 94, 215);"><i class="icon-copy dw dw-edit2"></i></a>';
                }
                return $btn;
            })
            ->addColumn('level', function ($row) {
                $level = '';
                if($row->level == 'qualifiers'){$level = 'تصفيات';}
                elseif($row->level == 'standard'){$level = 'أساسية';}
                else{$level = 'غير محدد';}
                return $level;
            })
            ->addColumn('tries_type', function ($row) {
                $type = '';
                if($row->type == 'repetition'){$type = 'ألعاب التكرار';}
                elseif($row->type == 'distance'){$type = 'العاب المسافات';}
                elseif($row->level == 'qualifiers'){$type = $row->tries;}
                else{$type = 'غير محدد';}
                return $type;
            })
            ->rawColumns(['action','level','tries_type'])
            ->make(true);
    }

    public function getTrshedGamesDatatable()
    {
        $data = Game::onlyTrashed();
        return   DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if(AdminCan('user-forcedelete')) {
                    $btn .= '<a class="action_link" id="deleteBtn" data-toggle="modal" data-target="#deletemodal" data-id="' . $row->id . '"  data-color="#e95959" style="color: rgb(233, 89, 89);  cursor: pointer;"><i class="icon-copy dw dw-delete-3"></i></a>';
                }

                if(AdminCan('user-forcedelete')) {
                    $btn .= '<a class="action_link" href="'.route('admin.games.restore',$row->id).'" data-color="#265ed7" style="cursor: pointer;"><i class="icon-copy dw dw-cursor-1"></i></a>';
                }
                return $btn;
            })
            ->addColumn('level', function ($row) {
                $level = '';
                if($row->level == 'qualifiers'){$level = 'تصفيات';}
                elseif($row->level == 'standard'){$level = 'أساسية';}
                else{$level = 'غير محدد';}
                return $level;
            })
            ->addColumn('tries_type', function ($row) {
                $type = '';
                if($row->type == 'repetition'){$type = 'ألعاب التكرار';}
                elseif($row->type == 'distance'){$type = 'العاب المسافات';}
                elseif($row->level == 'qualifiers'){$type = $row->tries;}
                else{$type = 'غير محدد';}
                return $type;
            })
            ->rawColumns(['action','level','tries_type'])
            ->make(true);
    }

    public function archive()
    {
        //
        $users = Game::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.games.archive',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.games.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255|min:3|required',
            'level'    => 'required',
            'tries'    => 'nullable',
            'type'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name'] = $request->name;
        $data['level'] = $request->level;
        $data['tries'] = $request->tries;
        $data['type'] = $request->type;

        Game::Create($data);

        return redirect()->route('admin.games.index')->with([
            'message' => trans('admin/game.messages.created'),
            'alert_type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        return view('admin.games.show',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Game::find($id);
        return view('admin.games.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255|min:3|required',
            'level'    => 'required',
            'tries'    => 'nullable',
            'type'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $game= Game::find($id);

        $game->name = $request->name;
        $game->level = $request->level;
        $game->tries = $request->tries;
        $game->type = $request->type;
        $game->save();

        return redirect()->route('admin.games.index')->with([
            'message' => trans('admin/game.messages.edited',['name' => $game->name]),
            'alert_type' => 'success'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request)
    {
        $item = Game::withTrashed()->find($request->id);
        if (is_numeric($request->id)) {
            if($item->trashed()){
                $item->forceDelete();
                return redirect()->route('admin.games.archive')->with([
                    'message' => trans('admin/game.messages.deleted'),
                    'alert_type' => 'success'
                ]);
            }else{
                $item->delete();
                return redirect()->route('admin.games.index')->with([
                    'message' => trans('admin/game.messages.deleted'),
                    'alert_type' => 'success'
                ]);
            }
        }

    }


    public function destroy($id)
    {
        //
        $item = Game::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.games.archive')->with([
                'message' => trans('admin/game.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.games.index')->with([
                'message' => trans('admin/game.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Game::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.games.archive')->with([
            'message' => trans('admin/game.messages.restored'),
            'alert_type' => 'success'
        ]);
    }



}
