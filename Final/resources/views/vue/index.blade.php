<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

@extends('layouts.general')

@section('content')

<h1 class="text-center"> Buscador de Instituciones </h1>
<br><br>
<div id="app">
	<div class="row container-fluid">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
	  		Partido: 
		  	<select @change="buscarRegionSanitaria($event)" v-model="selected">
				<option v-for="partido in partidos" v-bind:value="partido.id">
				    @{{ partido.nombre }}
				</option>
			</select> 
			Región Sanitaria: @{{region_sanitaria}}
		</div>	
		<div class="col-sm-4"></div>
	</div>

	<br><br>
	<div class="container">
	    <div class="row">
	    	<ul class="list-group" style="width: 100%">
		    	<li class="list-group-item row d-flex text-center">
		    		<div class="col-1 text-info">#</div>
		    		<div class="col-4 text-info">Institución</div>
		    		<div class="col-2 text-info">Director/a</div>
		    		<div class="col-2 text-info">Dirección</div>
		    		<div class="col-3 text-info">Teléfono</div>
		    	</li>
		    	<li v-for="institucion in instituciones" class="list-group-item row d-flex text-center">
		    		<div class="col-1">@{{institucion.id}}</div>
		    		<div class="col-4">@{{institucion.name}}</div>
		    		<div class="col-2">@{{institucion.director}}</div>
		    		<div class="col-2">@{{institucion.address}}</div>
		    		<div class="col-3">@{{institucion.phone_number}}</div>
		    	</li>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	new Vue({
	  	el: '#app',
	  	data () {
		    return {
		      partidos: null,
		      selected: "",
		      region_sanitaria: "",
		      instituciones: null
		    }
	  	},
	 	methods: {
        	buscarRegionSanitaria(event) {
            	axios
		      	.get('https://api-referencias.proyecto2018.linti.unlp.edu.ar/region-sanitaria/'+event.target.value)
		      	.then(response => {
		      		this.region_sanitaria = response.data.id;
		      		this.buscarInstituciones(response.data.id);
		      	})
        	},
        	buscarInstituciones(id) {
        		console.log(app_url)
        		axios
		      	.get(app_url + '/api/instituciones/region-sanitaria/'+id)
		      	.then(response => (this.instituciones = response.data))
        	} 
    	},
	  	mounted () {
	    	axios
	      	.get('https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido')
	      	.then(response => (this.partidos = response.data))
	  	}
	})
</script>

@endsection


