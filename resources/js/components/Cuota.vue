<template>
 <main class="">

<!-- INICIO PAGO DE CUOTA -->
    <template v-if="showpagocuota">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center">PAGO DE CUOTA</h4>
              <button class="btn btn-dark" @click="showpagocuota=false;showpagoporcion=false;">Volver</button>
              <hr>

              <div class="row">
                <div class="col-6">  
                    <p class="font-weight-bold">Cliente</p>
                    <p class="font-weight-light" v-text="nombrecliente"></p>
                </div>
                <div class="col-3">
                    <p class="font-weight-bold">DNI</p>
                    <p class="font-weight-light" v-text="dni"></p>
                </div>
                <div class="col-3">
                    <p class="font-weight-bold ">ID KIVA</p>
                    <p class="font-weight-light" v-text="idkiva"></p>
                </div>
                 <div class="col-6">
                    <div class="row">
                      <p class="col-12 font-weight-bold">Monto </p>
                      <p class="col-3 font-weight-light" v-text="'$ '+montocuota"></p>
                      <p class="col-3 font-weight-light" v-text="'s/. '+(montocuota*tipocambio).toFixed(2)"></p>
                    </div>
                </div>
                <div class="col-3">
                    <p class="font-weight-bold">Otros costos </p>
                    <p class="font-weight-light" v-text="'S/. '+otroscostoscuota"></p>
                </div>
                <div class="col-3">
                    <p class="font-weight-bold ">Tipo cambio</p>
                    <p class="font-weight-light" v-text="tipocambio"></p>
                </div>
                <div class="col-3">
                    <p class="font-weight-bold">Saldo pendiente</p>
                    <p class="font-weight-light" v-text="'$ '+saldopendientecuota"></p>
                </div>
                 <div class="col-12">
                   <div class="row">
                     <!--<div class="col-6">
                      <p class="font-weight-bold">Fecha de desembolso</p>
                      <p class="font-weight-light" v-text="fechahoy"></p>
                    </div>-->
                    <div class="col-6">
                        <p class="font-weight-bold">Fecha pago</p>
                        <p class="font-weight-light" v-text="fechapago"></p>
                    </div>
                   </div>
                 </div>
                <div class="col-12">
                    <p class="font-weight-bold">Descripción</p>
                    <textarea rows="4" cols="50" oninput="this.value = this.value.toUpperCase();" v-model="descpagocuota"></textarea>
                </div>
            </div>
             <div v-if="!showpagoporcion" class="col-12">
                <button type="button" class="btn btn-primary" @click="showpagoporcion=true;">Pagar porción</button>
                <button type="button" class="btn btn-success" @click="pagarCuota">Confirmar pago</button>
             </div>
            </div>
          </div>
        </div>
      </div>
    </template>
<!-- FIN PAGO DE CUOTA -->

<!-- INICIO PAGO PORCION  -->
    <template v-if="showpagoporcion">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="text-center">PAGAR PORCIÓN DE CUOTA</h4>
              <hr>

              <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-6">
                        <p class="font-weight-bold">Ingresar Monto</p>
                        <input required="" type="Number" :max="montocuota" min="0" v-model="montoporcion" placeholder="Ingrese el monto a pagar">
                      </div>
                      <div class="col-6">
                        <p class="font-weight-bold">Otros costos</p>
                        <input type="Number" min="0" placeholder="Ingrese cantidad" v-model="otroscostosporcion">
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <p class="font-weight-bold">Descripción</p>
                    <textarea rows="4" cols="50" oninput="this.value = this.value.toUpperCase();" v-model="descpagoporcion"></textarea>
                  </div>                  
                  <div class="col-12">
                    <button type="button" class="btn btn-danger" @click="showpagoporcion=false;">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="pagarPorcionCuota">Confirmar pago</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
<!-- FIN PAGO PORCION  -->

