<base href="{{ url() }}" />

<!-- ======= Meta ======= -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="content-language" content="{{ current_locale() }}">
<meta name="viewport" content="width=device-width, initial-scale=1"/>

<meta name="name" content="{{ config('app.name') }}" />
<meta name="description" content="{{ config('app.name') }}">
<meta name="author" content="{{ config('app.name') }}">

@if(!empty(config('app.available_locales')))
    @foreach(config('app.available_locales') as $locale)
        <link rel="alternate" href="{{ current_url($locale) }}" hreflang="{{ $locale }}"/>
    @endforeach
@endif