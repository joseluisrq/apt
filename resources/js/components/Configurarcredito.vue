<template>
 <main class="">

<!--formulario actualizar el  de credito y cuotas -->
    <template v-if="listado==1"><!--me permite visualizar o cocultar el formulario-->
        <div class="row  form-group">
           <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                         <button type="button" class="btn btn-outline-success btn-sm"  @click="historialcredito(1,buscar,criterio)"><i class="fa fa-mail-reply"></i>Ver todos los Creditos </button>
                    
                 <hr>
                      <h4 class="text-center">Editar Crédito </h4>
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
                                <label for="exampleInputEmail1">Identificador de prestamo
                                <span class="text-danger "   v-show="numeroprestamo==''">
                                     (Obligatorio)</span></label>
                                <input type="text" class="form-control"  v-model="numeroprestamo"   placeholder="Ejemplo SMXXXXX">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Identificador KIVA:
                                    <span class="text-danger "   v-show="idkiva==0">
                                     (Obligatorio)</span></label>
                                

                                <input type="text" class="form-control"   v-model="idkiva"  placeholder="Identificador KIVA">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Monto<span class="text-danger "   v-show="montodesembolsado==0">
                                     (Obligatorio)</span></label>
                                <input type="number" class="form-control" step="any" v-model="montodesembolsado"  placeholder="">
                                 
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Fecha <span class="text-danger "   v-show="fechadesembolso==''">
                                     (Obligatorio)</span></label>
                                <input type="date" class="form-control" v-model="fechadesembolso"  placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">N° Cuotas:<span class="text-danger "   v-show="numerocuotas==0">
                                     (Obligatorio)</span></label>
                                <input type="number" class="form-control"  v-model="numerocuotas" placeholder="Número Cuotas">
                            </div>
                             <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Tipo de Cambio<span class="text-danger "   v-show="tipocambio==0">
                                     (Obligatorio)</span></label>
                                <input type="number" class="form-control"  v-model="tipocambio"   placeholder="Número Cuotas">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Tasa de Interes<span class="text-danger "   v-show="tasa==0">
                                     (Obligatorio)</span></label>
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
                                <button type="button"  class="btn btn-warning mr-2" @click="agregarCuotas()"> Generar Nuevas Cuotas</button>
                             
                             </div>
                            
                            <hr>
                        <!--tabla de cuotas--> 
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
                                            <td v-text="cuota.numerocuota"> 
                                               
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
                         <!--fin de tabla cuotas-->
                        </div>

                        <div  v-show="errorCredito" class=" form-group col-md-12 mt-2 bg-danger">
                            <div class="text-center">
                                <div v-for="error in errorMostrarMsjCredito" :key="error">
                                  <mark class="bg-danger text-white col-md-12" ><i class="fa fa-exclamation-triangle"></i> {{error}}</mark>
                                </div>
                            </div>
                        </div>

                        
                         <div v-if="editarvar==0" class="form-group col-4">
                            <button type="button" class="btn btn-success mr-2" @click="registrarCredito()">ACTUALIZAR </button>
                           
                         </div>
                         <div v-else class="form-group col-4">
                           <!-- <button type="button" class="btn btn-success mr-2" @click="editarCredito()">ActualizarCredito</button>-->
                           
                         </div>
                      </form>
                    </div>
                  </div>
                </div>
        </div>
    </template>
<!--fin formulario ingreso de credito-->

 

