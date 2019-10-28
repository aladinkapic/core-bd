<ul>
    <li class="active">
        @if(isset($disciplinska))
            <div class="tab_div">
                <i class="fas fa-briefcase"></i>
                <p>{{__('Disciplinska odgovornost')}}</p>
            </div>

        @else
            <div class="list_div">
                <div class="back_div"></div>
                <div class="icon_circle">
                    <i class="fas fa-briefcase"></i>
                </div>
                <p>
                    {{__('Disciplinska odgovornost')}}
                </p>
            </div>
        @endif
    </li>
    <li class="">
        @if(isset($disciplinska))
            <div class="tab_div">
                <i class="fas fa-users"></i>
                <p>{{__('Disciplinska komisija')}}</p>
            </div>
        @else
            <div class="list_div">
                <div class="back_div"></div>
                <div class="icon_circle">
                    <i class="fas fa-users"></i>
                </div>
                <p>
                    {{__('Disciplinska komisija')}}
                </p>
            </div>
        @endif
    </li>
    <li>
        @if(isset($disciplinska))
            <div class="tab_div">
                <i class="fas fa-users"></i>
                <p>{{__('Medijatori')}}</p>
            </div>
        @else
            <div class="list_div">
                <div class="back_div"></div>
                <div class="icon_circle">
                    <i class="fas fa-users"></i>
                </div>
                <p>
                    {{__('Medijatori')}}
                </p>
            </div>
        @endif
    </li>
</ul>