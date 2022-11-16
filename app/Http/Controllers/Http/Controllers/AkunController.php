<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Image;
use App\CabangModel;
use Illuminate\Support\Facades\Hash;
class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id','!=', Auth::user()->id)->get();
        return view('akun.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $cabang = CabangModel::all();
        return view('akun.create',compact('cabang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if($request->password != $request->confirm_password){
        //     return redirect(route('akun.create'))
        //     ->with([
        //         'pesan' => 'Password dan konfirmasi password tidak sama',
        //         'name'  => $request->name,
        //         'email' => $request->email,
        //         'hak_akses' => $request->hak_akses
        //     ]);
        // }
    
       $user = new User();

        $request['password'] = Hash::make($request->password);
        $user->name = $request->name;
        $user->cabang_id = $request->cabang_id;
        $user->email = $request->email;
        $user->userstatus = $request->userstatus;
        $user->password = $request->password;
        $user->hak_akses = $request->hak_akses;
        if ($request->hasFile('tandatangan')) {
            $file = $request->file('tandatangan');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/images/'.$name);
            $img = Image::make($file)->resize(200, 100, function($constraint) {
            $constraint->aspectRatio();
            });
            $img->save($destinationPath);
            $user->tandatangan = $name;

        }else{
            $user->tandatangan = $request->tandatangan;
        }

        $user->save();
        // dd($user);
        return redirect(route('akun.index'))->with('pesan','Berhasil Ditambah');

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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $cabang = CabangModel::all();
        return view('akun.edit',compact('user','cabang'));
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
        $request['password'] = Hash::make($request->password);
        User::find($id)->update($request->all());
        return redirect(route('akun.index'))->with('pesan','berhasil di update');
    }
    public function aktifuser(Request $request, $id)
    {
        
        $req=User::find($id);
        $req->update([
            'userstatus' => "aktif"
        ]);
        return redirect(route('akun.index'))->with('pesan','berhasil di update');
    }
    public function nonaktifuser(Request $request, $id)
    {
        
        $req=User::find($id);
        $req->update([
            'userstatus' => "nonaktif"
        ]);
        return redirect(route('akun.index'))->with('pesan','berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return back()->with('pesan','berhasil di hapus');
    }
}
