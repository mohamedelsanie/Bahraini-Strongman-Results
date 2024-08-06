<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Game;
use App\Models\Image;
use App\Models\News;
use App\Models\Order;
use App\Models\Page;
use App\Models\PageComment;
use App\Models\Player;
use App\Models\Result;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    //
    public function index()
    {
        $games = Game::all();

        $players = Player::with(['results'])
            ->orderBy('players.final_result','desc')
            ->orderBy('players.wieght','asc')
            ->get()
            ->sortBy('results.result');
        return view('front.homepage',['games' => $games,'players' => $players]);
    }


    public function search(Request $request)
    {
        $games = Game::all();
        if($request->game != 'all') {
            if($request->category != 'all') {
                $results = Result::where(['results.category' => $request->category, 'results.game' => $request->game])->orderBy('result', 'desc')
                    ->join('players', 'players.id', '=', 'results.player_id')
                    ->orderBy('players.wieght', 'asc')
                    ->get()->all();
            }else{
                $results = Result::where(['results.game' => $request->game])->orderBy('result', 'desc')
                    ->join('players', 'players.id', '=', 'results.player_id')
                    ->orderBy('players.wieght', 'asc')
                    ->get()->all();
            }
        }else{
            if($request->category != 'all') {
                $results = Player::where(['players.category' => $request->category])->with(['results'])
                    ->orderBy('players.final_result', 'desc')
                    ->orderBy('players.wieght', 'asc')
                    ->get()
                    ->sortBy('results.result');
            }else{
                $results = Player::with(['results'])
                    ->orderBy('players.final_result', 'desc')
                    ->orderBy('players.wieght', 'asc')
                    ->get()
                    ->sortBy('results.result');
            }
        }

        if($request->game == 'all'){
            $tgame = 'الكل';
        }else{
            $tgame = Game::where(['id' => $request->game])->first();
        }
        if($request->category == 'light'){
            $category = 'الوزن الخفيف';
        }elseif($request->category == 'medium'){
            $category = 'الوزن المتوسط';
        }elseif($request->category == 'strongest'){
            $category = 'أقوى رجل خليجى';
        }else{
            $category = 'الكل';
        }
//        dd($results);
        return view('front.results',['results' => $results,'games' => $games,'tgame' => $tgame,'category' => $category]);
    }

    public function orders()
    {
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(getSetting('posts_per_page'));
//        dd($orders[0]->tour);
        return view('dashboard',['orders' => $orders]);
    }
    public function closed()
    {
        return view('closed');
    }

    public function send_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255|min:3|required',
            'email'    => 'required',
            'subject'    => 'required',
            'message'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['from_name'] = $request->name;
        $data['from_email'] = $request->email;
        $data['subject'] = $request->subject;
        $data['massege'] = $request->message;

        Contact::Create($data);

        return redirect()->back()->with([
            'message' => 'تم إرسال الرسالة بنجاح',
            'alert_type' => 'success'
        ]);
    }
}
