<template>
 <main class="">

<!--formulario ingreso de credito-->
    <template v-if="listado==1"><!--me permite visualizar o cocultar el formulario-->
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
                                <button type="button"  class="btn btn-primary mr-2" @click="agregarCuotas()"> Generar Cuotas</button>
                             
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

                        <div  v-show="errorCredito" class=" form-group col-md-12 mt-2 bg-danger">
                            <div class="text-center">
                                <div v-for="error in errorMostrarMsjCredito" :key="error">
                                  <mark class="bg-danger text-white col-md-12" ><i class="fa fa-exclamation-triangle"></i> {{error}}</mark>
                                </div>
                            </div>
                        </div>

                        
                         <div v-if="editarvar==0" class="form-group col-4">
                            <button type="button" class="btn btn-success mr-2" @click="registrarCredito()">Registrar Credito</button>
                            <button type="button" class="btn btn-light"  @click="nuevoCredito()">Limpiar Campos</button>
                         </div>
                         <div v-else class="form-group col-4">
                            <button type="button" class="btn btn-success mr-2" @click="editarCredito()">ActualizarCredito</button>
                           
                         </div>
                      </form>
                    </div>
                  </div>
                </div>
        </div>
    </template>
<!--fin formulario ingreso de credito-->

    <!--detalle de crtedito-->
    <template v-if="listado==0">
        <div class="row">
            <div class="col-lg-12 grid-margin card">
                <div class="card-body">
                

                  <div class="row" v-for="credito in arrayCredito" :key="credito.id">
                      <div class="col-md-9">
                            <h4 class="text-primary mb-5">Detalle de Credito</h4>
                      </div>
                    
                     <div class="col-md-2">
                          <button type="button" class="btn btn-warning btn-sm"  @click="editarCredito()"><i class="fa fa-pencil"></i></button>
                           <button type="button" class="btn btn-danger btn-sm" @click="eliminarCredito()"><i class="fa fa-trash-o"></i></button>
                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i></button>
                           
                     </div>
                    
                     <div class="col-md-1">
                          <button type="button" class="btn btn-success btn-sm"  @click="historialcredito(1,buscar,criterio)"><i class="fa fa-mail-reply"></i>Historial </button>
                     </div>
                 
                    <div class="col-md-12">
                        
                            <div class="wrapper d-flex justify-content-between">
                                <div class="side-left">
                                    <p class="mb-2 font-weight-bold">Cliente</p>
                                    <h6 class="mb-4 font-weight-light" v-text="credito.nombre+' '+credito.apellidopaterno+' '+credito.apellidomaterno"></h6>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-3">
                            <div class="wrapper d-flex justify-content-between">
                                <div class="side-left">
                                    <p class="mb-2 font-weight-bold">Número de Prestamo</p>
                                    <h6 class="mb-4 font-weight-light" v-text="credito.numeroprestamo"></h6>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-3">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="side-left">
                                <p class="mb-2 font-weight-bold ">ID KIVA</p>
                                <h6 class="mb-4 font-weight-light" v-text="credito.idkiva"></h6>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="side-left">
                                <p class="mb-2 font-weight-bold">Monto </p>
                                <h6 class="mb-4 font-weight-light" v-text="'$'+credito.montodesembolsado"></h6>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="side-left">
                                <p class="mb-2 font-weight-bold">Fecha de desembolso</p>
                                <h6 class="mb-4 font-weight-light" v-text="credito.fechadesembolso"></h6>
                            </div>
                        </div>
                    </div>

                      <div class="col-md-3">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="side-left">
                                <p class="mb-2 font-weight-bold">N°  Cuotas</p>
                                <h6 class="mb-4 font-weight-light" v-text="credito.numerocuotas"></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="side-left">
                                <p class="mb-2 font-weight-bold">Tipo de Cambio</p>
                                <h6 class="mb-4 font-weight-light" v-text="credito.tipocambio"></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="side-left">
                                <p class="mb-2 font-weight-bold">Tasa de Interes</p>
                                <h6 class="mb-4 font-weight-light" v-text="credito.tasa+' %'"></h6>
                            </div>
                        </div>
                    </div>
                      <div class="col-md-3">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="side-left">
                                <p class="mb-2 font-weight-bold">Periodo</p>
                                <h6 class="mb-4 font-weight-light" v-if="credito.periodo==1">Mensual</h6>
                                  <h6 class="mb-4 font-weight-light" v-else-if="credito.periodo==2">Bimensual</h6>
                                   <h6 class="mb-4 font-weight-light" v-else-if="credito.periodo==3">Trimestral</h6>
                                    <h6 class="mb-4 font-weight-light" v-else-if="credito.periodo==6">Semestral</h6>
                                     <h6 class="mb-4 font-weight-light" v-else-if="credito.periodo==12">Anual</h6>
                            </div>
                        </div>
                    </div>
                </div>
                  
                  
                  
                  
                </div>
              </div>
             <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="font-weight-bold">Cuotas</h6>

                    <!--TABLA DE LA LISTA DE CREDITOS-->
                    <div class="table-responsive">
                        <table class="table  table-bordered ">
                            <thead class="table-bordered ">
                                <tr class="font-weight-bold">
                                      <th class="font-weight-bold">#</th>
                                    <th class="font-weight-bold">Opciones</th>
                                   
                                    <th class="font-weight-bold">Fecha de Pago</th>
                                    <th class="font-weight-bold">Cuota Dolares</th>
                                    <th class="font-weight-bold">Cuota Soles</th>
                                    <th class="font-weight-bold">Saldo Pendiente</th>
                                    
                                    <th class="font-weight-bold">Pago</th>
                                        
                                    
                                </tr>
                            </thead>
                            <tbody>

                                <tr  v-for="(cuotanuevo,index) in arrayCuotasnuevo" :key="cuotanuevo.id" >

                                   
                                       <td v-text="cuotanuevo.numerocuota"></td>
                                     <td class="py-1">
                                                <button type="button" @click="abrirModal(index)" class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
                                                </button>&nbsp;
                                             
                                                  </td>
                                 
                                    <td v-if="cuotanuevo.fechapago <'2018-05-05' && cuotanuevo.estado==0" >
                                        {{cuotanuevo.fechapago}} <span class="badge badge-warning"> Cuota atrasada</span>
                                    </td>
                                     <td v-else>
                                        <span  v-text="cuotanuevo.fechapago"></span>
                                    </td>
                                     <td >
                                        $ {{cuotanuevo.monto}} 
                                     </td>
                                     <td >
                                         <span class="badge badge-primary" style="font-size:12px;"> S/ {{ parseFloat(cuotanuevo.monto * tipocambio).toFixed(2)	}}</span>
                                     </td>
                                     
                                    <td v-text="cuotanuevo.saldopendiente"></td>
                                   
                                    <td v-if="cuotanuevo.estado==0">
                                        <label class="badge badge-danger">Pendiente</label>
                                    </td>
                                     <td v-else-if="cuotanuevo.estado==1">
                                         <label class="badge badge-success">Pagada</label>
                                     </td>
                                     <td v-else>
                                         <label class="badge badge-success">Pago con retraso</label>
                                     </td>
                                  
                                   
                                         
                                    
                                </tr>                 
                            </tbody>
                        </table>
                        
                    </div>
                    <!--FIN  DE TABLA DE LA LISTA DE CREDITOS-->
                    </div>
                </div>
            </div>
        </div>
    </template> 

