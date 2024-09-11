@extends('layouts.admin')
@section('content')
<style type="text/css">
	.ticket-resolved{
		background: #effff0!important;
	}
</style>
<div class="col-12 p-3">
	<div class="col-12 col-lg-12 p-0 main-box">
	 
		<div class="col-12 px-0">
			<div class="col-12 p-0 row">
				<div class="col-12 col-lg-4 py-3 px-3">
					<span class="fas fa-contacts"></span> طلبات الإنضمام
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
			<div class="col-12 p-0" style="min-width:1100px;">
				
			
			<table class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th>#</th>
					
						<th>صاحب الطلب</th>
						<th> الحساب</th>
						<th> عدد المتابعين</th>
						<th>الحالة</th>

						<th>تحكم</th>
					</tr>
				</thead>  
				<tbody>
					@foreach($joinRequests as $joinRequest)
					<tr 
					id="ticket_{{$joinRequest->id}}"
					class="@if($joinRequest->status=="approved") ticket-resolved @endif">
						<td>{{$joinRequest->id}}</td>
					
						 <td>
							{{$joinRequest->name}}
						 </td>
						 <td>
							{{$joinRequest->email}}
						 </td>
						 <td>
							{{$joinRequest->followers}}
						 </td>
						 <td>
							@if($joinRequest->status=='pending')
							قيد التنفيذ

							@elseif($joinRequest->status=='approved')
							تم الموافقة

							@elseif($joinRequest->status=="rejected")
							تم الرفض

							@endif
						 </td>
						
					
					 
						<td style="width: 180px;">
							@can('join-requests-read',$joinRequest)
							<a href="{{route('admin.join-requests.show',$joinRequest)}}">
							<span class="btn  btn-success btn-sm font-1 mx-1">
								<span class="fal fa-paper-plane"></span> معاينة
							</span>
							</a>
							@endcan
							@can('join-requests-delete',$joinRequest)
							<form method="POST" action="{{route('admin.join-requests.destroy',$joinRequest)}}" class="d-inline-block">@csrf @method("DELETE")
								<button class="btn  btn-outline-danger btn-sm font-1 mx-1" onclick="var result = confirm('هل أنت متأكد من عملية الحذف ؟');if(result){}else{event.preventDefault()}">
									<span class="fas fa-trash "></span> حذف
								</button>
							</form>
							@endcan
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-12 p-3">
			{{$joinRequests->appends(request()->query())->render()}}
		</div>
	</div>
</div>
@endsection
@section('scripts')
@can('contacts-update')
<script type="module">
	$('.toggle-contact-resolving').on('change',function(){
		var id =$(this).attr('data-id');
		$.ajax({
		  method: "POST",
		  url: "{{route('admin.join-requests.resolve')}}",
		  data: { _token: "{{csrf_token()}}", id: id }
		}).done(function(res){
			if(res.status=="DONE"){ 
				$('#ticket_'+id).addClass('ticket-resolved');
			}
			else{
				$('#ticket_'+id).removeClass('ticket-resolved');
			}
		});
	});
</script>
@endcan
@endsection