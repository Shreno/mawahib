@extends('layouts.creator')
@section('content')
<div class="col-12 p-3 row">
	<div class="user-profile text-center">
		<img  width="100px" height="100px" src="{{asset('storage/'.Auth()->user()->getUserAvatar())  }}" alt="{{ Auth()->user()->name }}" class="user-avatar">
		<div class="justify-content-center">
		<h4>{{ Auth()->user()->name }}</h4>
		<p>{{ Auth()->user()->email }}</p>
	
		<div class="profile-links">
			<a href="">رابط الإحالة</a>
			<a href="">رابط الإنضمام</a>
		</div>
	
		<div class="action-buttons">
			{{-- <button class="btn btn-primary">طلب كتابة محتوى ممول</button> --}}
			<a href={{route('user.withdrawal_equests.create')}} class="btn btn-success">سحب الأرباح</a>
		</div>
		</div>
	</div>
</div>





<div class="col-12 col-lg-12 px-2 py-2">
	<div style="height: 4px ;background: rgb(118 169 169);border-radius: 7px;transition: width .5s ease-in-out;width: 0%;" id="home-dashboard-divider"></div>
</div>
<div class="row">
<div class="col-md-6">
	<div class="col-12 px-0 py-1 d-flex main-box-wedit">
		<div style="width: 65px;" class="p-2">
			<div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background: #0194fe;color: #fff; border-radius: 50%;width: 55px;height:55px">
				{{-- <span class="fal fa-wallet font-5" ></span> --}}
				<i class="fa-solid fa-wallet"></i>
			</div>
		</div>
		<div style="width: calc(100% - 80px)" class="px-2 py-2">
			<a class="font-1" href="{{route('admin.contacts.index')}}" style="color: #212529;">
		          الرصيد الكلى 
				@php $wallet=\App\Models\Wallet::where('user_id',Auth()->user()->id)->first(); @endphp
				<h6 class="font-3">{{$wallet->balance}}</h6>
			</a> 
		</div>
	</div>
</div>
</div> 
{{-- <livewire:dashboard-statistics /> --}}
</div>
@endsection