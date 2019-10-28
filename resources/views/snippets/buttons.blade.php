<!-- export to excel files -->
<button type="button" v-on:click="getVisibleColumns('excel')" class="btn btn-primary btn-xs" style="" id="export-button-excel"> <i class="fa fa-file-excel" style="font-size: 11px;"></i> {{__('Excel')}} </button>


<!-- export to word files -->
<button type="button" v-on:click="getVisibleColumns('word')" class="btn btn-primary btn-xs" style="" id="export-button-word"> <i class="fa fa-file-word" style="font-size: 11px;"></i> {{__('Word')}} </button>


<!-- export to PDF files -->
<button type="button" v-on:click="getVisibleColumns('pdf')" class="btn btn-primary btn-xs" style="" id="export-button-pdf"> <i class="fa fa-file-pdf" style="font-size: 11px;"></i> {{__('PDF')}} </button>
