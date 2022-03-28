@foreach($garbage->services() as $slug => $service)
    @include('garbage.download.service', ['service' => $service])
@endforeach


