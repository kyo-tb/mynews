<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;

use App\Models\Process;

use Carbon\Carbon;


class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    
    public function create(Request $request)
    {
        // 以下を追記
        // Validationを行う
        $this->validate($request, Profile::$rules);

        $profile = new Profile;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $profile->fill($form);
        $profile->save();
        
        // admin/profile/createにリダイレクトする
        return redirect('admin/profile/create');
    }
    

    public function edit(Request $request)
    {
        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    
    
    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Profile::$rules);
        // News Modelからデータを取得する
        $profile = Profile::find($request->id);
        // 送信されてきたフォームデータを格納する
        $profile_form = $request->all();
        
        // 該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();
        
        // 以下を追記
        $processes = new Process();
        $processes->profile_id = $profile->id;
        $processes->edited_at = Carbon::now();
        $processes->save();
        
        // return redirect('admin/profile/edit');
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    
}