<!-- INICIO CALENDARIO CUOTAS PENDIENTES -->
    <template v-if="!showpagocuota">
         <div class="row card">
           <div class="col-md-12 mt-4">
             <h5 class="text-center"> Pagar Cuota</h5>
             <hr>
           </div>
          <div class="col-lg-12 grid-margin stretch-card">
                  <div class="col-md-4 form-group">
                      <div class="row">
                                <div class="col-md-12">
                                  <label for="exampleInputEmail1">DNI Cliente</label>
                                    </div>
                                <div class="col-md-10">
                                  <input type="text" v-model="dniBuscar" @keyup.enter="obtenerCuotaDeCliente()" class="form-control form-control border border-dark" placeholder="Ingresar DNI del cliente">
                            
                                </div>
                                <div class="col-md-2">
                                      <button type="submit" @click="obtenerCuotaDeCliente" class="btn btn-outline-dark btn-sm">
                                  <i class="fa fa-search"></i> Buscar
                                </button>
                                </div>
                                

                      </div>        
                    </div>
                    <div class="col-md-3 form-group">
                      </div>

                    <div class="col-md-4 form-group">
                      <div class="row">
                                <div class="col-md-12">
                                  <label for="exampleInputEmail1">Buscar Fecha</label>
                                    </div>
                                <div class="col-md-10">
                                  <input id="fecha" type="date" class="form-control form-control border border-dark" >
                            
                                </div>
                                <div class="col-md-2">
                                       <button @click="gotoPast" type="button" class="btn btn-outline-dark btn-sm">
                                      <i class="fa fa-search"></i>Buscar
                                </button>
                                </div>
                                

                      </div>        
                    </div>
                    
                    
            </div>
          </div>

                        <div class="row">

                            <div v-if="showdetalle" class="col-md-4">
                              <div class="card border border-light">
                                <div class="card-header bg bg-primary text-white">
                                  Detalle de cuota
                                  <button @click="showdetalle=false" type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true" class="text-white">&times;</span>
                                  </button>
                                </div>
                                <div class="card-body">                                
                                
                                  <div class="row"> 
                                    <div class="col-md-12"> 
                                      <div class="wrapper d-flex justify-content-between">
                                          <div class="side-left">
                                              <p class="mb-2 font-weight-bold">CLIENTE:</p>
                                              <p class="font-weight-light" v-text="nombrecliente"></p>
                                          </div>
                                      </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="wrapper d-flex justify-content-between">
                                          <div class="side-left">
                                              <p class="mb-2 font-weight-bold">DNI: </p>
                                              <p class="mb-4 font-weight-light" v-text="dni"></p>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wrapper d-flex justify-content-between">
                                            <div class="side-left">
                                                <p class="mb-2 font-weight-bold ">ID KIVA</p>
                                                <p class="mb-4 font-weight-light" v-text="idkiva"></p>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                   <div class="row">
                                      <p class="col-md-12 font-weight-bold">Monto </p>
                                      <p class="col-md-6" v-text="'$ '+montocuota"></p>
                                      <p class="col-md-6" v-text="'s/. '+(montocuota*tipocambio).toFixed(2)"></p>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="wrapper d-flex justify-content-between">
                                          <div class="side-left">
                                              <p class="mb-2 font-weight-bold">Otros costos </p>
                                              <p class="mb-4 font-weight-light" v-text="'S/. '+otroscostoscuota"></p>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wrapper d-flex justify-content-between">
                                            <div class="side-left">
                                                <p class="mb-2 font-weight-bold">Saldo pendiente</p>
                                                <p class="mb-4 font-weight-light" v-text="'S/. '+saldopendientecuota"></p>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                        <div class="wrapper d-flex justify-content-between">
                                            <div class="side-left">
                                                <p class="mb-2 font-weight-bold">Fecha pago</p>
                                                <p class="mb-4 font-weight-light" v-text="fechapago"></p>
                                            </div>
                                        </div>
                                    </div>
                                   <!--<div class="row">
                                      <div class="wrapper d-flex justify-content-between">
                                          <div class="side-left">
                                              <p class="mb-2 font-weight-bold">Fecha de desembolso</p>
                                              <p class="mb-4 font-weight-light" v-text="fechahoy"></p>
                                          </div>
                                      </div>
                                    </div>-->
                                  <div class="row">
                                      <div class="col-md-12">
                                         
                                              <button class="btn btn-success col-md-12" @click="showpagocuota=true;">
                                               <i class="fa fa-cash-register"></i>Ir a pagos</button>
                                          
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                           <!-- INICIO CALENDARIO -->
                           <div :class="showdetalle?'col-md-8':'col-md-12'">
                             <!-- <div id="cabeceracalendario" class="calendario-top col-sm-12">
                              
                              </div>-->
                              <FullCalendar
                                class="calendario-calendar col-sm-12 card"
                                ref="fullCalendar"
                                defaultView="dayGridMonth"
                                :header="{
                                  left: 'prev,next,today',
                                  center: 'title',
                                  right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                                }"
                                :buttonText="{
                                  day: 'Día',
                                  month: 'Mes',
                                  today: 'Hoy',
                                  week: 'Semana',
                                  year: 'Año',
                                }"
                                :locale="lang"
                                :plugins="calendarPlugins"
                                :weekends="calendarWeekends"
                                :events="calendarEvents"
                                :eventLimit="true"
                                @eventClick="eventSelected"
                              />
                            </div>
                           <!-- FIN CALENDARIO -->
                        </div>
                            

                        </div>
                    </div>
                </div>
            </div>
    </template>
