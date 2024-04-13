@if ($errors->any())
    <div class="toasts-holder mb-1 show">
        @foreach ($errors->all() as $error)
            <div class="toast error"> {{ $error }} </div>
        @endforeach
    </div>
@endif
