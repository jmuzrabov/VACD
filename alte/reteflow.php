<!DOCTYPE html>
<html>
<head>
	<title>VACD</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" sizes="32x32" href="meta/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="meta/favicon-16x16.png">
	<link rel="icon" type="image/png" href="meta/favicon.ico">
	<link rel="mask-icon" href="meta/safari-pinned-tab.svg" color="#ce470a">
	<link rel="stylesheet" type="text/css" href="css/_plug/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/forms.css">
	<link rel="stylesheet" type="text/css" href="css/yd.css">

	<style>
		table,
		th,
		td {
			/* border: 1px solid black; */
			border-collapse: collapse;
			width: 100%;
		}
		#rete{
			overflow: hidden;
			touch-action: none;
			width: 100% !important;
			height: 70vh;
		}

		#buttons,.buttons{
			display: flex;
			justify-content: start;
			flex-direction: row;
			width: 100%;
		}
		.node .red {
			background: red;
		}
		.extBtn{
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			align-content: stretch;
		}
		/*#extBtn input:first-child{
			margin-right: 10px;
		} */
		.saveBtn,.hinzufuegenBTN{
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 10px;
		}
		.smallmsg{
			position: absolute;
			left: auto;
			right: auto;
			top: 60px;
			margin-left: 5px;
		}
		.progress-bar{
			margin-top: 10px;
			height: 35px;
		}
		.progress-bar-fill{
			height: 100%;
			width: 0%;
			background: lightblue;
			display: flex;
			align-items: center;
			transition: width 0.25s;
		}
		.progress-bar-text{
			margin-left: 5px;
			font-weight: bold;

		}
		#dropZone{
			border: 3px dashed #fd7e14;
			padding: 10px;
			width: 100%;
			height: auto;

		}
		#dropZone>span{
			display: block;
			text-align: center;
			color: #244669;
		}
		#dropZone>span,
		#fileUPLOAD{
			height: 35px;
			line-height: 35px;
			color: #244669;
		}
		#files{
			border:1px dotted #0088cc;
			padding:20px;
			width:100%;
			display: none;
		}
		#fileUPLOAD{
			position: relative;
			opacity: 1;
			filter: alpha(opacity=1);
			width: 100%;

		}
		#error{
			color:red;
			margin-top:10px;
		}
		#progress{
			height: 100%;
			width: 0%;
			background: lightblue;
			display: flex;
			align-items: center;
			transition: width 0.25s;
		}
	</style>

