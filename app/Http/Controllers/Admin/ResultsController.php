<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GamesDataTable;
use App\DataTables\ResultsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Player;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PlayersDataTable;
use Yajra\DataTables\DataTables;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $points = 25;
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete|user-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:user-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:user-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index(ResultsDataTable $dataTable)
    {
        //
        return $dataTable->render('admin.results.all');
    }

    public function page()
    {
        //
        return view('admin.results.index');
    }

    public function getLight(ResultsDataTable $dataTable,$slug)
    {
        //
        if($slug == 'light' || $slug == 'medium' || $slug == 'strongest'){
        return $dataTable->render('admin.results.all',['slug' => $slug]);
        }else{
            return abort(404);
        }
    }


    public function getResultsDatatable($slug)
    {
        $data = Player::where('category',$slug);
        return   DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if(AdminCan('user-delete')) {
                    $btn .= '<a class="btn btn-primary ml-2" href="' . Route('admin.results.add', $row->id) . '" style="color:#fff;  cursor: pointer;"> إضافة النتائج</a>';
                }
                if(AdminCan('user-edit')){
                    $btn .= '<a class="btn btn-danger mr-2" id="ResetBtn" data-toggle="modal" data-target="#resetmodal" data-id="' . $row->id . '"  style="color:#fff; cursor: pointer;"> تصفير النتائج</a>';
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

    public function getAllResultsDatatable()
    {
        $data = Player::select('*');
        return   DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if(AdminCan('user-delete')) {
                    $btn .= '<a class="btn btn-primary ml-2" href="' . Route('admin.results.add', $row->id) . '" style="color:#fff;  cursor: pointer;"> إضافة النتائج</a>';
                }
                if(AdminCan('user-edit')){
                    $btn .= '<a class="btn btn-danger mr-2" id="ResetBtn" data-toggle="modal" data-target="#resetmodal" data-id="' . $row->id . '"  style="color:#fff; cursor: pointer;"> تصفير النتائج</a>';
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

    public function getGamesResultsDatatable($slug,$id)
    { //->with(['players'])
        $data = Result::where(['results.category' => $slug,'results.game' => $id])->orderBy('result','desc')
            ->join('players', 'players.id', '=', 'results.player_id')
            ->orderBy('players.wieght', 'asc')
            ->get()->all();

        return   DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('player_num', function ($row) {
//                dd($row->players());
                $player = Player::where(['id' => $row->player_id])->first();
                return $player->num;
            })
            ->addColumn('player_name', function ($row) {
                $player = Player::where(['id' => $row->player_id])->first();
                return $player->name;
            })
            ->addColumn('player_wieght', function ($row) {
                $player = Player::where(['id' => $row->player_id])->first();
                $symb = ' KG';
                return $player->wieght.$symb;
            })
            ->addColumn('result', function ($row) {
                return $row->result;
            })
            ->addColumn('points', function ($row) {
                $points = $this->points--;
                if($points < 0){
                    return 0;
                }else{
                    return $points;
                }
            })
            ->rawColumns(['player_name','player_num','player_wieght','result','points'])
            ->make(true);

    }

    public function getFinalResultsDatatable($slug)
    { //->with(['players']) where(['results.category' => $slug])->
        $data = Player::where(['players.category' => $slug])
            ->with(['results'])
            ->orderBy('players.final_result','desc')
            ->orderBy('players.wieght','asc')
            ->get()
        ->sortBy('results.result');
        return   DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('player_num', function ($row) {
                return $row->num;
            })
            ->addColumn('player_name', function ($row) {
                return $row->name;
            })
            ->addColumn('player_wieght', function ($row) {
                $symb = ' KG';
                return $row->wieght.$symb;
            })
            ->addColumn('result', function ($row) {
//                $result = Result::where(['player_id' => $row->id])->first();
//                dd($row->results);
                if(!empty($row->results)) {
                    $data = [];
                    foreach ($row->results as $res) {
                        $game = Game::where(['id' => $res->game])->first();
                        $data[] = '<div class="btn btn-primary" style="padding: 5px 2px;font-size: 12px;">' . $game->name . ' النتيجة : ' . $res->result . '</div>';
                    }
                    return implode(',', $data);
                }else{
                    return 'لم تتم إضافة نتائج لهذا اللاعب';
                }
            })
            ->addColumn('points', function ($row) {
                $data = [];
                if(!empty($row->results)) {
                    foreach ($row->results as $res) {
                        $data[] = $res->result;
                    }
                    return array_sum($data);
                }else{
                    return 'لم تتم إضافة نتائج لهذا اللاعب';
                }
            })
            ->rawColumns(['player_name','player_num','player_wieght','result','points'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.results.create');
    }

    public function add($player_id)
    {
        $player = Player::find($player_id);
        $player_team = '';
        if($player->team == 'bh'){$player_team = 'البحرين';}
        elseif($player->team == 'kw'){$player_team = 'الكويت';}
        elseif($player->team == 'ae'){$player_team = 'الإمارات';}
        elseif($player->team == 'qa'){$player_team = 'قطر';}
        elseif($player->team == 'om'){$player_team = 'عمان';}
        elseif($player->team == 'ks'){$player_team = 'السعودية';}
        else{$player_team = 'غير محدد';}
        $symb = ' KG';
        $player_wieght = $player->wieght.$symb;
        $category = '';
        if($player->category == 'light'){$category = 'الوزن الخفيف';}
        elseif($player->category == 'medium'){$category = 'الوزن المتوسط';}
        elseif($player->category == 'strongest'){$category = 'أقوى رجل خليجى';}
        else{$category = 'غير محدد';}
        $player_category = $category;

        $games = Game::orderBy('id','DESC')->get();
        $results = Result::where(['player_id' => $player_id])->get();
        return view('admin.results.create',['player' => $player,'player_team' => $player_team,'player_wieght' => $player_wieght,'player_category' => $player_category,'games' => $games,'results' => $results]);
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
//        dd($request->result);
//        $validator = Validator::make($request->all(), [
//            'distance'    => 'nullable',
//            'time'    => 'nullable',
//            'result'    => 'nullable',
//            'game'    => 'required',
//            'category'    => 'required',
//            'player_id'    => 'required',
//        ]);
        if(!empty($request->result)) {
            foreach ($request->result as $k => $res) {
                $valid_data[$k.'*.distance'] = 'nullable';
                $valid_data[$k.'*.time'] = 'nullable';
                $valid_data[$k.'*.result'] = 'nullable';
                $valid_data[$k.'*.game'] = 'nullable';
                $valid_data[$k.'*.category'] = 'nullable';
                $valid_data[$k.'*.player_id'] = 'nullable';
            }
        }

        $validator = Validator::make($request->all(), $valid_data);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $res = [];
        $player_id = '';
        if(!empty($request->result)) {
            foreach ($request->result as $key => $result) {
                if(!empty($result['distance'])){
                    $data[$key]['distance'] = $result['distance'];
                }
                if(!empty($result['time'])){
                    $data[$key]['time'] = $result['time'];
                }
                if(!empty($result['result'])){
                    $data[$key]['result'] = $result['result'];
                }else{
                    $data[$key]['result'] = ($result['time']/$result['distance']*30);
                }
                $data[$key]['game'] = $result['game'];
                $data[$key]['category'] = $result['category'];
                $data[$key]['player_id'] = $result['player_id'];
                $record = Result::where(['game'=>$result['game'],'player_id' => $result['player_id']]);
                if ($record->exists()) {
                    $res[] = $data[$key]['result'];
                    $player_id = $data[$key]['player_id'];
                    Result::where(['game'=> $result['game'],'player_id' => $result['player_id']])
                        ->update($data[$key]);
                }else{
                    $res[] = $data[$key]['result'];
                    $player_id = $data[$key]['player_id'];
                    Result::Create($data[$key]);
                }
                //$last_res = Result::orderBy('updated_at','DESC')->first();
            }
            //dd(array_sum($res),$player_id);
            Player::where(['id' => $player_id])->update(['final_result' => array_sum($res)]);
        }

        return redirect()->route('admin.results.index')->with([
            'message' => trans('admin/result.messages.created'),
            'alert_type' => 'success'
        ]);
    }

    public function reset(Request $request)
    {
        if (is_numeric($request->id)) {
            Result::where('player_id',$request->id)->delete();
            Player::where(['id' => $request->id])->update(['final_result' => '0']);

            return redirect()->route('admin.results.index')->with([
                'message' => trans('admin/result.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function cats(Request $request)
    {
        //
        $games = Game::all();
        $slug = $request->route('slug');
        if(!empty($slug)){
            return view('admin.results.games',['slug' => $slug,'games' =>$games]);
        }else{
            return view('admin.results.cats');
        }
    }

    public function game($slug,$id)
    {
        //
        $game = Game::find($id);
        $data = Result::where(['game' => $game->id]);
        return view('admin.results.game',['slug' => $slug,'game' =>$game,'data' =>$data]);
    }


    public function finalCats(Request $request)
    {
        //
        $slug = $request->route('slug');
        if(!empty($slug)){
            return view('admin.results.final',['slug' => $slug]);
        }else{
            return view('admin.results.final_cats');
        }
    }


}
