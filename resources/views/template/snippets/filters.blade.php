
   <div class="jumbotron" style="padding: 1em 1em;">
       <div class="row mt-2 mb-2">
           <div class="col-md-6">
               <form method="GET" action="" id="filter-form">
                   <div class="row">
                       <div class="col-md-8 append-filters">
                           <button type="button" class="btn btn-success btn-xs new-filter mb-2"><i
                                       class="fa fa-plus fa-1x"></i> {{__('Novi filter')}}
                           </button>

                           <div class="btn-group dropright" style="border: 0px;">
                               <button style="padding: 6px 10px !important;" type="button"
                                       class="btn btn-secondary btn-xs mb-2 dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                   <i class="fa fa-columns"></i> {{__('Kolone')}}
                               </button>
                               <div class="dropdown-menu return-none fill-column-names"
                                    style="height: 250px; overflow-y: scroll;">
                               </div>
                           </div>


                           <button type="submit" class="btn btn-primary btn-xs mb-2"><i
                                       class="fa fa-list fa-1x"></i> {{__('Pregled')}}
                           </button>

                           <div class="btn-group dropright" style="border: 0px;">
                               <button style="padding: 6px 10px !important;" type="button"
                                       class="btn btn-secondary btn-xs mb-2 dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                   <i class="fa fa-download fa-1x"></i> {{__('Izvoz')}}
                               </button>
                               <div class="dropdown-menu return-none " >
                                   <!-- export to excel files -->
                                   <a class="dropdown-item" v-on:click="getVisibleColumns('excel')" id="export-button-excel">
                                       <i class="fa fa-file-excel  mr-4" style="font-size: 11px;"></i> {{__('Excel')}}
                                   </a>


                                   <!-- export to word files -->
                                   <a v-on:click="getVisibleColumns('word')" class="dropdown-item" id="export-button-word">
                                       <i class="fa fa-file-word  mr-4" style="font-size: 11px;"></i> {{__('Word')}}
                                   </a>


                                   <!-- export to PDF files -->
                                   <a v-on:click="getVisibleColumns('pdf')" class="dropdown-item " id="export-button-pdf">
                                       <i class="fa fa-file-pdf mr-4" style="font-size: 11px;"></i> {{__('PDF')}}
                                   </a>

                               </div>
                           </div>


                           @foreach( (Request::has('filter') ? Request::get('filter') : [1 => 1]) as $kljuc => $vrijednost )
                               <div class="filter-row" >
                                   <div class="input-group mb-2 mt-2">
                                       <i class="fa fa-times fa-1x mt-2 mr-3 disable-popup remove-filter"
                                          style="color: red; cursor: pointer;"></i>
                                       <div class="input-group-prepend">
                                           <select class="form-control form-control-sm " required="required"
                                                   name="filter[]">
                                               <option value="">{{__('Odaberi...')}}</option>
                                               @foreach($filteri as $key => $value)
                                                   <option {{ ($key == $vrijednost) ? 'selected="selected"' : '' }} value="{{ $key ?? '/'}}">{{ $value ?? '/'}}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                       <input type="text" required="required" name="filter_values[]"
                                              value="{{ Request::get('filter_values')[$kljuc] }}"
                                              style="padding: 14.4px;" class="form-control form-control-sm">

                                   </div>
                               </div>

                           @endforeach
                       </div>

                   </div>
               </form>
           </div>
           <div class="col-md-6 text-right">
               @if(!isset($withoutPag))
                   <div class="col-md-12 mb-3">
                       {{__('Ukupno:')}} <b>{{ $var->total() }}</b> {{__('prikaži:')}}

                       <select form="filter-form" class="form-control form-control-sm col-md-2 d-inline-block" name="limit" onchange="this.form.submit()">
                           @foreach([15, 25, 50, 100, $var->total()] as $k)
                               <option {{ (request()->get('limit') == $k) ? 'selected="selected"' : '' }} value="{{ $k }}">{{ $k }}</option>
                           @endforeach
                       </select>

                   </div>
                   <div class="col-md-12 text-right pull-pagination-right">
                       {{ $var->appends(request()->query())->links() }}
                   </div>
               @endif
           </div>
       </div>
   </div>
