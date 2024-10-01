@extends('layouts.creator')
@section('content')
<div class="col-12 p-3">
	<!-- breadcrumb -->
	<x-bread-crumb :breads="[
			['url' => url('/admin') , 'title' => 'لوحة التحكم' , 'isactive' => false],
			['url' => route('admin.earnings.index') , 'title' => 'الأرباح' , 'isactive' => true],
		]">
		</x-bread-crumb>
	<!-- /breadcrumb -->
	<div class="col-12 col-lg-12 p-0 main-box">
		<div class="col-12 px-0">
			<div class="col-12 p-0 row">
				<div class="col-12 col-lg-4 py-3 px-3">
					<span class="fas fa-users"></span>	 الأرباح
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
						<th>المقال</th>
						<th>نسبة الموقع</th>
						<th>نسبة صاحب المحتوى</th>
						<th>الأرباح الكلية</th>
					    <th> التفاصيل</th>

					</tr>
				</thead>
				<tbody>
					@foreach($earnings as $earning)
					<tr>
						<td>{{$earning->id}}</td>
						<td><a href="{{route('article.show',['article'=>$earning->article])}}">{{$earning->article->title}}</a></td>
						<td>{{$earning->site_share}}</td>
                        <td>{{$earning->creator_share}}</td>
						<td>{{$earning->total_revenue}}</td>
						<td>

							<a href="{{route('user.earnings.show',$earning->article)}}">
								<span class="btn  btn-outline-success btn-sm font-1 mx-1">
									<span class="fas fa-eye "></span> التفاصيل
								</span>
							</a>
							</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-12 p-3">
			{{$earnings->appends(request()->query())->render()}}
		</div>
	</div>
</div>
@endsection
