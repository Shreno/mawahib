@extends('layouts.creator')
@section('content')
<div class="col-12 p-3">
	<!-- breadcrumb -->
	<x-bread-crumb :breads="[
			['url' => url('/admin') , 'title' => 'لوحة التحكم' , 'isactive' => false],
			['url' => route('user.transactions.index') , 'title' => 'الأرباح' , 'isactive' => true],
		]">
		</x-bread-crumb>
	<!-- /breadcrumb -->
	<div class="col-12 col-lg-12 p-0 main-box">
		<div class="col-12 px-0">
			<div class="col-12 p-0 row">
				<div class="col-12 col-lg-4 py-3 px-3">
					<span class="fas fa-users"></span>	 الحركة المالية 
				</div>
				<div class="col-12 col-lg-4 p-0">
				</div>
				
			</div>
			<div class="col-12 divider" style="min-height: 2px;"></div>
		</div>

		<div class=" py-2 px-2 row">
            <!--  -->
            <div style="" class=" col-lg-4 ">
			<a class="font-1" href="{{route('user.transactions.index')}}" style="color: #212529;">
		           إجمالى أرباحك 
				<h6 class="font-3">{{$totalEarnings}}</h6>
			</a> 
		</div>
		<div style="" class=" col-lg-4  ">
			<a class="font-1" href="{{route('user.transactions.index')}}" style="color: #212529;">
		          الرصيد الكلى 
				@php $wallet=\App\Models\Wallet::where('user_id',Auth()->user()->id)->first(); @endphp
				<h6 class="font-3">{{$wallet->balance}}</h6>
			</a> 
		</div>
		<div style="" class=" col-lg-4  ">
			<a class="font-1" href="{{route('user.transactions.index')}}" style="color: #212529;">
		          الرصيد المسحوب 
				@php $wallet=\App\Models\Wallet::where('user_id',Auth()->user()->id)->first(); @endphp
				<h6 class="font-3">{{$wallet->withdrawn_balance}}</h6>
			</a> 
		</div>



            <!--  -->
			<div class="col-12 col-lg-4 p-2">
				<form method="GET">
					<input type="text" name="q" class="form-control" placeholder="بحث ... " value="{{request()->get('q')}}">
				</form>
			</div>
		</div>
		<div class="col-12 p-3" style="overflow:auto">
			<div class="col-12 p-0" style="min-width:1100px;min-height: 600px;">
				
			
			<table class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>المعاملة</th>
						<th>المبلغ</th>
						<th>التاريخ</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
					<tr>
						<td>{{$transaction->id}}</td>
                        <td>
                        @if ($transaction->type == 'withdrawal')
                       <a href="{{ route('user.withdrawal_requests.show', $transaction->withdrawal_request_id) }}">
                         طلب السحب: {{ $transaction->withdrawal_request_id }}
    </a>
@elseif ($transaction->type == 'deposit')
    <a href="{{ route('article.show', $transaction->article) }}">
        ربح من المقال: {{ $transaction->article->title }}
    </a>
@endif
                        </td>

						<td>{{$transaction->amount}}</td>
                        <td>{{$transaction->created_at}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-12 p-3">
			{{$transactions->appends(request()->query())->render()}}
		</div>
	</div>
</div>
@endsection
