@extends('layouts.creator')
@section('content')
<div class="col-12 p-3">
	<div class="col-12 col-lg-12 p-0 main-box">
	 
		<div class="col-12 px-0">
			<div class="col-12 p-0 row">
				<div class="col-12 col-lg-4 py-3 px-3">
					<span class="fas fa-comments"></span> عرض الكل
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
						<th style="width:25px;">#</th>
						<th style="width:100px;">تمت المراجعة</th>
						<th>المحتوى</th>
						@if(auth()->user()->hasRole('superadmin'))
						<th>ip</th>
						@endif
						<th style="width:250px;">المقال</th>
						<th style="width:170px;">تحكم</th>
					</tr>
				</thead>
				<tbody id="sortable-table">
					@foreach($comments as $comment)
					<tr >
						<td class="ui-state-default drag-handler" data-comment="{{$comment->id}}">{{$comment->id}}</td>
					
						<td>
							 

							<div class="form-switch">
		                      <input name="id" class="form-check-input change_comment_status" type="checkbox" id="flexSwitchCheckDefault" {{old('reviewed',$comment??0)=="1"?"checked":""}} style="width: 50px;height:25px" value="1" data-id="{{$comment->id}}">
		                    </div>

						</td>
						<td>
							{{$comment->content}}
						</td>
					
						<td>
							<a href="{{route('article.show',['article'=>$comment->article,'user'=>$comment->article->user])}}" >{{mb_strimwidth(($comment->article->title), 0, 80, "...")}}</a>
						</td>
						<td style="width: 170px;">

					 

							<a href="{{route('user.article-comments.edit',$comment)}}">
								<span class="btn  btn-outline-success btn-sm font-1 mx-1">
									<span class="fas fa-wrench "></span> تحكم
								</span>
							</a>
							<form method="POST" action="{{route('user.article-comments.destroy',$comment)}}" class="d-inline-block">@csrf @method("DELETE")
								<button class="btn  btn-outline-danger btn-sm font-1 mx-1" onclick="var result = confirm('هل أنت متأكد من عملية الحذف ؟');if(result){}else{event.preventDefault()}">
									<span class="fas fa-trash "></span> حذف
								</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-12 p-3">
			{{$comments->appends(request()->query())->render()}}
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script type="module">
	$('.change_comment_status').on('change',function(){
		$.ajax({
			url:"{{route('user.article-comments.change_status')}}",
			method:"POST",
			data:{_token:"{{csrf_token()}}",id:$(this).attr('data-id')}
		}).done(function(res){
		});
	});
</script>
@endpush