<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Auth;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     *  グループ画面表示 
     **/
    public function MainView() {
        Log::info('グループ画面表示 ID:'.Auth::user()->id);
        $groups = Group::get();
        return view('my_group', ['groups' => $groups]);
    }
    
    /**
     * グループ作成
     **/
    public function GroupCreate($group_name) 
    {
        return redirect('my_group'); 
    }
}
