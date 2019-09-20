<template>
       <!-- INICIO PAGO DE CUOTA -->
         <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="row">
                                <div class="col-md-9">
                                        <h4 class="font-weight-bold">   
                                    PAGO DE CUOTA N° {{numerocuota}} {{idcliente}}
                                        </h4> 
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-outline-success btn-sm" @click="showpagocuota=false"><i class="fa fa-mail-reply"></i>Lista de Clientes </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 ">  
                                     <hr>
                                    <h5 class=" text-dark"><i class="fa fa-address-book-o "></i> Datos del Cliente</h5>
                                  <hr>
                                </div>
                                <div class="col-md-3">
                                    <p class="font-weight-bold">DNI</p>
                                    <p class="font-weight-light" v-text="dni"></p>
                                </div>
                                <div class="col-md-9">  
                                    <p class="font-weight-bold">Cliente</p>
                                    <p class="font-weight-light" v-text="nombrecliente"></p>
                                </div>
                            
                             </div>
                        </div>
                         <div class="col-md-6">
                             <div class="row">
                                <div class="col-md-12">  
                                    <hr>
                                    <h5 class="text-dark"><i class="fa fa-desktop "></i> Datos del Credito</h5>
                                     <hr>
                                  
                                </div>
                                <div class="col-md-3">
                                    <p class="font-weight-bold ">N° Prestamo</p>
                                    <p class="font-weight-light" v-text="numeroprestamo"></p>
                                </div>
                                <div class="col-md-3">
                                    <p class="font-weight-bold ">ID KIVA</p>
                                    <p class="font-weight-light" v-text="idkiva"></p>
                                </div>
                                <div class="col-md-3">
                                    <p class="font-weight-bold ">Tipo cambio</p>
                                    <p class="font-weight-light" v-text="tipocambio"></p>
                                </div>
                                <div class="col-md-3">
                                        <p class="font-weight-bold">Fecha pago</p>
                                        <p class="font-weight-light" v-text="fechapago"></p>
                                </div>
                            </div>
                                </div>
                    </div>
                    
                   <div class="row">
                     <div class="col-md-12">  
                         <hr>
                         <h5 class=""> <i class="fa fa-money  "></i> Detalle del Pago</h5>
                        <hr>
                     </div>
                     <div class="col-md-6">  
                      <table class="table table-bordered">
                       <thead>
                        
                       </thead>
                            <tbody>
                                <tr>
                                <td>Saldo Anterior Neto</td>
                                <td v-text="'$ '+(parseFloat(saldopendientecuota)+parseFloat(montocuota)).toFixed(2)"></td>
                                </tr>
                            
                                <tr>
                                <td>Pago Neto</td>
                                <td v-text="'S/ '+(montocuota*tipocambio).toFixed(2)"></td>
                                </tr>
                                <tr>
                                <td>Interes</td>
                                <td v-text="'S/ '+(interes*tipocambio).toFixed(2)"></td>
                                </tr>
                                <tr>
                                <td>Otros Pagos S/</td>
                                <td> <input type="number" class="form-control" min="0"  v-model="otroscostoscuota"  placeholder="No puede dejar este campo vacio"></td>
                                </tr>
                            
                                <tr class="">
                                <td>Total a Pagar</td>
                                <td v-text="'S/. '+(parseFloat(otroscostoscuota)+parseFloat(totalpagar)).toFixed(2)" class="bg bg-warning text-white"></td>

                                </tr>
                            
                                
                            </tbody>
                      </table>
                    </div>

                     <div class="col-md-6">  
                        <p class="font-weight-bold">Descripción</p>
                                <textarea rows="5" cols="50" oninput="this.value = this.value.toUpperCase();" v-model="descpagocuota"></textarea>   
                    </div>
                    
                     <div class="col-md-12">  
                        <hr>
                        <div class="row">
                            <div class="col-md-9">
                                  <button type="button" v-if="botoncuota" @click="pagarCuota" class="btn btn-success col-md-4" >Pagar Cuota</button>
                            </div>
                            <div class="col-md-3">
                                 <button type="button" class="btn btn-outline-primary" @click="showpagoporcion=true;botoncuota=false;">Pagar porción</button>      
                            </div>
                        </div>
                       
                        
                    </div>
                     <!-- INICIO PAGO PORCION  -->
                    <template v-if="showpagoporcion">
                
                        <div class="col-md-12">
                             <hr>
                            <h5 class="font-weight-bold">Pagar Porción de Cuota</h5>
                            <hr>
                        </div>
                         <div class="col-md-2">
                              <p class="font-weight-bold">Ingresar Monto S/</p>
                              <input required="" class="col-md-12" type="Number" :max="montocuota" min="0" v-model="montoporcion" placeholder="Ingrese el monto a pagar">                 
                        </div>
                        <div class="col-md-2">
                           <p class="font-weight-bold">Otros Pagos S/</p>
                           <input type="Number" min="0" placeholder="Ingrese cantidad" v-model="otroscostosporcion">
                       </div>
                        <div class="col-md-8">
                                <p class="font-weight-bold">Descripción</p>
                                <input type="text" oninput="this.value = this.value.toUpperCase();" v-model="descpagoporcion" class="col-md-12">
                        </div>  
                                                
                        <div class="col-md-12">
                            <hr>
                                <button type="button" class="btn btn-danger" @click="showpagoporcion=false;botoncuota=true;">Cerrar</button>
                                <button type="button" class="btn btn-success" @click="pagarPorcionCuota">Confirmar pago</button>
                         </div>
                           
                            
                       
                    
                    </template>
                <!-- FIN PAGO PORCION  -->


                   
                </div>

                </div>
                </div>
                </div>
                </div>
            
       
    <!-- FIN PAGO DE CUOTA -->