<!--listado de creditos-->
    <template v-if="listado==2">
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
                                        <input type="text" v-model="buscar" @keyup.enter="historialcredito(1,buscar,criterio)" 
                                        class="form-control form-control-lg" placeholder="Texto a buscar">
                                        <button type="submit" @click="historialcredito(1,buscar,criterio)" 
                                        class="btn btn-outline-dark btn-sm"><i class="fa fa-search"></i> Buscar</button>
                                    
                                    </div>

                                </div>
                                 <div class="col-md-4 col-sm-12">
                                       </div>
                                <div class="col-md-2 col-sm-12">
                                      <button type="button" @click="cargarPdf()" class="btn btn-info"> <i class="fa fa-file-pdf-o"></i>
                                Pdf
                            </button>
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
                                                <button type="button" @click="listarCredito(credito.idkiva)" class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
                                                </button>&nbsp;
                                               
                                    </td>
                                        <td v-text="credito.numeroprestamo"></td>
                                            <td v-text="credito.idkiva"></td>
                                            <td v-text="credito.nombre+' '+credito.apellidopaterno+' '+credito.apellidomaterno"></td>
                                            <td v-text="credito.montodesembolsado"></td>
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


<!--modal detalle de cuota-->
    <!-- Modal -->
 
        <div class="modal "  :class="{'mostrar' : modal}"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg bg-primary ">
                            <h4 class="text-center  mt-2 text-white" >                           
                            Cuota N° : {{arrayCuotaDetalle.numerocuota}}  &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary text-white float-rigth"  @click="cerrarModal()">&times; </button> </h4>
                           
                     
                        <!-- Modal body -->
                        <div class="modal-body card">
                          
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="float-left">
                                    <p class="mb-0 text-left">Cliente</p>
                                        <div class="fluid-container">
                                            <h6 class="font-weight-medium text-left mb-0" 
                                            v-text="arrayCuotaDetalle.nombre+' '+arrayCuotaDetalle.apellidopaterno+' '+apellidomaterno"></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="float-left">
                                    <p class="mb-0 text-left">Cuota en  Dolares)</p>
                                        <div class="fluid-container">
                                         
                                            <h6  class="font-weight-medium text-left mb-0">
                                            $ {{arrayCuotaDetalle.monto}}   
                                           </h6>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-4 mt-2">
                                    <div class="float-left">
                                    <p class="mb-0 text-left">Cuota en Soles)</p>
                                        <div class="fluid-container">
                                         
                                            <h6  class="font-weight-medium text-left mb-0">
                                          S/ {{arrayCuotaDetalle.monto*tipocambio}} </h6>
                                        </div>
                                    </div>
                                </div>
                                  <div class="col-md-4  mt-2">
                                    <div class="float-left">
                                    <p class="mb-0 text-left">Otros Pagos</p>
                                        <div class="fluid-container">
                                            <h6 class="font-weight-medium text-left mb-0" v-text="arrayCuotaDetalle.otroscostos"></h6>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-md-12   mt-2">
                                      <hr>
                                    <div class="float-left">
                                       
                                    <p class="mb-0 text-left">Pago Total</p>
                                        <div class="fluid-container">
                                            <h6 class="font-weight-medium text-left mb-0" 
                                            v-text="'S/' +(parseFloat(arrayCuotaDetalle.monto*tipocambio)+ parseFloat(arrayCuotaDetalle.otroscostos)).toFixed(2)"></h6>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-6  mt-2">
                                    <div class="float-left">
                                    <p class="mb-0 text-left">Fecha de Pago</p>
                                        <div class="fluid-container">
                                            <h6 class="font-weight-medium text-left mb-0" v-text="arrayCuotaDetalle.fechapago"></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <div class="float-left">
                                    <p class="mb-0 text-left">Fecha de Cancelación</p>
                                        <div class="fluid-container">
                                            <h6 v-if="arrayCuotaDetalle.estado==0" class="font-weight-medium text-left mb-0" >Pendiente</h6>
                                            <h6 v-else class="font-weight-medium text-left mb-0" v-text="arrayCuotaDetalle.fechacancelacion"></h6>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-6  mt-2">
                                    <div class="float-left">
                                    <p class="mb-0 text-left">Detalle</p>
                                        <div class="fluid-container">
                                            <h6 v-if="arrayCuotaDetalle.descripcion==null" class="font-weight-medium text-left mb-0" >Sin detalle</h6>
                                            <h6 v-else class="font-weight-medium text-left mb-0" v-text="arrayCuotaDetalle.descripcion"></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12  mt-2">
                                    <div class="float-left">
                                    <p class="mb-0 text-left">Cajero</p>
                                        <div class="fluid-container">
                                          
                                            <h6  class="font-weight-medium text-left mb-0" 
                                            v-text="arrayCuotaDetalle.usuarionombre+' '+
                                            arrayCuotaDetalle.usuariopaterno+' '+
                                            arrayCuotaDetalle.usuariomaterno"></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                        <button type="button" class="btn btn-danger col-md-12" @click="cerrarModal()">Cerrar</button>
                                </div>
                                <div class="col-md-6">
                                        
                                        <button type="button" class="btn btn-info col-md-12" @click="generarboucher()"><i class="fa fa-file-pdf-o"></i>
                                        Boucher</button>
                                </div>
                            </div>
                      
                       
                        </div>

                        </div>
                    
                </div>
        </div>
