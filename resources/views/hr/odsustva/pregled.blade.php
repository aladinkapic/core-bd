@extends('hr.odsustva.home')

@section('calendar')

    <div style="text-align: center;">
        <ul class="inline-ul">
            <li><i class="fa fa-arrow-left"></i></li>
            <li>{{__('Januar')}}</li>
            <li><i class="fa fa-arrow-right"></i></li>
        </ul>
    </div>

    <button class="btn btn-facebook pull-right"><i class="fa fa-plus-circle"></i> {{__('Dodaj odsustvo')}}</button>
    <hr />
    <table class="table table-bordered vacation-table">
        <tr>
            <td>{{__('Ponedjeljak')}}</td>
            <td>{{__('Utorak')}}</td>
            <td>{{__('Srijeda')}}</td>
            <td>{{__('Četvrtak')}}</td>
            <td>{{__('Petak')}}</td>
            <td>{{__('Subota')}}</td>
            <td>{{__('Nedjelja')}}</td>
        </tr>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
        </tr>
        <tr>
            <td>8</td>
            <td style="background-color: rgb(26, 147, 208); color: white;">9<br />
                {{__('Godišnji odmor')}}
            </td>
            <td style="background-color: rgb(26, 147, 208); color: white;">10<br />
                {{__('Godišnji odmor')}}
            </td>
            <td style="background-color: rgb(26, 147, 208); color: white;">11<br />
                {{__('Godišnji odmor')}}
            </td>
            <td>12</td>
            <td>13</td>
            <td>14</td>
        </tr>
        <tr>
            <td>15</td>
            <td>16</td>
            <td>17</td>
            <td>18</td>
            <td>19</td>
            <td>20</td>
            <td>21</td>
        </tr>
        <tr>
            <td>22</td>
            <td>23</td>
            <td>24</td>
            <td>25</td>
            <td>26</td>
            <td>27</td>
            <td>28</td>
        </tr>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
        </tr>
    </table>

    <hr />


    <div class="row">
        <div class="col-md-2">
            <img width="128" class="card-img-top rounded-circle img-thumbnail mx-auto d-block"  src="/images/amke.png" alt="Card image cap">
        </div>
        <div class="col-sm-10">
            <br />
            <h4>{{__('Amina Spahić')}}</h4>
            {{__('Viši stručni saradnik za upravljanje')}}<br />

        </div>
    </div>
@endsection