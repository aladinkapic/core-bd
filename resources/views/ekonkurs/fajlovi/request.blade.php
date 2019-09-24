<div class="ekonkurs_w">
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif
    <div class="input_form">


        <form method="POST" action="">
            @csrf
        {!! Form::number('request', (request()->has('request')) ? request('request') : '', ['class' => 'custom_form', 'id' => 'id_prijave', 'placeholder' => 'ID prijave ..']) !!}
        <input type="submit" value="Unesite službenika" id="save_itt" >
        </form>
    </div>
</div>
@if(!is_null($sluzbenik) > 0)
<div class="container container_block" style="
    margin: 0;
    padding: 0;
    min-width: 100%;
">
    <div class="full_container">
        <div class="card-header ads-darker" style="height:60px;">
            @if(!isset($odsustva))
                <button onClick="window.location='{{route('sluzbenik.pregled')}}';" class="btn btn-light float-right" ><i class="fa fa-chevron-circle-left"></i> Nazad na pregled službenika </button>
            @endif
            <h4 style="position:absolute; margin-top:-6px;">
                @if(isset($sluzbenik))
                    {{$sluzbenik->ime}} {{$sluzbenik->prezime}}
                @else
                    Unesite službenika
                @endif
            </h4>
        </div>
    </div>
    <input type="hidden" name="ekonkurs" id="ekonkurs" value="1" />
    <input type="hidden" name="ekonkurs_prijava" id="ekonkurs_prijava" value="{{ request()->get('request') }}" />
    @include('hr/sluzbenici/fajlovi/dodaj_sluz')
</div>
@endif