<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Info;
use Log;

class InfoController extends Controller
{

    public function manageVue() {

        return view('manage-vue');
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $infos = Info::latest()->paginate(5);


        $response = [

            'pagination' => [

                'total' => $infos->total(),

                'per_page' => $infos->perPage(),

                'current_page' => $infos->currentPage(),

                'last_page' => $infos->lastPage(),

                'from' => $infos->firstItem(),

                'to' => $infos->lastItem()

            ],

            'data' => $infos

        ];
        return response()->json($response);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {

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
        $this->validate($request, [

            'name' => 'required|min:5|max:30',
            'phone' => 'required|min:11|max:15',
            'email' => 'required|unique:infos|max:50',
            'gender' => 'required',
            'dob' => 'required',
            'biography' => 'required|min:10|max:100',
            //'photo' => 'required|mimes:jpeg,bmp,jpg,png|size:1000',
            'photo' => 'required',
        ]);
        $explode=explode(",", $request->image);
        $decoded=base64_decode($explode[1]);
        
        if(str_contains($explode[0],'jpeg')){
            $extesion="jpg";
        }else{
            $extesion="png";
        }
        $fileName=str_random().".".$extesion;
        $path=public_path()."/".$fileName;
        //Log::debug($fileName);
        //return response()->json(['decoded'=>"decoded",'path'=>"path"]);
        file_put_contents($path, $decoded);
        $request->merge([ 'photo' => $fileName ]);
        /*Log::debug($fileName);
        Log::debug($path);*/
        //\LOG::info($request->all());


        //$create = Info::create($request->all());
        $create = Info::create($request->except('image'));


        return response()->json($create);

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
        //
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
        //
        //return response()->json(['id'=>$id]);
        $this->validate($request, [
            'name' => 'required|min:5|max:30',
            'phone' => 'required|min:11|max:15',
            'email' => 'required|email|unique:infos,email,'.$id,
            //'email' => 'required|email|unique:infos,id'.$id,
            'gender' => 'required',
            'dob' => 'required',
            'biography' => 'required|min:10|max:100',
            'photo' => 'required',
        ]);
        $explode=explode(",", $request->image);
        $decoded=base64_decode($explode[1]);
        
        if(str_contains($explode[0],'jpeg')){
            $extesion="jpg";
        }else{
            $extesion="png";
        }
        $fileName=str_random().".".$extesion;
        $path=public_path()."/".$fileName;
        //Log::debug($fileName);
        //return response()->json(['decoded'=>"decoded",'path'=>"path"]);
        file_put_contents($path, $decoded);
        $request->merge([ 'photo' => $fileName ]);
        /*Log::debug($fileName);
        Log::debug($path);*/
        //\LOG::info($request->all());


        //$create = Info::create($request->all());
        //$create = Info::create($request->except('image'));


        $edit = Info::find($id)->update($request->except('image'));


        return response()->json($edit);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Info::find($id)->delete();

        return response()->json(['done']);
    }
}
