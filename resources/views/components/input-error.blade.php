@if ($errors->has($field))
    @foreach ($errors->get($field) as $error)
        <p class="error-message show"> {{ $error }} </p>
    @endforeach
@endif