<!-- fin de detalle de cuota-->

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
                arrayCuota : [], //alamcenar todas las cuotas
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
            cargarPdf(){
                window.open('http://localhost:8000/credito/listarpdf','_blank');
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
            //lisar credito luego se aver sido insertado el credito
            listarCredito (idkiva){
                 
                let me=this;
                var url= '/credito/creditosCliente?idkiva='+idkiva;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCredito = respuesta.creditos;
                    me.tipocambio=me.arrayCredito[0].tipocambio;
                    me.listarCuotas(idkiva)
                })
                .catch(function (error) {
                    console.log(error);
                });
         
            },
            //listar cuotas luego de ingresar el credito
            listarCuotas(idkiva){
                 this.listado=0;
                  let me=this;
                var url= '/credito/cuotasClientenuevo?idkiva='+idkiva;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCuotasnuevo = respuesta.cuotas;
                  
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            //editar credito
            editarCredito(){
              this.listado=1;
              let me=this;
              me.editarvar=1;
              
            },
             //editar credito
            eliminarCredito(){
              
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
                                axios.put('/credito/desactivar',{ //hacemos referencia a la ruta que creamos
                                    'id':me.arrayCredito[0].id
                                }).then(function(response){ //de una ves que se ejecuto mostramos le mensaje de desactivado
                                    me.nuevoCredito();
                                      swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'El registro ha sido eliminado con éxito',
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
