<div class="row">
    <div class="steps-wizard" style="width:calc(100% + 10px); margin-left:36px;">
        <ul class="four">
            <li class="{{ (request()->is('disciplinska.pregled')) ? 'active' : '' }} single_bar">
                <i class="fas fas fa-gavel"></i>
                <a href="{{route('disciplinska.pregled')}}">{{__('Lista disciplinskih odgovornosti')}}</a>
            </li>
            <li class="{{ (request()->is('zalbe.pregled')) ? 'active' : '' }}single_bar">
                <i class="fas fa-volume-up"></i>
                <a href="{{route('zalbe.pregled')}}">{{__('Žalbe')}}</a>
            </li>
            <li class="{{ (request()->is('suspenzije.pregled')) ? 'active' : '' }} single_bar">
                <i class="fas fa-ban"></i>
                <a href="{{route('suspenzije.pregled')}}">{{__('Suspenzija')}}</a>
            </li>
        </ul>
    </div>
</div>