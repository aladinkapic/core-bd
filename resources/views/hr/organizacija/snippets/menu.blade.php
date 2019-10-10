

<div class="steps-wizard">
    <ul class="three">
        <li class="{{ (request()->is('organizacija/edit/*')) ? 'active' : '' }}">
            <i class="fa fa-box"></i>
            <a href="{{ route('organizacija.edit', ['id' => $organizacija->id]) }}">{{__('Organizacione jedinice')}}</a>
        </li>
        <li class="{{ (request()->is('organizacija/radna-mjesta/*')) ? 'active' : '' }}">
            <i class="fa fa-box"></i>
            <a href="{{ route('organizacija.radna-mjesta', ['id' => request()->route('id')]) }}">{{__('Radna mjesta')}}</a>
        </li>
        <li class="{{ (request()->is('organizacija/shema/*')) ? 'active' : '' }}">
            <i class="fa fa-search"></i>
            <a href="{{ route('organizacija.shema', ['id' => request()->route('id')]) }}">{{__('Shematski prikaz')}}</a>
        </li>


    </ul>
</div>

<br />
@if(Session::has('message'))
    <p class="alert alert-success">{{ Session::get('message') }}</p>
@endif