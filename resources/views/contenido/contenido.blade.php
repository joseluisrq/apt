 @extends('principal')
 @section('contenido')

 @if(Auth::check()) <!--si el usuario esta autentificado-->
       @if (Auth::user()->idrol == 1)
             
                     <template v-if="menu==0">
                           <h1>Escritorio</h1>       
                     </template>

                     <template v-if="menu==1">
                            <user></user>
                     </template>
                     
                     <template v-if="menu==2">
                            <rol></rol>
                     </template>
                     
                     <template v-if="menu==3">
                          <cliente></cliente>
                     </template>
                     
                     <template v-if="menu==4">
                            <credito></credito>
                     </template>
                     
                     <template v-if="menu==5">
                            <h1>Asiganar Credito</h1>       
                     </template>

                     <template v-if="menu==6">
                            <h1>Reportes</h1>       
                     </template>

                     <template v-if="menu==7">
                            <h1>Acerca de</h1>       
                     </template>
                         
                     </template>
       @elseif (Auth::user()->idrol == 2)
              
       @elseif (Auth::user()->idrol == 3)
              

                     <template v-if="menu==3">
                            <cliente></cliente>
                     </template>
       @else
       
       @endif

@endif


   

 <!-- Contenido Principal -->
 
<!-- /Fin del contenido principal -->

@endsection