<!-- FIN CALENDARIO CUOTAS PENDIENTES -->

   </main>
</template>

<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

// must manually include stylesheets for each plugin
import "@fullcalendar/core/main.css";
import "@fullcalendar/daygrid/main.css";
import "@fullcalendar/timegrid/main.css";

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  props : ['ruta'],
  data: function() {
    return {
      calendarPlugins: [
        // plugins must be defined in the JS
        dayGridPlugin,
        timeGridPlugin
      ],
      lang: 'es',
      calendarWeekends: true,
      calendarEvents: [
        // initial event data
        // { title: "Event Now", start: new Date(), nuevaprop: 'NP' }
      ],

      dniBuscar: '',

      idcuota: '',
      idkiva: '',
      nombrecliente: '',
      dni: '',
      fechapago: '',
      montocuota: '',
      otroscostoscuota: '',
      saldopendientecuota: '',
      tipocambio: 1,

      condicioncuota: '',
      clasecolorcondicioncuota: '',

      pagototal: '',
      fechahoy: '',

      montoporcion: 0,
      otroscostosporcion: 0,

      descpagocuota:'',
      descpagoporcion: '',

      showdetalle: false,
      showpagocuota: false,
      showpagoporcion: false
    };
  },
  methods: {
    toggleWeekends() {
      this.calendarWeekends = !this.calendarWeekends; // update a property
    },
    gotoPast() {
      let irfecha = document.getElementById('fecha').value;
      let fechaelegida = Date.parse(irfecha);

      if(Number.isNaN(fechaelegida)){
        Swal.fire({
          position: 'top-end',
          type: 'error',
          title: 'Fecha No Válida',
          showConfirmButton: false,
          timer: 1500
        })
        return;
      };

      let fec = $('#fecha');
      fec = fec.val();

      if(fec.split('-').length > 0){
        let calendarApi = this.$refs.fullCalendar.getApi(); // from the ref="..."
        calendarApi.gotoDate(fec); // call a method on the Calendar object
      }
    },
    eventSelected(event, jsEvent, view){
      
      let evento = event.event;
      let idcuotaevent = evento.id;

      if(this.idcuota == idcuotaevent)return;

      let cuota = evento.extendedProps.cuota;
      
      this.idcuota = cuota.id;
      this.idkiva = cuota.idkiva;
      this.nombrecliente = cuota.nombre + " " + cuota.apellidopaterno + " " + cuota.apellidomaterno;
      this.dni = cuota.dni;
      this.fechapago = cuota.fechapago;
      this.montocuota = cuota.monto;
      this.otroscostoscuota = cuota.otroscostos;
      this.saldopendientecuota = cuota.saldopendiente;
      this.tipocambio = cuota.tipocambio;

      this.condicioncuota = evento.extendedProps.condicioncuota;
      this.clasecolorcondicioncuota = evento.extendedProps.clasecolorcondicioncuota;

      this.showdetalle = true;
    },
    pagarCuota: function(){
      axios.put(this.ruta+'/cuota/pagar',{
        'id': this.idcuota,
        'descripcion': this.descpagocuota
      })
        .then(res => {
          Swal.fire({
              position: 'top-end',
              type: 'success',
              title: 'El pago se realizó correctamente',
              showConfirmButton: false,
              timer: 1500
            })

          this.listarCuotasPendientes();
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

        let cuotaid = this.idcuota;

        this.generarboucher(cuotaid);
        this.limpiarDatos();
    },
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

      axios.post(this.ruta+'/cuota/porcion',{
        'id': this.idcuota,
        'monto': this.montoporcion,
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

          this.listarCuotasPendientes();
          this.showpagocuota = false;
          this.showpagoporcion = false;
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

        this.limpiarDatos();
    },
    generarboucher: function(idcuota){
        window.open(this.ruta+'/credito/detallecuotapdf/'+idcuota+'','_blank');
    },
    listarCuotasPendientes: function(){

      this.calendarEvents = [];

      axios.get(this.ruta+'/cuota')
        .then(res => {
          let cuotas = res.data.cuotas;
          let fechahoy = res.data.fechahoy;

          this.fechahoy = fechahoy;

          for(let i = 0; i < cuotas.length; i++){
  
            let backColor = '#25D201';//Si aún no vence la fecha de cancelación 
            let condicion = 'Cuota PENDIENTE DE PAGO';
            let clasecolor = 'azul';

            if(cuotas[i].fechapago < fechahoy){
              backColor = 'red';//Si se ha vencido la fecha de cancelación de la cuota
              condicion = 'Cuota ATRASADA';
              clasecolor = 'rojo';
            }

            this.calendarEvents.push({
              id: cuotas[i].id,
              title: 'KIVA: '+cuotas[i].idkiva,
              start: cuotas[i].fechapago,
              backgroundColor: backColor,
              textColor: '#FFFFFF',
              cuota: cuotas[i],
              condicioncuota: condicion,
              clasecolorcondicioncuota: clasecolor
            });
          }
        })
        .catch(err => {
            console.log(err);
        });
    },
    obtenerCuotaDeCliente: function(){

      axios.get(this.ruta+'/cuota?dni='+this.dniBuscar)
        .then(res => {
          let cuotas = res.data.cuotas;
          let fechahoy = res.data.fechahoy;

          this.fechahoy = fechahoy;

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
            this.idkiva = cuotas[0].idkiva;
            this.nombrecliente = cuotas[0].nombre + " " + cuotas[0].apellidopaterno + " " + cuotas[0].apellidomaterno;
            this.dni = cuotas[0].dni;
            this.fechapago = cuotas[0].fechapago;
            this.montocuota = cuotas[0].monto;
            this.otroscostoscuota = cuotas[0].otroscostos;
            this.saldopendientecuota = cuotas[0].saldopendiente;
            this.tipocambio = cuotas[0].tipocambio;

            this.showpagocuota = true;
          }
        })
        .catch(err => {
            console.log(err);
        });
    },
    limpiarDatos: function(){
      this.dniBuscar = '';

      this.idcuota = '';
      this.idkiva = '';
      this.nombrecliente = '';
      this.dni = '';
      this.fechapago = '';
      this.montocuota = '';
      this.otroscostoscuota = '';
      this.saldopendientecuota = '';
      this.tipocambio = 1;

      this.condicioncuota = '';
      this.clasecolorcondicioncuota = '';

      this.pagototal = '';
      this.fechahoy = '';

      this.montoporcion = 0;
      this.otroscostosporcion = 0;

      this.descpagocuota ='',
      this.descpagoporcion = '';

      this.showdetalle = false;
      this.showpagocuota = false;
      this.showpagoporcion = false;
    },
},
  mounted: function(){
    this.listarCuotasPendientes();
  }
};
</script>

<style>
  .calendario {
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 11px;
  }

  .calendario-top {
    margin: 0 0 3em;
  }

  .calendario-calendar {
    margin: 0 auto;
    max-width: 900px;
  }

  .fc-event-container{
    cursor: pointer;
  }

  .fc-toolbar .fc-header-toolbar{
    width: auto;
  }
  .fc-left, .fc-center, .fc-right{
    width: 100%;
    display: block; 
  }

  .fc-center{
    text-transform: uppercase;
  }  

  .card{
    margin-top: 20px;
  }

  .rojo{
    color: #ac4232;
  }

  .azul{
    color: #32a4ac;
  }
</style>
