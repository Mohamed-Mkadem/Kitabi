@if (session()->has('error'))
    <div class="alert error show">
        {{ session()->get('error') }}
    </div>
@endif
