<template>
  
    <div class="">
       <table class="table table-striped">
        <thead>
            <tr>
            
                <th scope="col" >Nombre</th>
                <th scope="col" >Fecha Nacimiento</th>
                <th scope="col" >Telefono</th>
                <th scope="col" >Dirección</th>
                <th scope="col" >Tarjeta de credito</th>
                <th scope="col" >Franquicia</th>
                <th scope="col" >Email</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="contact,index in contacts" :key="index">
                <th>{{contact.name}}</th>
                <th>{{contact.date_birth}}</th>
                <th>{{contact.phone}}</th>
                <th>{{contact.address}}</th>
                <th>{{contact.credit_card}}</th>
                <th>{{contact.franchise}}</th>
                <th>{{contact.email}}</th>
            </tr>
            
        </tbody>
        </table>
    </div>
   
</template>

<script>
    export default {
        props:{
           contacts:{
               type:Array,
               default:[]
           }
        },
        data() {
            return{
                
            }
            
        },
        methods:{
          
        },
        mounted(){
            
        }
    }
</script>
