<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PlayersDataTable;
use Yajra\DataTables\DataTables;

class PlayersController extends Controller
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

    public function index(PlayersDataTable $dataTable)
    {
        //
        return $dataTable->render('admin.players.index');
    }


    public function getPlayersDatatable()
    {
        $data = Player::select('*');
        return   DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if(AdminCan('user-delete')) {
                    $btn .= '<a class="action_link" id="deleteBtn" data-toggle="modal" data-target="#deletemodal" data-id="' . $row->id . '"  data-color="#e95959" style="color: rgb(233, 89, 89);  cursor: pointer;"><i class="icon-copy dw dw-delete-3"></i></a>';
                }

                if(AdminCan('user-edit')){
                    $btn .= '<a class="action_link" href="' . Route('admin.players.edit', $row->id) . '"  data-color="#265ed7" style="color: rgb(38, 94, 215);"><i class="icon-copy dw dw-edit2"></i></a>';
                }
                return $btn;
            })
            ->addColumn('team', function ($row) {
                $team = '';
                if($row->team == 'bh'){$team = 'البحرين';}
                elseif($row->team == 'kw'){$team = 'الكويت';}
                elseif($row->team == 'ae'){$team = 'الإمارات';}
                elseif($row->team == 'qa'){$team = 'قطر';}
                elseif($row->team == 'om'){$team = 'عمان';}
                elseif($row->team == 'ks'){$team = 'السعودية';}
                else{$team = 'غير محدد';}
                return $team;
            })
            ->addColumn('category', function ($row) {
                $category = '';
                if($row->category == 'light'){$category = 'الوزن الخفيف';}
                elseif($row->category == 'medium'){$category = 'الوزن المتوسط';}
                elseif($row->category == 'strongest'){$category = 'أقوى رجل خليجى';}
                else{$category = 'غير محدد';}
                return $category;
            })
            ->addColumn('wieght', function ($row) {
                $symb = ' KG';
                return $row->wieght.$symb;
            })
            ->rawColumns(['action','team','category','wieght'])
            ->make(true);
    }

    public function getTrshedPlayersDatatable()
    {
        $data = Player::onlyTrashed();
        return   DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if(AdminCan('user-forcedelete')) {
                    $btn .= '<a class="action_link" id="deleteBtn" data-toggle="modal" data-target="#deletemodal" data-id="' . $row->id . '"  data-color="#e95959" style="color: rgb(233, 89, 89);  cursor: pointer;"><i class="icon-copy dw dw-delete-3"></i></a>';
                }

                if(AdminCan('user-forcedelete')) {
                    $btn .= '<a class="action_link" href="'.route('admin.players.restore',$row->id).'" data-color="#265ed7" style="cursor: pointer;"><i class="icon-copy dw dw-cursor-1"></i></a>';
                }
                return $btn;
            })
            ->addColumn('team', function ($row) {
                $team = '';
                if($row->team == 'bh'){$team = 'البحرين';}
                elseif($row->team == 'kw'){$team = 'الكويت';}
                elseif($row->team == 'ae'){$team = 'الإمارات';}
                elseif($row->team == 'qa'){$team = 'قطر';}
                elseif($row->team == 'om'){$team = 'عمان';}
                elseif($row->team == 'ks'){$team = 'السعودية';}
                else{$team = 'غير محدد';}
                return $team;
            })
            ->addColumn('category', function ($row) {
                $category = '';
                if($row->category == 'light'){$category = 'الوزن الخفيف';}
                elseif($row->category == 'medium'){$category = 'الوزن المتوسط';}
                elseif($row->category == 'strongest'){$category = 'أقوى رجل خليجى';}
                else{$category = 'غير محدد';}
                return $category;
            })
            ->addColumn('wieght', function ($row) {
                $symb = ' KG';
                return $row->wieght.$symb;
            })
            ->rawColumns(['action','team','category','wieght'])
            ->make(true);
    }

    public function archive()
    {
        //
        $users = Player::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.players.archive',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.players.create');
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
            'num'    => 'nullable',
            'wieght'    => 'nullable',
            'team'    => 'required',
            'category'    => 'required',
            'image'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name'] = $request->name;
        $data['num'] = $request->num;
        $data['wieght'] = $request->wieght;
        $data['team'] = $request->team;
        $data['category'] = $request->category;
        $data['image'] = $request->image;

        Player::Create($data);

        return redirect()->route('admin.players.index')->with([
            'message' => trans('admin/player.messages.created'),
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
        return view('admin.players.show',['user'=>$user]);
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
        $data = Player::find($id);
        return view('admin.players.edit',['data'=>$data]);
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
            'num'    => 'nullable',
            'wieght'    => 'nullable',
            'team'    => 'required',
            'category'    => 'required',
            'image'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $player = Player::find($id);

        $player->name = $request->name;
        $player->num = $request->num;
        $player->wieght = $request->wieght;
        $player->team = $request->team;
        $player->category = $request->category;
        $player->image = $request->image;

        $player->save();

        return redirect()->route('admin.players.index')->with([
            'message' => trans('admin/player.messages.edited',['name' => $player->name]),
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
        $item = Player::withTrashed()->find($request->id);
        if (is_numeric($request->id)) {
            if($item->trashed()){
                $item->forceDelete();
                return redirect()->route('admin.players.archive')->with([
                    'message' => trans('admin/player.messages.deleted'),
                    'alert_type' => 'success'
                ]);
            }else{
                $item->delete();
                return redirect()->route('admin.players.index')->with([
                    'message' => trans('admin/player.messages.deleted'),
                    'alert_type' => 'success'
                ]);
            }
        }

    }


    public function destroy($id)
    {
        //
        $item = Player::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.players.archive')->with([
                'message' => trans('admin/player.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.players.index')->with([
                'message' => trans('admin/player.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Player::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.players.archive')->with([
            'message' => trans('admin/player.messages.restored'),
            'alert_type' => 'success'
        ]);
    }



}
