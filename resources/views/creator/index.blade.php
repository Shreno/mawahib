@extends('layouts.creator')
@section('content')
<div class="col-12 p-3 row">
	<div class="user-profile text-center">
		<img  width="100px" height="100px" src="{{asset('storage/'.Auth()->user()->getUserAvatar())  }}" alt="{{ Auth()->user()->name }}" class="user-avatar">
		<center>
		<h4>{{ Auth()->user()->name }}</h4>
		<p>{{ Auth()->user()->email }}</p>
	
		<div class="profile-links">
			<a href="">رابط الإحالة</a>
			<a href="">رابط الإنضمام</a>
		</div>
	
		<div class="action-buttons">
			<button class="btn btn-primary">طلب كتابة محتوى ممول</button>
			<button class="btn btn-success">سحب الأرباح</button>
		</div>
		</center>
	</div>
</div>

<div class="col-12 px-2 py-2">
	<div style="height: 4px ;background: rgb(118 169 169);border-radius: 7px;transition: width .5s ease-in-out;width: 0%;" id="home-dashboard-divider"></div>
</div>
{{-- <livewire:dashboard-statistics /> --}}
</div>
@endsection