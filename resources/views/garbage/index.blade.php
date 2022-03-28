<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>@lang('garbage.help.title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css"
          integrity="sha512-1fPmaHba3v4A7PaUsComSM4TBsrrRGs+/fv0vrzafQ+Rw+siILTiJa0NtFfvGeyY5E182SDTaF5PqP+XOHgJag=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        :root {
            --bs-primary-rgb : 200, 100, 100;
        }

        .no-resize {
            resize : none;
        }

        td, th {
            white-space : nowrap;
        }

        a {
            text-decoration : none;
        }

        textarea, input {
            white-space   : pre;
            overflow-wrap : normal;
        }
    </style>
</head>
<body class="bg-dark">
<div class="container mt-4 p-4 bg-light rounded-3 shadow">
    <div class="row position-relative">
        <div class="col">
            <h1>@lang('garbage.help.title')</h1>
        </div>
        <form class="position-absolute end-0 w-auto" method="get">
            <select class="form-control" name="lang" oninput="this.form.submit()">
                <option value="da" {{ request()->query('lang') == 'da' ? 'selected' : null }}>Dansk</option>
                <option value="en" {{ request()->query('lang') == 'en' ? 'selected' : null }}>English</option>
            </select>
        </form>
    </div>
    <form method="post">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="form-group">
                    <input placeholder="{{ Str::title(__('common.address')) }}"
                           id="address"
                           type="text"
                           name="address"
                           autofocus
                           value="{{ request('address') }}"
                           class="form-control">
                </div>
            </div>
            <div class="col">
                <button class="btn btn-dark btn-block w-100">
                    {{ \Str::title(__('common.search')) }}
                </button>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col text-end">
                <button class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#schema-modal"
                        type="button">
                    Schema <i class="bi bi-code-slash"></i>
                </button>
                <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#automation-example-modal"
                        type="button">
                    Automation Example <i class="bi bi-code-slash"></i>
                </button>
                <button class="btn btn-sm btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#help-modal"
                        type="button">
                    Help / Installation <i class="bi bi-question-circle"></i>
                </button>
                <div class="dropdown d-inline-block">
                    <button class="btn btn-sm btn-danger dropdown-toggle"
                            data-bs-toggle="dropdown"
                            {{ $garbage ? '' : 'disabled' }}
                            type="button">
                        Download
                    </button>
                    <div class="dropdown-menu">
                        @if($garbage)
                            <a class="dropdown-item" href="{{ route('garbage.download', ['address' => request('address'), 'type' => 'yaml', 'lang' => App::getLocale()]) }}">
                                <code>garbage.yaml</code>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($error)
            <div class="row">
                <div class="col">
                    <hr>
                    <div class="alert alert-danger">
                        @if($error instanceof Exception)
                            @if($error instanceof \App\Apps\Garbage\Exceptions\CountyNotLocatedException)
                                <div>{{ $error->getMessage() }}.</div>
                                <div>
                                    @lang('garbage.help.supported-counties'):
                                    <ul>
                                        @foreach(\App\Apps\Garbage\Models\County::available() as $county)
                                            <li>{{ $county->name() }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                {{ $error->getMessage() }}
                            @endif
                        @else
                            {{ $error }}
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>

@include('garbage.schema')
@include('garbage.help')
@include('garbage.automation-example')


@if($garbage)
    <div class="container mt-4 p-4 bg-light rounded-3 shadow">
        <h2>{{ $garbage->address()->long() }} | {{ $garbage->county()->name() }}</h2>
        @foreach($garbage->services() as $slug => $service)
            @php($service = $service->toArray())
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>
                                {{ data_get($service, 'name') }} <small><code>({{ $slug }})</code></small>
                            </h3>
                            <div class="position-relative">
                                <input type="text"
                                       readonly
                                       id="{{ $slug }}-url"
                                       class="form-control form-control-sm font-monospace"
                                       value="{{ route('garbage.info', ['address' => Request::get('address'), 'segment' => $slug]) . '?lang=' . app()->getLocale() }}">
                                <button class="btn btn-sm btn-dark copy position-absolute bottom-0 end-0"
                                        data-clipboard-target="#{{ $slug }}-url">
                                    Copy URL
                                </button>
                            </div>
                            <div class="position-relative">
                                <textarea class="w-100 font-monospace form-control form-control-sm no-resize"
                                          rows="25"
                                          readonly
                                          id="{{ $slug }}-rest-yaml">
- platform: rest
  name: {{ data_get($service, 'service') }}
  resource: {{ route('garbage.info', ['address' => request('address'), 'segment' => $slug]) . '?lang=' . app()->getLocale() }}
  value_template: '@{{ value_json.title }}'
  scan_interval: 3600
  json_attributes:
  - name
  - title
  - address_long
  - address_short
  - service
  - state
  - next_date
  - next_local
  - next_local_short
  - next_day_long
  - next_day_short
  - next_day_min
  - next_in_days
  - next_in_weeks
  - next_in_months
  - next_in_human
  - next_is_today
  - next_is_tomorrow
  - next_is_this_week
  - next_is_this_month</textarea>
                                <button class="btn btn-sm btn-dark copy position-absolute bottom-0 end-0"
                                        data-clipboard-target="#{{ $slug }}-rest-yaml">
                                    Copy YAML
                                </button>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <h4>{{ Str::title(__('common.raw_data')) }}</h4>
                                </div>
                                <div class="col">
                                    <button class="btn btn-sm btn-dark float-end"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#{{ $slug }}-raw">
                                        <i class="bi bi-chevron-expand"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="collapse"
                                 id="{{ $slug }}-raw">
                            <textarea class="w-100 font-monospace form-control form-control-sm"
                                      rows="10"
                                      readonly>{{ json_encode($service,JSON_PRETTY_PRINT) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">

                </div>
                <div class="col-12 mt-2">
                    <div class="card">

                    </div>


                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>
        @endforeach
    </div>
@endif
<div class="container mt-4 p-4 bg-light rounded-3 shadow">
    <div class="row">
        <div class="col-12 col-lg">
            <small>
                No data is stored within this service apart from the cached address lookups for performance reasons
            </small>
            <small>
                Sensors are based on data fetched from interfaces similar to: <a target="__blank" href="https://jammerbugt.renoweb.dk/Legacy/selvbetjening/mit_affald.aspx">Jammerbugt Renoweb</a>
            </small>
        </div>
        <div class="col-12 col-lg text-lg-end">
            <small>
                Developer and maintained by
                <a target="__blank" href="https://www.facebook.com/ExeQue">
                    Morten Harders
                </a> |
                <a target="__blank" href="https://harders-it.dk/">
                    <i class="bi bi-globe"></i>
                </a> |
                <a target="__blank"
                   title="Feel free to connect"
                   href="https://www.linkedin.com/in/mortenharders//">
                    <i class="bi bi-linkedin"></i>
                </a>

            </small>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"
        integrity="sha512-iJh0F10blr9SC3d0Ow1ZKHi9kt12NYa+ISlmCdlCdNZzFwjH1JppRTeAnypvUez01HroZhAmP4ro4AvZ/rG0UQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
<script>
    new Clipboard('.copy');

    document.querySelectorAll('textarea[readonly], input[readonly]').forEach((elem) => {
        elem.addEventListener('click', event => {
            event.target.select();
        });
    });
</script>
</body>
</html>
