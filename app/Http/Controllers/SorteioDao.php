<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
Use Exception;

class SorteioDao extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Array $newData = null, $table = 'jogadores')
    {
        $id = DB::table($table)->insertGetId($newData);
        return $id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($filters = array(), $table = 'jogadores')
    {
        $where = array();
        if(!empty($filters)) {
            $where = array_filter($filters);
        }
        $resp = DB::table($table)
            ->where(function($query) use($where) {
                if(isset($where) && !empty($where)) {
                    foreach ($where as $k => $v) {
                        $query->where($k, '=', "{$v}");
                    }
                }
            })
            ->get();

        return $resp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Array $dadosPost = array(), $table = 'jogadores', $ids = array()
        ) {
            
        try {
            if(!empty($ids)) {
                $ok = DB::table($table)
                    ->where($ids)
                    ->update($dadosPost);
            } else {
                $ok = DB::table($table)
                    ->insert($dadosPost);
            }
        } catch(\Illuminate\Database\QueryException $ex){ 
            return ['error' => 'error update user' . $ex->getMessage()]; 
        }
        
            return [$ok];
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
    }
}
