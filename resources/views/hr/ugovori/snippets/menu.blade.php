<div class="steps-wizard">
    <ul class="five">
        <li class="{{ (request()->is('ugovori/index')) ? 'active' : '' }}">
            <i class="fa fa-briefcase"></i>
            <a href="{{ route('ugovor.index') }}">{{__('Raspored na radno mjesto')}}</a>
        </li>
        <li class="{{ (request()->is('ugovori/mjesto-rada/*')) ? 'active' : '' }}">
            <i class="fas fa-map-marked"></i>
            <a href="{{ route('ugovor.mjesto_rada.index', ['id' => request()->route('id')]) }}">{{__('Mjesto rada službenika')}}</a>
        </li>
        <li class="{{ (request()->is('ugovori/privremeno/*')) ? 'active' : '' }}">
            <i class="fa fa-retweet"></i>
            <a href="{{ route('ugovor.privremeno.index') }}">{{__('Privremeni premještaj')}} </a>
        </li>
{{--        <li class="{{ (request()->is('ugovori/prestanak/*')) ? 'active' : '' }}">--}}
{{--            <i class="fa fa-ban"></i>--}}
{{--            <a href="{{ route('ugovor.prestanak.index') }}">{{__('Prestanak radnog odnosa')}} </a>--}}
{{--        </li>--}}
        <li class="{{ (request()->is('ugovori/dodatno/*')) ? 'active' : '' }}">
            <i class="fa fa-box"></i>
            <a href="{{ route('ugovor.dodatno.index') }}">{{__('Dodatne djelatnosti')}}</a>
        </li>
    </ul>
</div>