</template>

<script>
export default {
    props : ['idcliente'],
    data (){
            return {
                //ruta
                 ruta: 'http://localhost/apt/public',
                //datos de la persona
                persona_id: 0,
                dni : '',
                nombre : '',
                apellidopaterno : '',
                apellidomaterno : '',
                fechanacimiento : '',
                direccion : '',
                telefono : '',
                email : '',
                estado_per : 1,

                //datos de cuota
                idcuota:0,
                numerocuota:0,
                idkiva:'',
                numeroprestamo:0,
                nombrecliente:'',
                fechakiva:'',
                dni:'',
                fechapago:'',
                montocuota:0.0,
                totalpagar:0.0,
               
                interes:0.0,
            
                otroscostoscuota:0,
                saldopendientecuota:0.0,
                tipocambio:0.0,

                descpagocuota:'',

                //datos del cliente
                estado_cli : '',
                personacredito_id:0,
               
                arrayPersona : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                        
                
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                 showpagocuota: false,
                 showpagoporcion:false,
                 botoncuota:true,


                 montoporcion:0.0,
                 otroscostosporcion:0.0,
                 descpagoporcion:'',

            }
            
        },
        computed:{
               

            
        },
        methods : {
      

            //CUOTA PAGAR
            obtenerCuotaDeCliente(){
                let me=this;
                
                axios.get(this.ruta+'/cuota/detallepagar?id='+this.idcliente)
                    .then(res => {
                    let cuotas = res.data.cuotas;
                 
                    if(cuotas.length == 0)
                        Swal.fire({
                        title: 'El cliente no tiene cuotas a pagar',
                        animation: true,
                        customClass: {
                            popup: 'animated tada'
                        }
                        })
                    else if (cuotas.length == 1){
                      this.idcuota = cuotas[0].id;
                       this.numeroprestamo = cuotas[0].numeroprestamo;
                        this.numerocuota = cuotas[0].numerocuota;
                      this.idkiva = cuotas[0].idkiva;
                     
                      this.nombrecliente = cuotas[0].nombre + " " + cuotas[0].apellidopaterno + " " + cuotas[0].apellidomaterno;
                      this.dni = cuotas[0].dni;
                      this.fechapago = cuotas[0].fechapago;
                       this.fechakiva = cuotas[0].fechakiva;
                      this.montocuota = cuotas[0].monto;
                    //  this.otroscostoscuota = cuotas[0].otroscostos;   
                       this.tipocambio = cuotas[0].tipocambio;                   
                      this.saldopendientecuota = cuotas[0].saldopendiente;

                      this.interes=
                          ((cuotas[0].montodesembolsado*(cuotas[0].tasa/100))
                          )/cuotas[0].numerocuotas;

                    this.totalpagar=(((parseFloat(this.montocuota)+parseFloat(this.interes))*this.tipocambio)).toFixed(2);
                    
                      //this.montodesembolsado=cuotas[0].montodesembolsado;
                     //  this.tasa=cuotas[0].tasa;
                      // this.cantidadcuotas=cuotas[0].numerocuotas

                        this.showpagocuota = true;
                         //this.showpagocuota = true;
                    }
                    })
                    .catch(err => {
                        console.log(err);
                    });
                },

        
        

            //pagar cuota
            pagarCuota: function(){
                axios.put(this.ruta+'/cuota/pagar',{
                    'id': this.idcuota,
                    'descripcion': this.descpagocuota,
                    'otrospagos': this.otroscostoscuota,
                    'idpersona':this.personacredito_id
                })
                    .then(res => {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'El pago se realizó correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })

                   // this.listarCuotasPendientes();
                     let cuotaid = this.idcuota;

                     this.generarboucher(cuotaid);
                     this.listarPersona(1,this.buscar,this.criterio);
                     this.showpagocuota = false;
                  
                    })
                    .catch(err => {
                        Swal.fire({
                        position: 'top-end',
                        type: 'error',
                        title: 'Error, No se realizó el pago',
                        showConfirmButton: false,
                        timer: 1500
                        })
                    });

                    
                   // this.limpiarDatos();
                },
            generarboucher(idcuota){
                window.open(this.ruta + '/credito/detallecuotapdf/'+idcuota+'','_blank');
            },
            //pagar porcion cuota
             pagarPorcionCuota: function(){

                if(this.montoporcion == 0){
                    Swal.fire({
                    title: 'Debe ingresar un monto mayor a cero',
                    animation: true,
                    customClass: {
                        popup: 'animated tada'
                    }
                    })
                    return;
                }

                let montopagardolares=this.montoporcion/this.tipocambio
                axios.post(this.ruta+'/cuota/porcion',{
                    'id': this.idcuota,
                    'monto': montopagardolares,
                    'otroscostos': this.otroscostosporcion,
                    'descripcion': this.descpagoporcion
                })
                    .then(res => {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'El pago se realizó correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
                   // this.generarboucher(cuotaid);
                    this.montoporcion=0.0,
                    this.otroscostosporcion=0.0,
                    this.descpagoporcion='',

                    this.showpagocuota = false;
                    this.showpagoporcion=false;
                    this.botoncuota=true;
                   
                    })
                    .catch(err => {
                        Swal.fire({
                        position: 'top-end',
                        type: 'error',
                        title: 'Error, No se completó el pago',
                        showConfirmButton: false,
                        timer: 1500
                        })
                    });

                  
                },
        },
        mounted() {
            this.obtenerCuotaDeCliente();
        }
    }
</script>