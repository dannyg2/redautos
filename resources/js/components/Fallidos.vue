<template>
  
    <div class="">
       <table class="table table-striped">
        <thead>
            <tr>
            
                <th scope="col" >Fila</th>
                <th scope="col" >Atributo</th>
                <th scope="col" >Error</th>
                <th scope="col" >Valor</th>

            </tr>
        </thead>
        <tbody>
            <tr v-for="fallido,index in fallidos" :key="index">
                <th>{{fallido.row}}</th>
                <th>{{fallido.attribute}}</th>
                <th>{{fallido.errors}}</th>
                <th>{{fallido.values}}</th>
            </tr>
            
        </tbody>
        </table>
    </div>
   
</template>

<script>
    export default {
       
        data() {
            return{
                fallidos:[]
            }
            
        },
        methods:{
          
        },
        mounted(){
            let _this = this;
            axios.get("admin/fallidos").then(function(response) {
                _this.fallidos = response.data;
                console.log(response);

            }).catch(function(error) {});
        }
    }
</script>
