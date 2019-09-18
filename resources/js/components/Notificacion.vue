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
    </li>
</template>
<script>
export default {
    props:['notificacion'],
    data(){
        return{

        }
    }
}
</script>