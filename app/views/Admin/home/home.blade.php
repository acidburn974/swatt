@extends('layout.admin')

@section('content')
	
			<h1>Dashboard Tracker :</h1>
			<div class="col-md-10" id="dashboard">
				<div class="col-md-2" id="admin-panel">
					<div class="panel padder-v item"> 
						<div class="h1 text-info font-thin h1">{{ $users }}</div>  
							<span class="text-muted text-xs">Users</span>
					</div>
				</div>
				<div class="col-md-2" id="admin-panel">
				<div class="panel padder-v item"> 
						<div class="h1 text-info font-thin h1">{{ $torrents }}</div>  
							<span class="text-muted text-xs">Torrents</span>
					</div>
				</div>
				<div class="col-md-2" id="admin-panel">
					<div class="panel padder-v item"> 
						<div class="h1 text-info font-thin h1">{{ $posts }}</div>  
							<span class="text-muted text-xs">News articles</span>
					</div>
				</div>
			<div class="col-md-3">
			<h2>Dernier billets :</h2>
				<p>ici les derniers billets</p>
			</div>
			</div>

@stop
