<template>


    <main class="">

<!--formulario ingreso de credito-->
    <template v-if="listado"><!--me permite visualizar o cocultar el formulario-->
        <div class="row  form-group">
           <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="text-center">Nuevo Crédito</h4>
                      <hr>
                      <p class="card-description">
                        Insertar la información requerida
                      </p>
                      <form class="forms-sample">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Cliente(*)</label>
                               <v-select
                                  :on-search="selectCliente"
                                        label="dni"
                                        :options="arrayCliente"
                                        placeholder="Ingrese DNI del cliente..."
                                        :onChange="getDatosCliente"     
                                   >
                                </v-select>
                                <div v-if="idcliente!=0">
                                    <label class="badge badge-dark" v-text="nombrecliente+' '+apellidopaterno+' '+apellidomaterno">

                                    </label>
                                </div>
                               
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Identificador de prestamo:</label>
                                <input type="text" class="form-control"  v-model="numeroprestamo"   placeholder="Ejemplo SMXXXXX">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Identificador KIVA:</label>
                                <input type="text" class="form-control"   v-model="idkiva"  placeholder="Identificador KIVA">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Monto desembolsado:</label>
                                <input type="number" class="form-control" step="any" v-model="montodesembolsado"  placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Fecha de desembolso:</label>
                                <input type="date" class="form-control" v-model="fechadesembolso"  placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Número Cuotas:</label>
                                <input type="number" class="form-control"  v-model="numerocuotas" placeholder="Número Cuotas">
                            </div>
                             <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Tipo de Cambio</label>
                                <input type="number" class="form-control"  v-model="tipocambio"   placeholder="Número Cuotas">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Tasa de Interes</label>
                                <input type="number" class="form-control"  v-model="tasa"   placeholder="Número Cuotas">
                            </div>
                             <div class="form-group col-md-3">
                                <label for="exampleFormControlSelect1">Periodo</label>
                                <select class="form-control form-control-lg" v-model="periodo">
                                <option value="1">Mensual</option>
                                <option value="2">Bimestral</option>
                                <option value="3">Trimestral</option>
                                <option value="6">Semestral</option>
                                <option value="12">Anual</option>
                                </select>
                            </div>

                             <div class="form-group col-12">
                                <button type="button" class="btn btn-primary mr-2" @click="agregarCuotas()"> Generar Cuotas</button>
                             
                             </div>
                            
                            <hr>
                            <div class="col-12 mt-4">
                                <div class="table-responsive">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Cuota</th>
                                            <th>Monto</th>
                                            <th>Saldo Pendiente</th>
                                            <th>Fecha de Pago</th>
                                            <th>Otros Pagos</th>
                                            <th>Descripcion</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayCuota.length">
                                        <tr v-for="cuota in arrayCuota" :key="cuota.id">
                                            <td> 
                                               {{cuota.contador}}
                                            </td>
                                            <td> 
                                                <input type="number" class="form-control"   v-model="cuota.monto"  placeholder="Número Cuotas">
                                            </td>
                                           <td> 
                                                <input type="number" class="form-control"  v-model="cuota.saldopendiente"   placeholder="Número Cuotas">
                                            </td>
                                            <td> 
                                                <input type="date" class="form-control"  v-model="cuota.fechapago"   placeholder="Número Cuotas">
                                            </td>
                                            <td> 
                                                <input type="number" class="form-control"  v-model="cuota.otroscostos"   placeholder="Número Cuotas">
                                            </td>
                                            <td> 
                                                <input type="text" class="form-control"  v-model="cuota.descripcion"   placeholder="Número Cuotas">
                                            </td> 
                                        </tr>
                                        
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                Indique la cantidad de cuotas
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        
                         <div v-if="listacuotas==1" class="form-group col-4">
                            <button type="button" class="btn btn-success mr-2" @click="registrarCredito()">Registrar Credito</button>
                            <button class="btn btn-light">Limpiar Campos</button>
                         </div>
                      </form>
                    </div>
                  </div>
                </div>
        </div>
    </template>
