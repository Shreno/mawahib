@extends('layouts.admin')
@section('content')
<div class="col-12 p-3">
	<!-- breadcrumb -->
	<x-bread-crumb :breads="[
			['url' => url('/admin') , 'title' => 'لوحة التحكم' , 'isactive' => false],
			['url' => route('admin.wallets.index') , 'title' => ' المحافظ الإلكترونية' , 'isactive' => true],
		]">
		</x-bread-crumb>
	<!-- /breadcrumb -->
	<div class="col-12 col-lg-12 p-0 main-box">
		<div class="col-12 px-0">
			<div class="col-12 p-0 row">
				<div class="col-12 col-lg-4 py-3 px-3">
					<span class="fas fa-users"></span>	 المحافظ الإلكترونية
				</div>
				<div class="col-12 col-lg-4 p-0">
				</div>
				
			</div>
			<div class="col-12 divider" style="min-height: 2px;"></div>
		</div>

		<div class="col-12 py-2 px-2 row">
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
						<th>المستخدم</th>
						<th> الرصيد الكلى</th>
						<th> الرصيد المسحوب</th>
						<th>التعاملات</th>
					</tr>
				</thead>
				<tbody>
					@foreach($wallets as $i=>$wallet)
					<tr>
						<td>{{$i+1}}</td>
						<td><a>{{$wallet->user->name}}</a></td>
						<td>{{$wallet->balance}}</td>
                        <td>{{$wallet->withdrawn_balance}}</td>
						<td>
						@can('wallets-read')
							<a href="{{route('admin.wallets.show',$wallet)}}">
								<span class="btn  btn-outline-success btn-sm font-1 mx-1">
									<span class="fas fa-eye "></span> التفاصيل
								</span>
							</a>
							@endcan
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-12 p-3">
			{{$wallets->appends(request()->query())->render()}}
		</div>
	</div>
</div>
@endsection
