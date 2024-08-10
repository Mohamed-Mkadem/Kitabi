@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="message error mb-1 show">
            {{ $error }}
        </div>
    @endforeach
@endif