<!--listado de creditos-->
    <template v-if="listado==2">
         <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="text-center">Configurar Creditos  /Lista de Creditos
                        </h4>
                        <hr>
                      
                        
                        
                        <div class="form-group row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group">
                                        <select class="form-control col-md-4" v-model="criterio">
                                        <option value="numeroprestamo">Número de prestamo</option>
                                        <option value="idkiva">ID kiva</option>
                                         <option value="dni">DNI Cliente</option>
                                        <option value="fechadesembolso">Fecha de Desembolso </option>
                                        
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="historialcredito(1,buscar,criterio)" 
                                        class="form-control form-control-lg" placeholder="Texto a buscar">
                                        <button type="submit" @click="historialcredito(1,buscar,criterio)" 
                                        class="btn btn-outline-dark btn-sm"><i class="fa fa-search"></i> Buscar</button>
                                    
                                    </div>

                                </div>
                                
                             
                                
    
                            </div>

                        <!--TABLA DE LA LISTA DE CREDITOS-->
                        <div class="table-responsive">
                            <table class="table  table-bordered ">
                                <thead class="table-bordered ">
                                    <tr class="font-weight-bold">
                                            <th class="font-weight-bold">Opciones</th>
                                            <th class="font-weight-bold">N° de Prestamo</th>
                                            <th class="font-weight-bold">ID kiva</th>
                                            <th class="font-weight-bold">DNI cliente</th>
                                            <th class="font-weight-bold">Cliente</th>
                                            <th class="font-weight-bold">Monto</th>
                                            <th class="font-weight-bold">Fecha</th>
                                            <th class="font-weight-bold">N° Cuotas</th>
                                            <th class="font-weight-bold">Estado</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="credito in arrayCredito" :key="credito.id">
                                    <td class="py-1">
                                                <button type="button" title="EDITAR CREDITO" @click="editarCredito(credito.id)" class="btn btn-warning btn-sm">
                                               <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                <button type="button" title="ELIMINAR CREDITO" @click="eliminarCredito(credito.id)" class="btn btn-danger btn-sm">
                                              <i class="fa fa-trash-o"></i>
                                                </button>
                                                <button type="button" title="HISTORIAL DE CAMBIOS" @click="eliminarCredito(credito.id)" class="btn btn-primary btn-sm">
                                             <i class=" fa fa-cubes"></i>
                                                </button>
                                               
                                    </td>
                                        <td v-text="credito.numeroprestamo"></td>
                                            <td v-text="credito.idkiva"></td>
                                              <td v-text="credito.dni"></td>
                                            <td v-text="credito.nombre+' '+credito.apellidopaterno+' '+credito.apellidomaterno"></td>
                                            <td v-text="'$ '+credito.montodesembolsado"></td>
                                            <td v-text="credito.fechadesembolso"></td>
                                            <td v-text="credito.numerocuotas"></td>
                                            <td v-if="credito.estado==1" >
                                                <label class="badge badge-warning">En proceso</label>
                                            </td>
                                            <td v-if="credito.estado==0" >
                                                <label class="badge badge-danger">Desactivador</label>
                                            </td>
                                            <td v-if="credito.estado==2" >
                                                <label class="badge badge-success">Completado</label>
                                            </td>
                                        
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



   </main>
</template>

