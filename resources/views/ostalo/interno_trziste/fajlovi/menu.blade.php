<div class="steps-wizard">
    <ul class="five">
        <li class="{{ (request()->is('ostalo/interno_trziste/pregled')) ? 'active' : '' }}">
            <i class="fas fa-exclamation-triangle"></i>
            <a href="{{route('internotrziste.pregled')}}">{{__('Upražnjena radna mjesta')}}</a>
        </li>
        <li class="{{ (request()->is('ostalo/interno_trziste/prekobrojni_ljudi')) ? 'active' : '' }}">
            <i class="fas fa-exclamation-circle"></i>
            <a href="{{route('internotrziste.prekobrojniljudi')}}">{{__('Prekobrojni službenici')}}</a>
        </li>
        <li class="{{ (request()->is('ostalo/interno_trziste/privremeni_premjestaj')) ? 'active' : '' }}">
            <i class="fas fa-briefcase"></i>
            <a href="{{route('internotrziste.privremeni.premjestaj')}}">{{__('Privremeni premještaj')}}</a>
        </li>
    </ul>
</div>
