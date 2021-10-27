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
                    <upload-file @reloadTable="reloadTable"></upload-file>
                </div>
                <div id="profile1" class="tab-pane fade ">
                    <contacts-table :contacts="contactsAll"></contacts-table>
                </div>
                <div id="messages1" class="tab-pane fade">
                    <fallidos :fallidos="fallidosAll"></fallidos>
                </div>
            </div>
            

      
    </div>
</template>

<script>
import UploadFile from "@/components/UploadFiles.vue";
import ContactsTable from "@/components/Contact.vue";
import Fallidos from "@/components/Fallidos.vue";


    export default {
        components:{UploadFile,ContactsTable,Fallidos},
        data(){
            return {
            csv_file:"",
            fallidosAll:[],
            contactsAll:[],
            campos:{
                name:""
            },
            report: null,
                loading: true,
                headers: [],
                sessions: 0,
            }  
        },
        methods:{
            getFallidos(){
                let _this = this;
                axios.get("admin/fallidos").then(function(response) {
                    _this.fallidosAll = response.data;
                }).catch(function(error) {});
            },
            getContacts(){
                let _this = this;
                axios.get("admin/contacts").then(function(response) {
                    _this.contactsAll = response.data;
                }).catch(function(error) {});
            },
            reloadTable(){
                this.getFallidos();
                this.getContacts();    
            }
        },
        mounted(){
            this.reloadTable();
        }
      
       
    }
</script>