<script>
import vSelect from 'vue-select'
    export default {
        props : ['ruta'],
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
                tasa : 13,
                estado : '',
                periodo : 1,

//variables para clientes
                idcliente:0,
                nombrecliente:'',
                dni:'0',
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
                listado:2,
                editarvar:0,

                

                arrayCredito : [], //alamacenar el credito
                arrayCuota : [], 
                detalleCredito : [],//alamcenar todas las cuotas
                arrayCliente:[],
                arrayCuotasnuevo:[],
                arrayCuotaDetalle:[],
                
                
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
                buscar : '',
                hoy:''
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
                fechaactual(){
                    let date = new Date()

                    let day = date.getDate()
                    let month = date.getMonth() + 1
                    let year = date.getFullYear()

                    if(month < 10){
                   
                     this.hoy=year+'-0'+month+'-'+day
                    }else{
                    this.hoy=year+'-'+month+'-'+day
                    }

                   
            },

            cargarPdf(){
                window.open(this.ruta+'/credito/listarpdf','_blank');
            },
              cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.historialcredito(page,buscar,criterio);
            },
           
              historialcredito (page,buscar,criterio){
                let me=this;
                me.listado=2;
                var url= this.ruta+'/credito?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCredito = respuesta.creditos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
           
            //listar cuotas luego de EDITAR EL CREDITO
            listarCuotas(id){
                this.arrayCuota.length=0;
                let me=this;
                var url= this.ruta+'/credito/cuotasClientEdit?id='+id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCuota = respuesta.cuotasedit;
                  
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            //editar credito
            editarCredito(credito){
              this.listado=1;
              
                this.arrayCredito.length=0
                 let me=this;
                  
                var url= this.ruta+'/credito/creditosClienteEdit?id='+credito+'';
                axios.get(url).then(function (response) {
                     var respuesta= response.data;
                     
                 me.detalleCredito = respuesta.creditosedit;

                //datos del credito
                 me.credito_id=me.detalleCredito[0].id
                 me.numeroprestamo=me.detalleCredito[0].numeroprestamo
                 me.idkiva=me.detalleCredito[0].idkiva
                 me.montodesembolsado=me.detalleCredito[0].montodesembolsado
                 me.fechadesembolso=me.detalleCredito[0].fechadesembolso
                 me.numerocuotas=me.detalleCredito[0].numerocuotas
                 me.tipocambio=me.detalleCredito[0].tipocambio
                 me.tasa=me.detalleCredito[0].tasa
                 me.periodo=me.detalleCredito[0].periodo


                //datos del clientes
                me.idcliente=me.detalleCredito[0].idcliente
                me. nombrecliente=me.detalleCredito[0].nombre
                me.dni=me.detalleCredito[0].dni
                me.apellidopaterno=me.detalleCredito[0].apellidopaterno
                me.apellidomaterno=me.detalleCredito[0].apellidomaterno
                 
                   // me.tipocambio=me.arrayCredito[0].tipocambio;
                //LISTAR CUOTAS
                me.listarCuotas(credito)
                })
                .catch(function (error) {
                    console.log(error);
                });
             
              
            },
             //ELIMNAR credito
            eliminarCredito(id){
              
                 const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Esta seguro de eliminar este crédito?',
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
                                 axios.put(this.ruta+'/credito/desactivar',{ //hacemos referencia a la ruta que creamos
                                    'id':me.arrayCredito[0].id
                                }).then(function(response){ //de una ves que se ejecuto mostramos le mensaje de desactivado
                                  
                                      swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'El credito ha sido eliminado con éxito',
                                    'success'
                                    )
                                }).catch(function(){
                                    console.log(error);
                                });

                           this.historialcredito(1,this.buscar,this.criterio);
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
            nuevoCredito(){
                let me=this;
                    me.idkiva='';
                    this.listado=1;
                    me.idcliente=0;
                    me.numeroprestamo='';
                    //me.idkiva='';
                    me.montodesembolsado=0.0;
                    me.fechadesembolso='';
                    me.numerocuotas=0;
                    me.tipocambio=0.0;
                    me.tasa=0.0;
                    me.periodo='';

                    me.arrayCuota=[];
                    me.arrayCliente=[];

                      this.listacuotas=0;
            },

            selectCliente(search, loading){
                 let me=this;
                 loading(true)
                var url= this.ruta+'/cliente/selectCliente?filtro='+search;
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
                me.dni=val1.dni;
                me.nombrecliente=val1.nombre;
                me.apellidopaterno=val1.apellidopaterno;
                me.apellidomaterno=val1.apellidomaterno
            },
          

            agregarCuotas(){
                
                this.arrayCuota.length=0;
                let me=this;

                if(this.idkiva==0||this.numeroprestamo==''||this.montodesembolsado==0){

                }else{

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
                        fechapago:this.fechadesembolso,
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

                 }//fin del else
               
            },

            mostrarCreditos(){
                this.listado=0;
            },
            ocultarCreditos(){
                this.listado=1;
            },  
            registrarCredito(){
                if (this.validarCredito()){
                    return;
                }
                
                let me = this;

                axios.post('/credito/registrar',{

                    'numeroprestamo': this.numeroprestamo,
                    'idkiva': this.idkiva,
                    'montodesembolsado': this.montodesembolsado,
                    'fechadesembolso' : this.fechadesembolso,
                    'numerocuotas' : this.numerocuotas,
                    'tipocambio' : this.tipocambio,
                    'tasa' : this.tasa,
                    'periodo' : this.periodo,
                     'idcliente' : this.idcliente,

                     'data':this.arrayCuota
                   

                }).then(function (response) {

                   
                   
                 
                    me.listado=0;
                    me.listarCredito();

                    Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Credito Insertado',
                    showConfirmButton: false,
                    timer: 2000
                    })
                    

                }).catch(function (error) {
                    console.log(error);
                });
            },
         
                   
            validarCredito(){
                this.errorCredito=0;
                this.errorMostrarMsjCredito =[];

                if (this.idcliente==0) this.errorMostrarMsjCredito.push("Seleccione un Cliente");
                if (!this.idkiva) this.errorMostrarMsjCredito.push("Ingrese el ID KIVA");
                if (!this.numeroprestamo) this.errorMostrarMsjCredito.push("Ingrese el número de prestamo");
                if (this.montodesembolsado==0) this.errorMostrarMsjCredito.push("El monto a desembolsar no puede ser 0");
                if (!this.fechadesembolso) this.errorMostrarMsjCredito.push("Seleccione una fecha de desembolso");
                if (this.numerocuotas==0) this.errorMostrarMsjCredito.push("Ingrese el número de cuotas");
                if (this.tipocambio==0) this.errorMostrarMsjCredito.push("Ingrese el tipo de cambio");
                if (this.tasa==0) this.errorMostrarMsjCredito.push("La tasa de interes no puede ser 0");

                //si al menos tenemosun error enotnces errorCredito=1
                if (this.errorMostrarMsjCredito.length) this.errorCredito = 1;

                return this.errorCredito;
            },

            detalleCuota(){

            },
             cerrarModal(){
                this.modal=0;
              
            },
            abrirModal(index){
                let me= this;

              me.modal=1;
              me.arrayCuotaDetalle=me.arrayCuotasnuevo[index];
              
              
              }
         
        },
        mounted() {
            this.historialcredito(1,this.buscar,this.criterio);
             this.fechaactual()
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
