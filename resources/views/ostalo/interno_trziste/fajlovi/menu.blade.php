<div class="row">
    <div class="steps-wizard" style="width:100%; margin-left:10px;">
        <ul class="four">
            <li class="{{ (request()->is('internotrziste.pregled')) ? 'active' : '' }} single_bar">
                <i class="fas fa-exclamation-triangle"></i>
                <a href="{{route('internotrziste.pregled')}}">Upražnjena radna mjesta</a>
            </li>
            <li class="single_bar">
                <i class="fas fa-exclamation-circle"></i>
                <a href="{{route('internotrziste.prekobrojniljudi')}}">Prekobrojni službenici</a>
            </li>
            <li class="single_bar">
                <i class="fas fa-briefcase"></i>
                <a href="{{route('internotrziste.privremeni.premjestaj')}}">Privremeni premještaj</a>
            </li>
        </ul>
    </div>
</div>