<!--fin formulario ingreso de credito-->

    <!--listade creditos-->
    <template v-else>
        <div class="row">
             <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h4 class="text-center">Lista  de Creditos  
                    </h4>
                    <hr>
                       
                    
                    <div class="form-group row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-group">
                                    <select class="form-control col-md-4" v-model="criterio">
                                      <option value="numeroprestamo">Número de prestamo</option>
                                      <option value="idkiva">ID kiva</option>
                                      <option value="fechadesembolso">Fecha de Desembolso </option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCredito(1,buscar,criterio)" 
                                    class="form-control form-control-lg" placeholder="Texto a buscar">
                                     <button type="submit" @click="listarCredito(1,buscar,criterio)" 
                                     class="btn btn-outline-dark btn-sm"><i class="fa fa-search"></i> Buscar</button>
                                
                                </div>
                            </div>
                             <div class="col-md-3 col-sm-1">
                                
                                 
                            </div>
                            <div class="col-md-3 col-sm-11">
                                
                                     <button class="btn btn-outline-primary justify-content-end" @click="ocultarCreditos()">
                                    <span class="fa fa-plus"></span> agregar credito</button>

                                    
                            </div>
                             
 
                        </div>

                    <!--TABLA DE LA LISTA DE CREDITOS-->
                    <div class="table-responsive">
                        <table class="table  table-bordered ">
                            <thead class="table-bordered ">
                                <tr class="font-weight-bold">
                                        <th class="font-weight-bold">Opciones</th>
                                        <th class="font-weight-bold">Numero de Prestamo</th>
                                        <th class="font-weight-bold">ID kiva</th>
                                        <th class="font-weight-bold">Cliente</th>
                                        <th class="font-weight-bold">Monto de Desembolso</th>
                                        <th class="font-weight-bold">Fecha de Desembolso</th>
                                        <th class="font-weight-bold">Numero de Cuotas</th>
                                        <th class="font-weight-bold">Estado</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="credito in arrayCredito" :key="credito.id">
                                <td class="py-1">
                                            <button type="button" @click="abrirModal('credito','actualizar',credito)" class="btn btn-success btn-sm">
                                            <i class="fa fa-eye"></i>
                                            </button>&nbsp;
                                            <template v-if="credito.estado=='1'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarCredito(credito.id)">
                                                <i class="fa fa-trash-o"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button type="button" class="btn btn-info btn-sm" @click="activarCredito(credito.id)">
                                                    <i class="icon-check"></i>
                                                </button>
                                            </template>
                                </td>
                                    <td v-text="credito.numeroprestamo"></td>
                                        <td v-text="credito.idkiva"></td>
                                        <td v-text="credito.nombre+' '+credito.apellidopaterno+' '+credito.apellidomaterno"></td>
                                        <td v-text="credito.montodesembolsado"></td>
                                        <td v-text="credito.fechadesembolso"></td>
                                        <td v-text="credito.numerocuotas"></td>
                                        <td v-text="credito.estado"></td>
                                    
                                </tr>                 
                            </tbody>
                        </table>
                          <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Anterior</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Siguiente</a>
                                </li>
                            </ul>
                         </nav>
                    </div>
                    <!--FIN  DE TABLA DE LA LISTA DE CREDITOS-->
                    </div>
                </div>
            </div>
        </div>
    </template> 
    <!--finde lista de creditos-->
        




            <!-- The Modal -->
            <div class="modal "  :class="{'mostrar' : modal}"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <!-- Modal Header -->
                        <div class="">
                        <h4 class="text-center  mt-2" > 
                             <button type="button" class="close"  @click="cerrarModal()" data-dismiss="modal">&times; </button>
                             {{tituloModal}} </h4>                         
                       
                    
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body card">
                        
                        
                        <!-- Modal footer -->
                      <div class="row">
                          <div class="col-md-6">
                               <button type="button" class="btn btn-secondary col-md-12" @click="cerrarModal()">Cerrar</button></div>
                          <div class="col-md-6">
                              <button type="button" v-if="tipoAccion==1" class="btn btn-primary col-md-12" @click="registrarPersona()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-primary col-md-12" @click="actualizarPersona()">Actualizar</button>
                 
                          </div>
                           
                                   </div>
                       </div>
                        
                    </div>
                </div>
            </div>
           
            <!--Inicio del modal agregar/actualizar-->
               <!--Inicio del modal agregar/actualizar-->
          
            <!--Fin del modal-->
            <!--Fin del modal-->
        </main>

