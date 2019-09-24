<nav class="breadcrumbs_holder" aria-label="breadcrumb">



            <div class="container">
                <ul class="breadcrumbs">
                    @foreach($data as $key => $value)
                        <li class="breadcrumb-item @if($loop->last) active @endif"><a href="{{ $key }}">{{ $value }}</a></li>
                    @endforeach
                </ul>

            </div>



</nav>