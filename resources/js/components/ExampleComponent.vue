<template>
    <div class="card bg-light">
        <div class="card-header ads-darker">
            Napomena
        </div>
        <div class="card-body" style="padding:25px;">
                <div class="row" v-for="napomena in napomene">
                    <div class="col napomena">
                        {{napomena.napomena}}
                    </div>
                    <div class="col-1 xdiv" style="padding: 0;margin-top: 10px;">
                        <div class="napomenaDelete"  v-on:click="izbrisi(napomena.id);">
                            <i class="fas fa-times" ></i>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            <br>
            <form id = "napomenaForm" action="javascript:;" v-if="count < 5">
                <textarea maxlength="999" minlength="1" placeholder="Unesite Vašu napomenu..." class="form-control" v-model="napomena"></textarea>
                <br />
                <div  v-if="napomena.length>0" >
                    <button v-on:click="save();getdata();"class="btn btn-dark">Sačuvaj!</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                napomena:'',
                count:null,
                napomene:[],
                errors: {},
                success: false,
                loaded: true,
            }
        },
        mounted() {
            this.getdata();
        },
        methods:{
            save(){
                if (this.loaded) {
                    this.loaded = false;
                    this.success = false;
                    this.errors = {};
                    document.getElementById("loading_wrapper").style.display = 'block';
                    axios.post('/napomenaSubmit', "napomena = " + this.napomena).then(response => {
                        this.napomena = ''; //Clear input fields.
                        this.loaded = true;
                        this.success = true;
                        document.getElementById("loading_wrapper").style.display = 'none';
                        $.notify("Uspješno spremljena napomena !", successOptions);
                    })
                }
            },
            getdata(){
                axios.get('/napomenaCount').then(response => this.count = response.data);
                axios.get('/napomena').then(response => this.napomene = response.data);


            },
            izbrisi(id){
                document.getElementById("loading_wrapper").style.display = 'block';
                axios.get('/napomenaDelete/'+id).then( response => {
                    this.getdata();
                    document.getElementById("loading_wrapper").style.display = 'none';
                    $.notify("Uspješno ste obrisali napomenu !", "warn");
                });
            }
        }
    }
</script>
