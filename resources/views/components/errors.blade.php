@if ($errors->any())
    <ul class="alert error mb-1 show">
        @foreach ($errors->all() as $error)
            <li> {{ $error }} </li>
        @endforeach
    </ul>
@endif
