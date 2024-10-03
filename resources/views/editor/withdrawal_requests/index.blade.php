@extends('layouts.editor')
@section('content')
<div class="col-12 p-3">
	<div class="col-12 col-lg-12 p-0 main-box">
	 
		<div class="col-12 px-0">
			<div class="col-12 p-0 row">
				<div class="col-12 col-lg-4 py-3 px-3">
					<span class="fas fa-articles"></span> طلبات السحب
				</div>
				<div class="col-12 col-lg-4 p-0">
				</div>
				<div class="col-12 col-lg-4 p-2 text-lg-end">
					<a href="{{route('editor.withdrawal_requests.create')}}">
						<span class="btn btn-primary"><span class="fas fa-plus"></span> إضافة جديد</span>
					</a>
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
			<div class="col-12 p-0" style="min-width:1100px;">
				
			
			<table class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>صاحب المحتوى</th>
						<th>المبلغ</th>
												<th>طريقة السحب</th>

						<th>الحالة</th>

						<th>تحكم</th>
					</tr>
				</thead>
				<tbody id="sortable-table">
					@foreach($withdrawal_requests as $i=>$withdrawal_request)
					<tr >
						<td>{{$withdrawal_request->id}}</td>
						<td><a href="{{route('editor.withdrawal_requests.show',$withdrawal_request->id)}}">{{$withdrawal_request->user->name}}</a></td>
												<td>{{$withdrawal_request->amount}}</td>

						<td>{{$withdrawal_request->payment_method}}</td>
												<td>@php
    $statusTranslations = [
        'approved' => 'موافقة',
        'rejected' => 'مرفوض',
        'pending' => 'قيد الانتظار'
    ];
@endphp

<span>{{ $statusTranslations[$withdrawal_request->status] ?? 'غير معروف' }}</span></td>

					 
						<td style="width: 270px;">
							@if($withdrawal_request->status=='pending')
							<a class="btn  btn-outline-success btn-sm font-1 mx-1" href="{{route('editor.withdrawal_requests.edit',$withdrawal_request->id)}}">
							<span class="fas fa-edit "></span> التحكم</a>

							@endif
							@if($withdrawal_request->status!='approved')
							<form method="POST" action="{{route('editor.withdrawal_requests.destroy',$withdrawal_request->id)}}" class="d-inline-block">@csrf @method("DELETE")
								<button class="btn  btn-outline-danger btn-sm font-1 mx-1" onclick="var result = confirm('هل أنت متأكد من عملية الحذف ؟');if(result){}else{event.preventDefault()}">
									<span class="fas fa-trash "></span> حذف
								</button>
							</form>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-12 p-3">
			{{$withdrawal_requests->appends(request()->query())->render()}}
		</div>
	</div>
</div>
@endsection

@section('scripts')




@endsection