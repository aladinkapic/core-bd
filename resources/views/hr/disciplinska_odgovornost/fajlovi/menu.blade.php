<div class="steps-wizard">
    <ul class="five">
        <li class="{{ (request()->is('hr/disciplinska_odgovornost/home')) ? 'active' : '' }}">
            <i class="fas fas fa-gavel"></i>
            <a href="{{route('disciplinska.pregled')}}">{{__('Lista disciplinskih odgovornosti')}}</a>
        </li>
        <li class="{{ (request()->is('hr/disciplinska_odgovornost/pregled_zalbi')) ? 'active' : '' }}">
            <i class="fas fa-volume-up"></i>
            <a href="{{route('zalbe.pregled')}}">{{__('Žalbe')}}</a>
        </li>
        <li class="{{ (request()->is('hr/disciplinska_odgovornost/pregled_suspenzija')) ? 'active' : '' }}">
            <i class="fas fa-ban"></i>
            <a href="{{route('suspenzije.pregled')}}">{{__('Suspenzija')}}</a>
        </li>
    </ul>
</div>
