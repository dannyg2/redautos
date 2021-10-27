<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="alert alert-success" role="alert" v-if="mensaje">
                Archivo cargado
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Subsir archivos</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Default file input example</label>
                            <input class="form-control" type="file" name="inputcsv" id="inputcsv" @change="onFileChange" >
                        </div>
                       

                        <br>
                        <h3>Asocie campos archivo</h3>

                        <select-field v-model="campos.name" nameDb="Nombre" :options="headers"></select-field>
                        <span v-if="allerrors.name" :class="['text-danger']">{{ allerrors.name[0] }}</span>
                        <select-field v-model="campos.date" nameDb="Fecha de nacimiento" :options="headers" ></select-field>
                        <span v-if="allerrors.date" :class="['text-danger']">{{ allerrors.date[0] }}</span>
                        <select-field v-model="campos.phone" nameDb="Teléfono" :options="headers" ></select-field>
                        <span v-if="allerrors.phone" :class="['text-danger']">{{ allerrors.phone[0] }}</span>
                        <select-field v-model="campos.address" nameDb="Dirección" :options="headers" ></select-field>
                        <span v-if="allerrors.address" :class="['text-danger']">{{ allerrors.address[0] }}</span>
                        <select-field v-model="campos.credit_card" nameDb="Tarjeta de crédito" :options="headers" ></select-field>
                        <span v-if="allerrors.credit_card" :class="['text-danger']">{{ allerrors.credit_card[0] }}</span>
                        <select-field v-model="campos.franchise" nameDb="Franquicia" :options="headers" ></select-field>
                        <span v-if="allerrors.franchise" :class="['text-danger']">{{ allerrors.franchise[0] }}</span>
                        <select-field v-model="campos.email" nameDb="Correo electrónico" :options="headers" ></select-field>
                        <span v-if="allerrors.email" :class="['text-danger']">{{ allerrors.email[0] }}</span>
                        <br>
                        <button @click="contactos" class="btn btn-success">Cargar Archivo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SelectField from "@/components/SelectField.vue";
    export default {
        components:{SelectField},
        data(){
            return {
                mensaje:false,
                csv_file:"",
                allerrors:[],
                campos:{
                    name:""
                },
                report: null,
                    loading: true,
                    headers: [],
                    sessions: 0,
                }  
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            onFileChange(e){
             this.message = "";
                this.loading = true;
                let allowedExtensions = /(\.csv)$/i;
                let input = e.target;
                if (input.files && input.files[0]) {
                    this.csv_file = e.target.files[0];
                    if (!allowedExtensions.exec(input.value)){
                        this.message = "El archivo debe ser .csv";
                        return;
                    }
                    var reader = new FileReader();
     
                    reader.onload = async (e) => {
                        const parts = e.target.result.split("base64,");
                      
                        if(parts.length > 0){
                            const base64 = parts[1];
                            await this.base64ToString(base64).then(data => {
                                this.report = this.csvJSON(data);
                                console.log(this.report );
                                this.loading = false;
                            }).catch(error => {
                                console.log(error);
                                this.message = "No fue posible leer el documento";
                            })
                        }else{
                            this.message = "No se puedo leer el documento"
                        }
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            },
            async base64ToString(base64){
                return new Promise((resolve, reject) => {
                    const data = decodeURIComponent(escape(window.atob(base64)));
                    if(data == null){
                        return reject(new Error("No fue posible leer la cadena"));
                    }
                    return resolve(data);
                })
            },
          csvJSON(csv){

                var lines=csv.split("\n");
                var result = {};
                var headers=lines[0].split(";");
                this.headers = headers.map(item => {
                    item = item.split("").filter(letter => {
                        const regex = /^[a-zA-Z0-9]*$/;
                        return regex.test(letter);
                    }).join("");
                    console.log(item);
                    return item.normalize("NFD").toLowerCase();
                });

                return result;
            },
            contactos(){
                let formData = new FormData();
                formData.append('csv_file', ((this.csv_file)?this.csv_file:""));
                formData.append('campos', JSON.stringify(this.campos));
                let _this = this;
                axios.post("admin/upload", formData).then(function(response) {
                    _this.mensaje = true;
                    _this.csv_file = "";
                    _this.campos = {};
                    _this.headers = [];
                    this.$emit('reloadTable')
                }).catch(function(error) {
                    console.log(error.response);
                    _this.allerrors = error.response.data;
                });
            }
        }
    }
</script>