</head>
<body translate="no">
	<article class="row no-gutters">
		<aside class="col-auto">
			<a href="/" class="logo bone"><div></div></a>
			<nav class="bone">
					<!-- <a href="#" id="grafikSPEICHERN" >Save Graph</a>
					<a href="#" id="telnummerHINZUFUEGEN" >Update Graph</a> -->
					<!-- <h4><b>Meine Graphen</b></h4> -->
					<!-- <input type="button" class="btn btn-outline-primary mt-3" id="generator" value="Generate" />
					<input type="button" class="btn btn-outline-primary mt-3" id="grafikSPEICHERN" value="Save Graph" />
					<input type="button" class="btn btn-outline-primary mt-3" id="telnummerHINZUFUEGEN" value="Telnummer Update" /> -->
			</nav>
			<footer>
				<nav class="bone">
					<!-- <input type="button" class="btn btn-primary mb-3" id="test" value="test" /> -->
					<a href="#" id="test">TEST</a>
					<a href="#" id="generator">Generate</a>
				</nav>
				<small>
					currentVersion&nbsp;
					<a href="#" onclick="location.reload(true)">
						<img src="//assets.yoummday.com/icons/mdi-reload.svg?color=%23eb6608" style="width:16px;">
					</a>
				</small>
			</footer>
		</aside>
		<div class="col row no-gutters flex-column">
			<header class="bone text-center">
				<div class="row">
					<div class="col-xs-6 col-md-4">
						<div class="row">
							<div class="col-xs-6 col-md-4 p-2">
								<!-- <span class="text-muted"><label for="worktype_label">HEADER</label></span> -->
							</div>
							<div class="col-xs-12 col-sm-6 col-md-8 p-2 text-left">
								<span class="font-weight-bold text-uppercase "><label id="worktype_label">EDITOR</label></span>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-8"></div>
				</div>
			</header>
			<div class="content col">
				<div class="row justify-content-around" >
					<div id="buttons"></div>
				</div>
				<div class="row justify-content-around">
					<div class="card col-sm-6 col-md-9">
						<div class="card-body">
							<div id="rete"></div>
						</div>
					</div>
					<div class="card col-4 col-md-3 p-3" >
						<div class="card-body justify-content-around">
								<div class="col" id="divGRAFIKLIST">
									<label for="grafikLIST">Gespeicherte Grafiken</label>
									<select id="grafikLIST" class="grafikLIST" name="grafikLIST" >
										<option value="#">--</option>
									</select>
								</div><!-- divGRAFIKLIST-->
								<div class="col extBtn">
										<input type="button" class="btn btn-primary mt-3 " id="grafikSPEICHERN" value="Grafik speichern" />
								</div>
								<div class="col hidden" id="divGRAFIKNAME">
											<label for="neueGRAFIKNAME">Grafikname:</label>
											<input type="text" name="neueGRAFIKNAME" id="neueGRAFIKNAME" value=""/>
											<p class="smallmsg"><small id="smallmsg"></small></p>
											<input type="button" class="btn btn-small btn-primary mt-3 mb-3" id="save" value="speichern" />
								</div><!-- divGRAFIKNAME-->
								<div class="col extBtn">
										<input type="button" class="btn btn-primary mt-3" id="telnummerHINZUFUEGEN" value="Telnummer hinzufügen" />
								</div>
								<div class="col hidden" id='divTELNUMMER'>
											<label for="selectTELNUMMER">Telfonnummer:</label>
											<select id="selectTELNUMMER" size="">
												<option value="#" selected>--</option>
											</select>
											<input type="submit" class="btn btn-small btn-primary mt-3" id="hinzufuegen" value="hinzufügen" />
								</div><!-- divTELNUMMER-->
								<div class="col extBtn">
									<input type="button" class="btn btn-primary mt-3" id="soundUPLOAD" value="Sound hochladen" />
									<!-- <form class="form" id="uploadFORM">
										<input type="file" name="inputFILE" value="inputFILE"><br>
										<input type="submit" class="button btn btn-primary" value="UPLOAD">
									</form>
									<div class="progress-bar" id="progressBAR">
										<div class="progress-bar-fill">
											<span class="progress-bar-text">0%</span>
										</div>
									</div> -->
									<!-- <div class="custom-file">
									  <input type="file" class="custom-file-input" id="customFile">
									  <label class="custom-file-label" for="customFile">Choose file</label>
									</div> -->
								</div><!-- soundUPLOAD -->
								<div class="col hidden" id='divSOUNDUPLOAD'>
									<div class="" id="dropZone">
										<span>Drag & Drop Files...</span>
										<input type="file" name="attachmets[]" value="" id="fileUPLOAD" multiple>
									</div>
									<!-- <input type="button" class="btn btn-small btn-primary mt-3 mb-3" id="save2" value="speichern" /> -->
									<span id="error"></span><br><br>
									<span id="progress"></span><br><br>

									<div class="" id="files"></div>

								</div><!-- divSOUNDUPLOAD-->
								<!-- <div class="col hidden" id="divSOUNDNAME">
											<label for="neueSOUNDNAME">Grafikname:</label>
											<input type="text" name="neueSOUNDNAME" id="neueSOUNDNAME" value=""/>
											<p class="smallmsg"><small id="smallmsg2"></small></p>
											<input type="button" class="btn btn-small btn-primary mt-3 mb-3" id="soundnameSPEICHERN" value="speichern" />
								</div><!-- divGRAFIKNAME-->

						 </div><!-- card-body-->
					</div>
					<div class="text">
						<div id="out" class="mb-3"></div>
						<div id="ausgabe" class="col-sm-6 col-md-10 mb-3"><ul></ul></div>
					</div>
					<!-- <div class="text-center">
						<input type="button" class="btn btn-outline-primary mt-3" id="generator" value="Generate" />
						<input type="button" class="btn btn-outline-primary mt-3" id="grafikSPEICHERN" value="Save Graph" />
						<input type="button" class="btn btn-outline-primary mt-3" id="telnummerHINZUFUEGEN" value="Telnummer Update" />
					</div> -->
				</div>
			</div>
		</div>
	</article>

	<script src="./js/rete.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.6/vue.min.js"></script>
	<script src="./js/vue-render-plugin.min.js"></script>
	<script src="./js/connection-plugin.min.js"></script>
	<script src="./js/alight.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js"></script>
	<script src="./js/context-menu-plugin.min.js"></script>
	<script src="./js/area-plugin.min.js"></script>
	<script src="./js/comment-plugin.min.js"></script>
	<script src="./js/history-plugin.min.js"></script>
	<script src="./js/connection-mastery-plugin.min.js"></script>
	<script src="./js/jquery-3.5.1.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="./js/jq/vendor/jquery.ui.widget.js"></script>
	<script src="./js/jq/jquery.iframe-transport.js"></script>
	<script src="./js/jq/jquery.fileupload.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			var graphObj;
			$.ajax({
					type: 'GET',
					contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
					dataType: "json",
					data:
					{
						auth: window.localStorage.getItem("auth"),
						couser: localStorage.couserID
					},
					url: 'https://apiqa.yoummday.com/vacd/graphlist',
					success: function(result){
						// console.log('graphObj=>',graphObj);
						// console.log('result=>',result);
						delete result["authTime"];
						delete result["success"];
						if(Object.keys(result).length > 0) {
							Object.keys(result).forEach(key => {
								// console.log('result[key]=>',result[key]);
								if(result[key]["name"] != ""){
									$("#grafikLIST").append('<option value='+ result[key]["id"] + '>' + result[key]["name"] + '</option>');
								}
								$("#grafikLIST").change(function(){
									graphObj = "";
									$('#grafikLIST option:selected').each(function(){
										if(result[key].id === this.value){
											console.log('result[key]=>',result[key]);
											graphObj = result[key];
											let graphObjID = result[key].id;
											let graphObjNAME = result[key].name;
											let graphObjJSON = result[key].json;
											$('#ausgabe ul').empty();
											$('#ausgabe ul').append('<li> ' + 'ID: ' + graphObjID + '</li><li>' + 'NAME: ' + graphObjNAME + '</li><li>' + 'JSON: ' + graphObjJSON + '</li>');
										}
									});//$('#grafikLIST option:selected')
								});//$("#grafikLIST")
							});//Object.keys(result)
						}

					},
					error: function(error){
						console.log(error);
					}
				});//$.ajax
				// console.log('graphObj=>',graphObj);
			//FUNCTIONEN
			function telNummerliste(){
							$.ajax({
								type:'GET',
								contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
								dataType: 'json',
								data: {
												auth:localStorage.auth,								//"qaib2r73g865j8dsnw609HVpSzt_sYP4ceUEfr2TPxIKknBQ6XTujR93FnhdBbX",
												couser:localStorage.couserID
											},
								url: 'https://apiqa.yoummday.com/vacd/numberlist',
								success: function(result){
									Object.keys(result).forEach(key =>{
										if(!isNaN(key)){
											// console.log(result[key]);
											$("#selectTELNUMMER").append('<option value="' + key + '">' + result[key] + '</option>');
											}
										});
									},
									error: function(error){
										console.log('error=>',error);
									}
							});//graph
						}
			function graphID(p){
							let gID;
							let graphdata = JSON.stringify(editor.toJSON());
							console.log(graphdata);
							$( "#grafikLIST" ).change(function () {
								gID = "";
								$( "#grafikLIST option:selected" ).each(function() {
									gID += $( this ).val();
									console.log(this)
									// $(this).text(JSON.stringify(editor.toJSON()));
								});
								p = gID;
							})
							.change();

							console.log('pID=>',p);
							return p;
						}
			function telNumwahl(p){
							let tNum;
							$( "#selectTELNUMMER" ).change(function () {
								tNum = "";
								$( "#selectTELNUMMER option:selected" ).each(function() {
									tNum += $( this ).text();
								});
								p = tNum;
							})
							.change();
							console.log('pNum=>',p);
							return p;
						}
		// $(function(){
		// 						var files = $("#files");
		// 						localStorage.removeItem('fileName');
		// 						localStorage.removeItem('fileSize');
		//
		//
		// 						$("#fileUPLOAD").fileupload({
		// 							url:'reteflow.php',
		// 							type: 'POST',
		// 							dataType:'json',
		// 							dropZone: '#dropZone',
		// 							autoUpload:false
		// 					}).on('fileuploadadd', function(e, data){
		// 						// console.log(data);
		// 						var fileTypeAllowed = /.\.(wav)$/i;
		// 						var fileName = data.originalFiles[0]['name'];
		// 						var fileSize = data.originalFiles[0]['size'];
		// 						console.log(data.originalFiles);
		// 						if(!fileTypeAllowed.test(fileName))
		// 							$('#error').html('Nur wav Format dürfen!');
		// 						else if(fileSize > 2000000)
		// 							$('#error').html('Max. größe 2000KB');
		// 						else{
		// 							$('#error').html('');
		// 							data.submit();
		// 							// console.log('data=>',data);
		// 							window.localStorage.setItem("fileName", data.originalFiles[0]['name']);
		// 							window.localStorage.setItem("fileSize", data.originalFiles[0]['size']);
		// 							window.localStorage.setItem("fileOrg", data.originalFiles[0]['files']);
		// 						}
		// 					}).on('fileuploaddone', function(e, data){
		// 							console.log('data=>',data);
		// 					}).on('fileuploadprogressall', function(e, data){
		// 							// console.log(data);
		// 							var progress = parseInt(data.loaded / data.total * 100, 10);
		// 							$('#progress').html('Completed: ' + progress + '%');
		// 					});
		// 				})
			// CLICK EVENTS //
			//Grafik speichern
			$("#grafikSPEICHERN").click(function() {
							$(this).addClass('hidden');
							$("#divGRAFIKNAME").removeClass("hidden");
							let graphdata = JSON.stringify(editor.toJSON());
							// console.log('graphdata=>',graphdata);
							let graphname = $("#neueGRAFIKNAME");
							$("#save").click(function() {
								if(graphname.val() != ""){
									$.ajax({
											type: 'POST',
											contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
											dataType: "json",
											data: {
												auth: window.localStorage.getItem("auth"),
												name: graphname.val(),
												json: graphdata
											},
											url: 'https://apiqa.yoummday.com/vacd/submitgraph',
											success: function(responsedata){
												$("#divGRAFIKNAME").addClass("hidden");
												$("#grafikSPEICHERN").removeClass('hidden');
												// to do: refresh grafikLIST on the nav leftside
												// console.log(responsedata);
												location.reload();
												//inputfeld leeren
												graphname.val('');
												// $("#submitmessage").fadeIn().fadeOut(2000);


											},
											error: function(error){
												$("#divGRAFIKNAME").addClass("hidden");
												console.log(error);
											}
										});
									} else{
										$("#smallmsg")
										.css("color", "red")
										.text('Name is empty');
									}
								});
						});//#grafikSPEICHERN

			//Telefonnummer hinzufügen
			$('#telnummerHINZUFUEGEN').click(function(){
							$(this).addClass('hidden');
							$('#divTELNUMMER').removeClass('hidden');
							telNummerliste();
							var graphid = graphID(graphid);
							console.log('graphid=>',graphid);

							$('#hinzufuegen').click(function(){
								var num = telNumwahl(num);
								console.log('num=>',num);
									$.ajax({
										type:'POST',
										contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
										dataType: 'json',
										data: {
														auth:window.localStorage.getItem("auth"),				//"qaib2r73g865j8dsnw609HVpSzt_sYP4ceUEfr2TPxIKknBQ6XTujR93FnhdBbX",
														graphid: graphid,
														number: num
													},
										url: 'https://apiqa.yoummday.com/vacd/graph',
										success: function(result){
												$('#telnummerHINZUFUEGEN').removeClass('hidden');
												console.log('geklappt!');
												location.reload();

											},
											error: function(error){
												console.log('error=>',error);
											}
									});//graph
									$('#divTELNUMMER').addClass('hidden');
							});
						});//#telnummerHINZUFUEGEN

			//Sound hochladen
			$('#soundUPLOAD').click(function(e){
				$('#divSOUNDUPLOAD').removeClass('hidden');
				$('#soundUPLOAD').addClass('hidden');
				// console.log(fileName);
				$.ajax({
							type:'POST',
							url:'https://apiqa.yoummday.com/vacd/uploadsound',
							contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
							dataType: "json",
							data:{
								auth: window.localStorage.getItem("auth"),
								couser: window.localStorage.getItem("couserID"),
								name:window.localStorage.getItem("fileName")
								// file:''

							},//data
						success: function(result){
							console.log('result=>',result);
						},
						error: function(error){
							console.log(error);
						}
			});//$.ajax

});//$('#soundHOCHLADEN')



























			$('#test').click(function(){
							// $('#rete').empty();


			});
		});//$(document).ready
	</script>
	<script id="rendered-js">

		var numSocket = new Rete.Socket('Number value');

		var VueTimeControl = {
			  props: ['readonly', 'emitter', 'ikey', 'getData', 'putData'],
			  template: '<input type="time" :readonly="readonly" :value="value" @input="change($event)" @dblclick.stop="" @pointerdown.stop="" @pointermove.stop=""/>',
			  data() {
			    return {
			      value: 0 };

			  },
			  methods: {
			    change(e) {
			      this.value = e.target.value;
			      this.update();
			    },
			    update() {
			      if (this.ikey)
			      this.putData(this.ikey, this.value);
			      this.emitter.trigger('process');
			    } },

			  mounted() {
			    this.value = this.getData(this.ikey);
			  }
			};

		class TimeControl extends Rete.Control {

			  constructor(emitter, key, readonly) {
			    super(key);
			    this.component = VueTimeControl;
			    this.props = { emitter, ikey: key, readonly };
			  }

			  setValue(val) {
			    this.vueContext.value = val;
			  }
			}

		var VueDayControl = {
				  props: ['readonly', 'emitter', 'ikey', 'getData', 'putData'],
				  template: '<select :readonly="readonly" :value="value" @input="change($event)" @dblclick.stop="" @pointerdown.stop="" @pointermove.stop="">\
				<option value="1" selected>Montag</option>\
				<option value="2">Dienstag</option>\
				<option value="3">Mittwoch</option>\
				<option value="4">Donnerstag</option>\
				<option value="5">Freitag</option>\
				<option value="6">Samstag</option>\
				<option value="0">Sonntag</option>\
				</select>',
				  data() {
				    return {
				      value: 0 };

				  },
				  methods: {
				    change(e) {
				      this.value = e.target.value;
				      this.update();
				    },
				    update() {
				      if (this.ikey)
				      this.putData(this.ikey, this.value);
				      this.emitter.trigger('process');
				    } },

				  mounted() {
				    this.value = this.getData(this.ikey);
				  }
				};

		class DayControl extends Rete.Control {

		  constructor(emitter, key, readonly) {
		    super(key);
		    this.component = VueDayControl;
		    this.props = { emitter, ikey: key, readonly };
		  }

		  setValue(val) {
		    this.vueContext.value = val;
		  }
		}

		var VueNumControl = {
		  props: ['readonly', 'emitter', 'ikey', 'getData', 'putData'],
		  template: '<input type="tel" :readonly="readonly" :value="value" @input="change($event)" @dblclick.stop="" @pointerdown.stop="" @pointermove.stop=""/>',
		  data() {
		    return {
		      value: 0 };

		  },
		  methods: {
		    change(e) {
		      this.value = +e.target.value;
		      this.update();
		    },
		    update() {
		      if (this.ikey)
		      this.putData(this.ikey, this.value);
		      this.emitter.trigger('process');
		    } },

		  mounted() {
		    this.value = this.getData(this.ikey);
		  } };

		class NumControl extends Rete.Control {

		  constructor(emitter, key, readonly) {
		    super(key);
		    this.component = VueNumControl;
		    this.props = { emitter, ikey: key, readonly };
		  }

		  setValue(val) {
		    this.vueContext.value = val;
		  }}

		var VueStringControl = {
		  props: ['readonly', 'emitter', 'skey', 'getData', 'putData'],
		  template: '<input type="text" :readonly="readonly" :value="value" @input="change($event)" @dblclick.stop="" @pointerdown.stop="" @pointermove.stop=""/>',
		  data() {
		    return {
		      value: "None" };

		  },
		  methods: {
		    change(e) {
		      this.value = e.target.value;
		      this.update();
		    },
		    update() {
		      if (this.skey)
		      this.putData(this.skey, this.value);
		      this.emitter.trigger('process');
		    } },

		  mounted() {
		    this.value = this.getData(this.skey);
		  } };

		class StringControl extends Rete.Control {

		  constructor(emitter, key, readonly) {
		    super(key);
		    this.component = VueStringControl;
		    this.props = { emitter, skey: key, readonly };
		  }

		  setValue(val) {
		    this.vueContext.value = val;
		  }}

		class ProviderComponent extends Rete.Component {

		  constructor() {
		    super("Provider");
		  }

		  builder(node) {
		    var out1 = new Rete.Output('num', "Provider", numSocket, false);

		    // return node.addControl(new NumControl(this.editor, 'num')).addOutput(out1); -->
		    return node.addOutput(out1);
		  }

		  worker(node, inputs, outputs) {
		    // outputs['num'] = node.data.num; -->
		  }

		  }


		class RedirectComponent extends Rete.Component {

		  constructor() {
		    super("Redirect");
		  }

		  builder(node) {
		    // var out1 = new Rete.Output('num', "Provider", numSocket); -->
			var inp1 = new Rete.Input('num', "In", numSocket, true);
		    // return node.addControl(new NumControl(this.editor, 'num')).addOutput(out1); -->
			node.addControl(new NumControl(this.editor, 'targetnumber'));
			node.addInput(inp1);
		    return node;
		  }

		  worker(node, inputs, outputs) {
		    //<!-- outputs['num'] = node.data.num; -->
		  }

		  }

		class ForceRecordingComponent extends Rete.Component {
		  constructor() {
		    super("Force Recording");
		  }

		  builder(node) {
		    var inp1 = new Rete.Input('num', "", numSocket, true);
		    // var inp2 = new Rete.Input('num2', "Number2", numSocket); -->
		    var out = new Rete.Output('num', "", numSocket, false);

		    return node.addInput(inp1).addOutput(out);

		  }

		  worker(node, inputs, outputs) {
		    // var n1 = inputs['num'].length ? inputs['num'][0] : node.data.num1; -->
		    // var n2 = inputs['num2'].length ? inputs['num2'][0] : node.data.num2; -->
		    // var sum = n1 ;//+ n2; -->

		    // this.editor.nodes.find(n => n.id == node.id).controls.get('preview').setValue(sum); -->
		    // outputs['num'] = sum; -->
		  }}

		class PromptUserComponent extends Rete.Component {
		  constructor() {
		    super("Prompt User");
		  }

		  builder(node) {
		    var inp1 = new Rete.Input('num', "", numSocket, true);

			for (var i=0;i< 10; i++){
				node.addOutput(new Rete.Output('num'+i, ""+i, numSocket, false));
			}

		    node.addControl(new StringControl(this.editor, 'path'));
		    return node.
		    addInput(inp1);
		  }

		  worker(node, inputs, outputs) {

		  }}

		class WeekDayComponent extends Rete.Component {
		  constructor() {
		    super("Wochentag");
		  }

		  builder(node) {
		    var inp1 = new Rete.Input('num', "", numSocket, true);
		    node.addControl(new DayControl(this.editor, 'weekdaystart'));
		    node.addControl(new DayControl(this.editor, 'weekdayend'));
		    node.addOutput(new Rete.Output('num1', "Richtiger Wochentag", numSocket, false));
		    node.addOutput(new Rete.Output('num2', "Falscher Wochentag", numSocket, false));
		    return node.
		    addInput(inp1);
		  }

		  worker(node, inputs, outputs) {

		  }}

		class TimeComponent extends Rete.Component {
		  constructor() {
		    super("Uhrzeit");
		  }

		  builder(node) {
		    var inp1 = new Rete.Input('num', "", numSocket, true);
		    node.addControl(new TimeControl(this.editor, 'timestart'));
		    node.addControl(new TimeControl(this.editor, 'timeend'));
		    node.addOutput(new Rete.Output('num1', "Richtige Uhrzeit", numSocket, false));
		    node.addOutput(new Rete.Output('num2', "Falsche Uhrzeit", numSocket, false));
		    return node.
		    addInput(inp1);
		  }

		  worker(node, inputs, outputs) {

		  }}

		class SoundComponent extends Rete.Component {
		  constructor() {
		    super("Sounddatei");
		  }

		  builder(node) {
		    var inp1 = new Rete.Input('num', "", numSocket, true);

		    node.addOutput(new Rete.Output('num', "", numSocket, false));
		    node.addControl(new StringControl(this.editor, 'path'));
		    return node.
		    addInput(inp1);
		  }

		  worker(node, inputs, outputs) {

		  }}

		class SplitComponent extends Rete.Component {
		  constructor() {
		    super("Verteiler");
		  }

		  builder(node) {
		    var inp1 = new Rete.Input('num', "", numSocket, true);

		    node.addOutput(new Rete.Output('num1', "", numSocket, false));
		    node.addOutput(new Rete.Output('num2', "", numSocket, false));

		    return node.
		    addInput(inp1);
		  }

		  worker(node, inputs, outputs) {

		  }}

		var editor;

		var components = [new ProviderComponent(), new ForceRecordingComponent(), new RedirectComponent(), new PromptUserComponent(), new WeekDayComponent(), new TimeComponent(), new SoundComponent(), new SplitComponent()];
		var targ = $("#buttons");
		for (var i = 0; i < components.length; i++) {
			var el = components[i];
			targ.append('<input class="btn btn-outline-primary mb-3" type="button" name="' + i + '" value="' + el.name + '"/><br>');
		}

		$("#buttons input").click(async function(index) {
			console.log(this);
			var n1 = await components[this.name].createNode();
			editor.addNode(n1);
		});

		(async () => {
			var container = document.querySelector('#rete');

			editor = new Rete.NodeEditor('vacd@0.1.0', container);
			editor.use(ConnectionPlugin.default);
			editor.use(VueRenderPlugin.default);
			editor.use(ContextMenuPlugin.default);
			editor.use(AreaPlugin);
			editor.use(CommentPlugin.default);
			editor.use(HistoryPlugin);
			editor.use(ConnectionMasteryPlugin.default);

			var engine = new Rete.Engine('vacd@0.1.0');

			components.map(c => {
				editor.register(c);
				engine.register(c);
			});

			var n1 = await components[0].createNode({
				num: 2
			});
			var n2 = await components[0].createNode({
				num: 0
			});
			var add = await components[1].createNode();

			n1.position = [0, 200];
			//n2.position = [80, 400];-->
			add.position = [200, 240];

			//editor.addNode(n1);
			//editor.addNode(n2);
			//editor.addNode(add);

			//editor.connect(n1.outputs.get('num'), add.inputs.get('num'));
			//editor.connect(n2.outputs.get('num'), add.inputs.get('num2'));

			editor.on('process nodecreated noderemoved connectioncreated connectionremoved nodetranslated', async (e) => {
				console.log("process");
				//<!--console.log(editor.toJSON());-- >
				await engine.abort();
				await engine.process(editor.toJSON());
				window.localStorage.setItem('savedEditor', JSON.stringify(editor.toJSON()));

			});

			var savedEditor = window.localStorage.getItem("savedEditor");
			if (savedEditor) {
				editor.fromJSON(JSON.parse(savedEditor));
			}

			editor.trigger('process');
			editor.view.resize();
			AreaPlugin.zoomAt(editor);
		})();

		$("#generator").click(function() {
			$("#out").text(JSON.stringify(editor.toJSON()));
			for (var i = 0; i < editor.nodes.length; i++) {
				var node = editor.nodes[i];
				var allconnected = true;
				for (let value of node.outputs.values()) {
					if (value.connections.length == 0) {
						allconnected = false;
					}
				}
				console.log('allconnected=>',allconnected);
				if (!allconnected) {
					$(node.vueContext.$el)
					.css("background", "red")
					.fadeOut(100)
					.fadeIn(100)
					.fadeOut(100)
					.fadeIn(100);
					// editor.trigger("addcomment", ("frame",  "Not connected", node));
				}
			}
		});





	</script>

</body>
</html>