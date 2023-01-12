<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<input type="file" name="file">
		<br><br>
		<button class="btn btn-success">Importボタンをクリック</button>
	</div>
<br>
</form>

<form action="{{ route('export') }}" method="POST">
	@csrf
	<a href="{{ route('export') }}">
	<button class="btn btn-success">Exportボタンをクリック</button>
	</a>
</form>
