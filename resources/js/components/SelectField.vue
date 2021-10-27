<template>
  
    <div class="input-group flex-nowrap mt-2">
        <span class="input-group-text" id="addon-wrapping">{{nameDb}}</span>
        <select v-model="local" class="form-control" @change="selected">
            <option value="">Select</option>
            <option v-for="option,index in options" :value="option" :key="index">{{option}}</option>
        </select>
    </div>
   
</template>

<script>
    export default {
        props:{
            value: {
                required: true
            },
            nameDb:{
                required:true
            },
            options:{
                type:Array
            }
        },
        data() {
            return{
                local:null
            }
            
        },
        methods:{
            selected(){
                 this.$emit('input', this.local)
            }
        }
    }
</script>