</template>

<script>
import vSelect from 'vue-select'
    export default {
        data (){
            return {
                //variables para credito
                credito_id: 0,
                numeroprestamo : '',
                idkiva : '',
                montodesembolsado : 0.0,
                fechadesembolso : '',
                numerocuotas : 0,
                tipocambio : 0.0,
                tasa : 0.0,
                estado : '',
                periodo : 1,

//variables para clientes
                idcliente:0,
                nombrecliente:'',
                apellidopaterno:'',
                apellidomaterno:'',

//variables para cuotas
                monto:0,
                fechapago:'',
                saldopendiente:0.0,
                otroscostos:0.0,
                descripcion:'',

                listacuotas:0,


//para mostrar oocultar dormulario
                listado:1,

                

                arrayCredito : [], //alamacenar el credito
                arrayCuota : [], //alamcenar todas las cuotas
                arrayCliente:[],
                
                
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCredito : 0,
                errorMostrarMsjCredito : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'numeroprestamo', //inicializamos el criterio de busqueda
                buscar : ''
            }
        },
        components:{
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarCredito (page,buscar,criterio){
                let me=this;
                var url= '/credito?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCredito = respuesta.creditos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCliente(search, loading){
                 let me=this;
                 loading(true)
                var url= '/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta= response.data;
                    q:search;
                    me.arrayCliente = respuesta.clientes;
                    loading(false)
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosCliente(val1){
                let me=this;
                me.loading=true;
                me.idcliente=val1.id;
                me.nombrecliente=val1.nombre;
                me.apellidopaterno=val1.apellidopaterno;
                me.apellidomaterno=val1.apellidomaterno
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarCredito(page,buscar,criterio);
            },

            agregarCuotas(){
                
                this.arrayCuota.length=0;
                let me=this;
                var montotal=this.montodesembolsado;
                
                
                let interes=(parseFloat(montotal)*parseFloat(this.tasa))/100;
                let montoconinteres=(parseFloat(montotal) + parseFloat(interes)).toFixed(2);
                
                var montoxcuota=((montoconinteres)/this.numerocuotas).toFixed(2);
                var sininteres=(parseFloat(this.montodesembolsado)/this.numerocuotas).toFixed(2);

                var pendiente=this.montodesembolsado;
                var fechapagoxcuota=this.fechadesembolso;
                var contadoraux=1;
               
               var fecha = new Date(fechapagoxcuota);

                for (let i = 0; i < this.numerocuotas; i++) { 
                 
                // pendiente=sininteres-montoxcuota;
                 pendiente=(montotal-sininteres).toFixed(2);

                 me.arrayCuota.push({
                    //(monto total+tasa)/cantidadde cuotas
                   
                    monto:montoxcuota,
                    fechapago:fecha,
                    saldopendiente:pendiente,
                    otroscostos:0.0,
                    descripcion:'',
                    contador:contadoraux,

                  
                })
                  montotal=pendiente;
                  contadoraux++;
                  //fechapagoxcuota=fechapagoxcuota.getTime()+semanaEnMilisegundos;
                }
               


                this.listacuotas=1;
               
            },

            registrarPersona(){
                if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.post('/user/registrar',{
                    'dni': this.dni,
                    'nombre': this.nombre,
                    'apellidopaterno': this.apellidopaterno,
                    'apellidomaterno' : this.apellidomaterno,
                    'fechanacimiento' : this.fechanacimiento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'usuario': this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            registrarCredito(){
             this.mostrarCreditos();
            },
            actualizarPersona(){
               if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.put('/user/actualizar',{
                    'dni': this.dni,
                    'nombre': this.nombre,
                    'apellidopaterno': this.apellidopaterno,
                    'apellidomaterno' : this.apellidomaterno,
                    'fechanacimiento' : this.fechanacimiento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'usuario': this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol,
                    'id': this.persona_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la persona no puede estar vacío.");
                if (!this.usuario) this.errorMostrarMsjPersona.push("El nombre de usuario no puede estar vacío.");
                if (!this.password) this.errorMostrarMsjPersona.push("El password no puede estar vacío.");
                if (this.idrol==0) this.errorMostrarMsjPersona.push("Debes seleccionar un rol para el usuario.");

                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            mostrarCreditos(){
                this.listado=0;
            },
            ocultarCreditos(){
                this.listado=1;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.dni='';
                this.nombre='';
                this.apellidopaterno='';
                this.apellidomaterno='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.usuario='';
                this.password='';
                this.idrol=0;
                this.errorPersona=0;

            },
            abrirModal(modelo, accion, data = []){
                this.selectRol();
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.dni='';
                                this.nombre='';
                                this.apellidopaterno='';
                                this.apellidomaterno='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.usuario='';
                                this.password='';
                                this.idrol=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.persona_id=data['id'];
                                this.dni = data['dni'];
                                this.nombre = data['nombre'];
                                this.apellidopaterno = data['apellidopaterno'];
                                this.apellidomaterno = data['apellidomaterno'];
                                 this.fechanacimiento = data['fechanacimiento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.usuario = data['usuario'];
                                this.password = data['password'];
                                this.idrol = data['idrol'];
                                break;
                            }
                        }
                    }
                }
            },
            desactivarUsuario(id){


                 const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Esta seguro de desactivar el usuario?',
                       // text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.value) {
                            //usamos axios para desactivar
                              let me=this;
                                axios.put('/user/desactivar',{ //hacemos referencia a la ruta que creamos
                                    'id':id
                                }).then(function(response){ //de una ves que se ejecuto mostramos le mensaje de desactivado
                                    me.listarPersona(1,'','nombre');
                                      swalWithBootstrapButtons.fire(
                                    'Activado!',
                                    'El registro ha sido desactivado con éxito',
                                    'success'
                                    )
                                }).catch(function(){
                                    console.log(error);
                                });

                           
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                           // swalWithBootstrapButtons.fire(
                                //mensaje cuando cancelamos
                            /*'Cancelled',
                            /'Your imaginary file is safe :)',
                            'error'*/
                          //  )
                        }
                        })

              
            },
            activarUsuario(id){
                const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Esta seguro de activar el usuario?',
                       // text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.value) {
                            //usamos axios para desactivar
                              let me=this;
                                axios.put('/user/activar',{ //hacemos referencia a la ruta que creamos
                                    'id':id
                                }).then(function(response){ //de una ves que se ejecuto mostramos le mensaje de desactivado
                                    me.listarPersona(1,'','nombre');
                                      swalWithBootstrapButtons.fire(
                                    'Activado!',
                                    'El registro ha sido activado con éxito',
                                    'success'
                                    )
                                }).catch(function(){
                                    console.log(error);
                                });

                           
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                           // swalWithBootstrapButtons.fire(
                                //mensaje cuando cancelamos
                            /*'Cancelled',
                            /'Your imaginary file is safe :)',
                            'error'*/
                          //  )
                        }
                        })
            }
        },
        mounted() {
            this.listarCredito(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 500px;
   
    overflow-y: auto;
}

    
   .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
       
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #3c29297a !important;
  

    }   
 
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
