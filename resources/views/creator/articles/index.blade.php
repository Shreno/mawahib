@extends('layouts.creator')
@section('content')
<div class="col-12 p-3">
	<div class="col-12 col-lg-12 p-0 main-box">
	 
		<div class="col-12 px-0">
			<div class="col-12 p-0 row">
				<div class="col-12 col-lg-4 py-3 px-3">
					<span class="fas fa-articles"></span> المقالات
				</div>
				<div class="col-12 col-lg-4 p-0">
				</div>
				<div class="col-12 col-lg-4 p-2 text-lg-end">
					<a href="{{route('user.articles.create')}}">
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
						<th>المستخدم</th>
						<th>صاحب المحتوى</th>

						<th>الشعار</th>
						<th>العنوان</th>
						<th>مميز</th>
						<th>زيارات</th>
						<th>تحكم</th>
					</tr>
				</thead>
				<tbody>
					@foreach($articles as $article)
					<tr>
						<td>{{$article->id}}</td>
						<td>{{$article->user->name}}</td>
						<td>{{$article->creator->name}}</td>

						{{-- <td>
							<a href="{{route('admin.categories.index',['id'=>$article->category_id])}}" style="color:#2381c6">{{$article->category->title_ar}}</a>
						</td> --}}
						<td><img src="{{asset('storage/'.$article->main_image())}}" style="width:40px"></td>
						<td>{{$article->title}}</td>

						<td>
							@if($article->is_featured==1)
							<span class="fas fa-check-circle text-success" ></span>
							@endif
						</td>
						<td>{{$article->views}}</td>
						<td style="width: 360px;">


							

							<a href="{{route('article.show',['article'=>$article])}}">
								<span class="btn  btn-outline-primary btn-sm font-1 mx-1">
									<span class="fas fa-search "></span> عرض
								</span>
							</a>
							
							{{-- <a href="{{route('admin.article-comments.index',['article_id'=>$article->id])}}">
								<span class="btn  btn-outline-primary btn-sm font-1 mx-1">
									<span class="fas fa-comments "></span> التعليقات
								</span>
							</a> --}}

							
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-12 p-3">
			{{$articles->appends(request()->query())->render()}}
		</div>
	</div>
</div>
@endsection
