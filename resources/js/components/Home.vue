<template>
    <div class="container">



            <ul id="tabs" class="nav nav-tabs">
                <li class="nav-item"><a href="" data-target="#home1" data-toggle="tab" class="nav-link small text-uppercase active">Subir Archivo</a></li>
                <li class="nav-item"><a href="" data-target="#profile1" data-toggle="tab" class="nav-link small text-uppercase ">Contactos</a></li>
                <li class="nav-item"><a href="" data-target="#messages1" data-toggle="tab" class="nav-link small text-uppercase">Fallidos</a></li>
            </ul>
            <br>
            <div id="tabsContent" class="tab-content">
                <div id="home1" class="tab-pane fade active show">
                    <upload-file></upload-file>
                </div>
                <div id="profile1" class="tab-pane fade ">
                    <contacts></contacts>
                </div>
                <div id="messages1" class="tab-pane fade">
                    <fallidos></fallidos>
                </div>
            </div>
            

      
    </div>
</template>

<script>
import UploadFile from "@/components/UploadFiles.vue";
import Contacts from "@/components/Contact.vue";
import Fallidos from "@/components/Fallidos.vue";


    export default {
        components:{UploadFile,Contacts,Fallidos},
        data(){
            return {
            csv_file:"",
            campos:{
                name:""
            },
            report: null,
                loading: true,
                headers: [],
                sessions: 0,
            }  
        },
      
       
    }
</script>
