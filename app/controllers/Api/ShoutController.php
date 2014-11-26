<?php

namespace Api;

use View, Request, Input, Auth, Redirect, Validator, Response;
use Shout, User;

class ShoutController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$shouts = Shout::orderBy('created_at', 'DESC')->take(10)->get()->reverse();
		foreach($shouts as &$s)
		{
			$s->username = $s->user->username;
		}

		return Response::json($shouts);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Auth::check())
		{
			$user = Auth::user();
			$s = new Shout();
			$s->content = Input::get('content');
			$s->user_id = $user->id;
			$v = Validator::make($s->toArray(), $s->rules);

			if($v->passes()) 
			{
				$s->save();
				return Response::json(array('message' => 'New shout added'), 200);
			}
		}
		return Response::json(array('message' => 'You must be connected'), 400);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$s = Shout::find($id);

		return Response::json($s, 200);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
