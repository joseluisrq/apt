<template>
     <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
            <i class="mdi mdi-bell"></i>
            <span class="count">{{notificacion.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
            <a class="dropdown-item">
            <p class="mb-0 font-weight-normal float-left">{{notificacion.length}}
            </p>
            <span class="badge badge-pill badge-warning float-right">NOTIFICACIONES</span>
            </a>
            <!--Lista de notificaciones-->
       
                <div v-if="notificacion.length">
                    <li v-for="item in notificacion" :key="item.id">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-warning">
                                {{item.data.datos.creditos.numero}}
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-medium text-dark">{{item.data.datos.creditos.msj}}</h6>
                                <p class="font-weight-light small-text">
                            
                                </p>
                            </div>
                        </a>
                    </li>
                </div>
                <div v-else>
                     <div class="dropdown-divider"></div>
                     <span>No tiene notificaciones</span>
                </div>
                <div v-if="arrayCuotas.length">
                    <li v-for="not in arrayCuotas" :key="not.id">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-warning">
                                {{not.fechapago}}
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-medium text-dark">{{item.data.datos.creditos.msj}}</h6>
                                <p class="font-weight-light small-text">
                            
                                </p>
                            </div>
                        </a>
                    </li>
                </div>
                <button type="button"  @click="cuotasAtrasadas()"></button>
        
              <!--Fin lista de notificaciones-->
            
          
        </div>
    </li>
</template>
<script>
export default {
    props:['notificacion','ruta'],
    data(){
        return{
            arrayNotifications:[],
            fechadepago:'Tines 15 dias para reportar',
            arrayCuotas:[]

        }
    },
     computed:{
      /*  listar:function(){
            //return this.notificacion[0];
            this.arrayNotifications=Object.values(this.notificacion[0]);
            return Object.values(this.arrayNotifications[0]);
        },*/
        
        },
        methods : {
            cuotasAtrasadas(){
                let me=this;
              
                var url= 'http://localhost/apt/public/notification/notificacionCuotas';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCuotas = respuesta.cuotasatrasadas;

            
                })
                .catch(err => {
                    console.log(err);
            });
         },
         mounted() {
             this.cuotasAtrasadas();
         }
    }
}
</script>