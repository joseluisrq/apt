<template>
       <!-- INICIO PAGO DE CUOTA -->
         <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <!--detalle de pago-->
                   <div class="row" v-for="c in dataC" :key="c.id">
                        <div class="col-md-12">
                            <h4 class="font-weight-bold">PAGO DE CUOTA N° {{c.numerocuota}}</h4>       
                        </div>
                        <!--Datos del cliente-->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 ">  
                                     <hr>
                                    <h5 class=" text-dark"><i class="fa fa-address-book-o "></i> Datos del Cliente</h5>
                                  <hr>
                                </div>
                                <div class="col-md-3">
                                    <p class="font-weight-bold">DNI</p>
                                    <p class="font-weight-light" v-text="c.dni"></p>
                                </div>
                                <div class="col-md-9">  
                                    <p class="font-weight-bold">Cliente</p>
                                    <p class="font-weight-light" v-text="c.nombre+' '+c.apellidopaterno+' '+c.apellidomaterno"></p>
                                </div>
                            
                             </div>
                        </div>
                        <!--Datos del credito-->
                        <div class="col-md-6">
                             <div class="row">
                                <div class="col-md-12">  
                                    <hr>
                                    <h5 class="text-dark"><i class="fa fa-desktop "></i> Datos del Credito</h5>
                                     <hr>
                                  
                                </div>
                                <div class="col-md-3">
                                    <p class="font-weight-bold ">N° Prestamo</p>
                                    <p class="font-weight-light" v-text="c.numeroprestamo"></p>
                                </div>
                                <div class="col-md-3">
                                    <p class="font-weight-bold ">ID KIVA</p>
                                    <p class="font-weight-light" v-text="c.idkiva"></p>
                                </div>
                                <div class="col-md-3">
                                    <p class="font-weight-bold ">Tipo cambio</p>
                                    <p class="font-weight-light" v-text="c.tipocambio"></p>
                                </div>
                                <div class="col-md-3">
                                        <p class="font-weight-bold">Fecha pago</p>
                                        <p class="font-weight-light" v-text="c.fechapago"></p>
                                </div>
                            </div>
                        </div>
                        <!--detalle depago-->
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
                                        <td v-text="'$ '+(parseFloat(c.saldopendiente)+parseFloat(c.monto)).toFixed(2)"></td>
                                        </tr>
                                    
                                        <tr>
                                        <td>Pago Neto</td>
                                        <td v-text="'S/ '+(c.monto*c.tipocambio).toFixed(2)"></td>
                                        </tr>
                                        <tr>
                                        <td>Interes</td>
                                        <td v-text="'S/ '+(interes*c.tipocambio).toFixed(2)"></td>
                                        </tr>
                                        <tr>
                                        <td>Otros Pagos S/</td>
                                        <td> <input type="number" class="form-control" min="0"  v-model="c.otroscostos"  placeholder="No puede dejar este campo vacio"></td>
                                        </tr>
                                    
                                        <tr class="">
                                        <td>Total a Pagar</td>
                                        <td v-text="'S/. '+(parseFloat(c.otroscostos)+parseFloat(totalpagar)).toFixed(2)" class="bg bg-warning text-white"></td>

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
                                    <button type="button" v-if="botoncuota" @click="pagarCuota(c.id,c.otroscostos,c.idpersona)" class="btn btn-success col-md-4" >Pagar Cuota</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-outline-primary" @click="showpagoporcion=true;botoncuota=false;">Pagar porción</button>      
                                </div>
                             </div>
                        </div>
                     <!--fin detalle de pago-->
                     
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
               
                dataC:[],//detalle de cuota

                totalpagar:0.0,
                interes:0.0,

                descpagocuota:'',

                //datos del cliente
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
                    this.dataC = res.data.cuotas;
                    
                 
                    me.interes=
                          ((me.dataC[0].montodesembolsado*(me.dataC[0].tasa/100))
                          )/me.dataC[0].numerocuotas;

                      me.totalpagar=(((parseFloat(me.dataC[0].monto)+parseFloat(me.interes))*me.dataC [0].tipocambio)).toFixed(2);
        
                   
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            //pagar cuota
            pagarCuota: function(idcuota,otroscostoscuota,idpersona){
                axios.put(this.ruta+'/cuota/pagar',{
                    'id': idcuota,
                    'descripcion': this.descpagocuota,
                    'otrospagos': otroscostoscuota,
                    'idpersona':idpersona
                })
                    .then(res => {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'El pago se realizó correctamente',
                        showConfirmButton: false,
                        timer: 2000
                        })

                   // this.listarCuotasPendientes();
                    

                     this.generarboucher(idcuota);
                    // this.listarPersona(1,this.buscar,this.criterio);
                    // this.showpagocuota = false;
                  
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