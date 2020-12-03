// $(document).ready(function(){
  //aktulle Uhrzeit
  // var currentdate = new Date();
  //
  // //aktuelle Uhrzeit formatieren
  // var datetime =currentdate.getDate() + "." + (currentdate.getMonth()+1)  + "." + currentdate.getFullYear() + "  "
  //           	+ currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
  //
  // //graphlist Daten
  // var graphObj;
  // var graphObj1;
  // var soundObj;
  // var telnummObj;
  // //Aktuelle Uhrzeit
  // function showTime(){
  // 	// var dayName =
  // 	var date = new Date();
  // 	var day = date.getDate();
  // 	var month = (date.getMonth()+1);
  // 	var year = date.getFullYear();
  // 	var h = date.getHours();
  // 	var m = date.getMinutes();
  // 	var s = date.getSeconds();
  //
  // 	if(h == 0){
  // 		h = 12;
  // 	}
  // 	if(h == 0){
  // 		h = h-12;
  // 	}
  //
  // 	h = (h < 10)? '0' + h : h;
  // 	m = (m < 10)? '0' + m : m;
  // 	s = (s < 10)? '0' + s : s;
  //
  // 	var time = day + '.' + month + '.' + year + '  ' + h + ':' + m + ':' + s ;
  // 	var timeLabel = $('#worktype_label');
  // 	timeLabel.append(time);
  // }
  // showTime();
  // setTimeout(showTime, 1000);
  // function showTime(){
  // 	var currentDateTime = dayjs().format('DD.MM.YYYY hh:mm');
  // 	                var timeLabel = $('#worktype_label');
  // 	                timeLabel.append(currentDateTime);
  // 	}
  // 	showTime();
  //Click EVENTS

  //Anrufverlaufliste/gespeicherte Grafik im Editor anzeigen
  $.ajax({
      type: 'GET',
      contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
      dataType: "json",
      data:
      {
        auth: window.localStorage.getItem("auth"),
        couser: window.localStorage.getItem("couserID")
      },
      url: 'https://apiqa.yoummday.com/vacd/graphlist',
      success: function(result){
        // console.log('graphObj=>',graphObj);
        console.log('graphlist=>',result);
        delete result["authTime"];
        delete result["success"];

        if(Object.keys(result).length > 0) {

          Object.keys(result).forEach(key => {

            if(Object.keys(result[key])){
              Object.keys(result[key]).forEach(i => {
                // console.log('result[key][i]=>',result[key][i]);
                // console.log('result[key][i]["name"]=>',result[key][i]['name']);
                $("#grafikLIST1").append('<option value='+ result[key][i]["id"] + '>' + result[key][i]["name"] + '</option>');
                // $("#grafikLIST2").append('<option value='+ result[key][i]["id"] + '>' + result[key][i]["name"] + '</option>');
              }//Object.keys

            )}//if

            //Anrufverlaufliste/gespeicherte Grafik im Editor anzeigen
            $("#grafikLIST1").change(function(){

              $('#grafikLIST1 option:selected').each(function(){

                if(result[key]){

                  Object.keys(result[key]).forEach(i => {
                    if(i === this.value){

                    let graphObjID = result[key][i].id;
                    let graphObjNAME = result[key][i].name;
                    let graphObjJSON = result[key][i].json;
                    // console.log(result[key].json);
                    let json = result[key][i].json;
                    $('#graphInfo ul').empty();
                    editor.fromJSON( JSON.parse(json));
                    $('#graphInfo ul').append('<li>ID:<small><i> ' + graphObjID + '</i></small></li>' + '<li>Name:<small><i> ' + graphObjNAME + '</i></small></li>'+ '<li>JSON:<small><i> ' + graphObjJSON + '</i></small></li>');

                  }//if(i === this.value)
                  });//Object.keys(result[key]).forEach
                }//if(result[key]

                $.ajax({
                    type: 'GET',
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                    dataType: "json",
                    data:
                    {
                      auth: window.localStorage.getItem("auth"),
                      couser: window.localStorage.getItem("couserID")
                    },
                    url: 'https://apiqa.yoummday.com/vacd/soundlist',
                    success: function(result){

                      console.log('soundlist=>',result);
                      delete result["authTime"];
                      delete result["success"];

                      let ausgabe = $('#ausgabe');
                      let ausgabeUL = $('#ausgabe ul');
                      ausgabeUL.empty();
                      if(Object.keys(result).length > 0) {

                        Object.keys(result).forEach(key => {
                          if(Object.keys(result[key])){
                            Object.keys(result[key]).forEach(index =>{
                              if(result[key][index]['filename']){
                                let fieleID = result[key][index]["id"];
                                let fileName = result[key][index]["filename"];
                                let fileTS = result[key][index]["uploadTS"];
                                // console.log(fileName);
                                let select = $('#soundlist');
                                // console.log(select);
                                select.append('<option value="' + fieleID + '">' + fileName + '</option>');

                                // ausgabeUL.append('<li><input type="checkbox" name="' + fieleID + '" value="' + fileName + '"><label for="'+ fieleID + '"> '+ fileName + '</label><i><small>' + fileTS +'</small></i></li>');

                              }else{
                                // $("#soundLIST").append('<option value='+ result[key][index]["id"] + '>' + 'keine Name' + '</option>');
                              }

                            });//Object.keys(result[key]).forEach
                          }//if
                        });//Object.keys(result)
                      }


                    },
                    error: function(error){
                      console.log(error);
                    }
                  });//$.ajax

              });//$('#grafikLIST option:selected')
            });//$("#grafikLIST")



          });//Object.keys(result)
        }//if(Object.keys(result).length > 0)
      },//success: function(result)
      error: function(error){
        console.log(error);
      }
    });//$.ajax
  //couserlist Daten
  $.ajax({
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
    dataType: "json",
    data:{
      auth: localStorage.auth,
      couser: localStorage.couserID
        },
    url: 'https://apiqa.yoummday.com/vacd/couserslist',
    success: function(data){
      delete data["authTime"];
      delete data["success"];
      console.log('couserlist=>',data);
      // console.log('data.couserlist=>',data.couserlist);
      // console.log('name=>',localStorage.name);
      let span = document.createElement('span');
      let timeLabel = $('#worktype_label');
      // span.setAttribute('class','clock');
      // span.setAttribute('data-tz','Europe/Berlin');
      // span.append(datetime);
      // timeLabel.append(span);


      let header = $('#custom');
      let a = document.createElement('a');
      let divBack = $('#back');
      let aBack = document.createElement('a');

      let backSpan = document.createElement('span');
      backSpan.setAttribute('class','iconify');
      backSpan.setAttribute('data-icon','mdi:arrow-left-bold-circle-outline');
      backSpan.setAttribute('data-inline','false');
      backSpan.setAttribute('data-width','20px');
      backSpan.setAttribute('data-height','20px');
      backSpan.setAttribute('style','color:#eb6608');
      backSpan.setAttribute('style','margin-right:5px');
      let backA = document.createElement('a');

      if(window.localStorage.getItem('couserNAME')){

        a.setAttribute('href','#');
        a.appendChild(document.createTextNode(window.localStorage['couserNAME']));

        backA.setAttribute('href','menu.html');
        backA.appendChild(backSpan);

      }else{
        a.appendChild(document.createTextNode(window.localStorage['name']));
        // a.appendChild(document.createTextNode('Firma hat keine Name'));
      }
        header.append(a);
        header.append(backA);


      //
      // if(Object.keys(data).length > 0) {
      //
      // 		Object.keys(data).forEach(key => {
      // 		if(Object.keys(data[key].length > 0)){
      // 			Object.keys(data[key]).forEach(index => {
      // 				// console.log('index=>',index);
      // 				// console.log('data[key][index]=>',data[key][index]);
      // 				let content = $('.content');
      // 				let colSm6 = document.createElement('div');
      // 				colSm6.setAttribute('class','col-sm-6');
      // 				let cardFlexFill = document.createElement('div');
      // 				cardFlexFill.setAttribute('class','card');
      // 				let cardBody = document.createElement('div');
      // 				cardBody.setAttribute('class','card-body card_body_box');
      // 				cardBody.setAttribute('id',index);
      // 				let row = document.createElement('div');
      // 				row.setAttribute('class','row');
      //
      // 				let colAuto1 = document.createElement('div');
      // 				colAuto1.setAttribute('class','col-auto');
      // 				let thumb = document.createElement('div');
      // 				thumb.setAttribute('class','thumb-45px rounded-circle alert-info border-light');
      // 				thumb.setAttribute('style','background-image:url(http://placehold.it/100x100)');
      // 				colAuto1.append(thumb);
      //
      // 				let col = document.createElement('div');
      // 				col.setAttribute('class','col');
      // 				// col.setAttribute('id','subClients');
      // 				let h4 = document.createElement('h4');
      // 				let span = document.createElement('span');
      // 				let small = document.createElement('small');
      // 				let hr = document.createElement('hr');
      //
      //
      // 				let colAuto2 = document.createElement('div');
      // 				colAuto2.setAttribute('class','col-auto');
      // 				let dropme = document.createElement('div');
      // 				dropme.setAttribute('class','dropme');
      // 				dropme.setAttribute('tabindex','1');
      // 				let a = document.createElement('a');
      // 				a.setAttribute('href','#');
      // 				let span2 = document.createElement('span');
      // 				span2.setAttribute('class','iconify rounded-circle');
      // 				span2.setAttribute('data-icon','mdi-menu');
      // 				span2.setAttribute('data-inline','false');
      // 				a.append(span2);
      // 				dropme.appendChild(a);
      // 				colAuto2.append(dropme);
      //
      //
      // 				span.setAttribute('class','clock');
      // 				span.setAttribute('data-tz','Europe/Berlin');
      // 				// span.append(datetime);
      // 				h4.appendChild(document.createTextNode(data[key][index]));
      // 				col.append(h4);
      // 				col.append(span);
      // 				col.append(small);
      // 				col.append(hr);
      //
      // 				row.append(colAuto1);
      // 				row.append(col);
      // 				row.append(colAuto2);
      //
      // 				cardBody.append(row);
      // 				cardFlexFill.append(cardBody);
      // 				colSm6.append(cardFlexFill);
      // 				content.append(colSm6);
      //
      // 			});//Object.keys(data[key])
      // 		}
      //
      // 		});//	Object.keys(data)
      // 		// <span class="clock" data-tz="Europe/Berlin">Mo 19:10</span>
      // 		// <div class="thumb-45px rounded-circle alert-info border-light" style="background-image:url(https://media.yoummday.com/qa/971/ppl9LJsbxk25wc.jpg)">	</div>
      // 		$('.card_body_box').click(function(){
      // 			console.log(this);
      // 			let auth = window.localStorage['auth'];
      // 			let couserID = this.id;
      // 			console.log(couserID);
      // 			$.ajax({
      // 				type:'POST',
      // 				contentType:'application/x-www-form-urlencoded; charset=UTF-8',
      // 				dataType:'json',
      // 				data:{
      // 					auth: auth,
      // 					couser: couserID
      // 				},
      // 				url:'https://apiqa.yoummday.com/vacd/numberlist',
      // 				success: function(data){
      // 					delete data["authTime"];
      // 					delete data["success"];
      // 					console.log('data=>',data);
      // 					window.localStorage.setItem('couserID',couserID);
      // 					window.location.href = '/VACD/reteflow.html';
      // 					// window.localStorage.removeItem('couserID');
      // 				}//success:function
      // 			});//$.ajax
      // 		});//	$('#nav a').click(function()
      //
      //
      // }//Object.keys(data)
      // $('.dropme>a').on('click',function(){
      // 	console.log('test');
      // });
      let aMenu1 = $('#callflow');
      let aMenu2 = $('#sound');
      let couserLenght = window.localStorage['couserLenght'];
      let fullaccess = window.localStorage['fullaccess'];

      if(couserLenght > 1 || fullaccess === true){
        aMenu1.removeClass('hidden');
        aMenu2.removeClass('hidden')
      }


    },//success
    error: function(error){
      console.log(error);
    }
  });//$.ajax

  $('input[value="Sounddatei"]').click(function(){
    $.ajax({
      type: 'GET',
      contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
      dataType: "json",
      data:
      {
        auth: window.localStorage.getItem("auth"),
        couser: window.localStorage.getItem("couserID")
      },
      url: 'https://apiqa.yoummday.com/vacd/soundlist',
      success: function(result){

        console.log('soundlist=>',result);
        delete result["authTime"];
        delete result["success"];

        let ausgabe = $('#ausgabe');
        let ausgabeUL = $('#ausgabe ul');
        ausgabeUL.empty();
        if(Object.keys(result).length > 0) {

          Object.keys(result).forEach(key => {
            if(Object.keys(result[key])){
              Object.keys(result[key]).forEach(index =>{
                if(result[key][index]['filename']){
                  let fieleID = result[key][index]["id"];
                  let fileName = result[key][index]["filename"];
                  let fileTS = result[key][index]["uploadTS"];
                  // console.log(fileName);
                  let select = $('#soundlist');
                  // console.log(select);
                  select.append('<option value="' + fieleID + '">' + fileName + '</option>');

                  // ausgabeUL.append('<li><input type="checkbox" name="' + fieleID + '" value="' + fileName + '"><label for="'+ fieleID + '"> '+ fileName + '</label><i><small>' + fileTS +'</small></i></li>');

                }else{
                  // $("#soundLIST").append('<option value='+ result[key][index]["id"] + '>' + 'keine Name' + '</option>');
                }

              });//Object.keys(result[key]).forEach
            }//if
          });//Object.keys(result)
        }


      },
      error: function(error){
        console.log(error);
      }
    });//$.ajax
  });

  $('input[value="Redirect"]').click(function(){
      $.ajax({
        type:'GET',
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        data: {
                auth:localStorage.auth,
                couser:localStorage.couserID
              },
        url: 'https://apiqa.yoummday.com/vacd/numberlist',
        success: function(result){
          console.log('numberlist=>',result);
          delete result["authTime"];
          delete result["success"];
          window.localStorage.removeItem('telNr');
          Object.keys(result).forEach(key =>{
            if(result[key]){
              Object.keys(result[key]).forEach(index =>{
                // console.log('result=>',result);
                // console.log('key=>',key);
                // console.log('result[key]=>',result[key]);
                // console.log('result[key][index]=>',result[key][index]); //letzte Update Zeit
                // console.log('index=>',index);
                let select = $('#numlist');
                console.log(select);
                select.append('<option value="' + index + '">' + index + '</option>');
              });//Object.keys(result[key]).forEach
            }//if




          });//Object.keys(result).forEach



        },//success
            error: function(error){
              console.log('error=>',error);
            }
        });//$.ajax

    });
  //beim Abmelden, localStorage leeren
  $('#logout a').click(function(){
    localStorage.clear();
  });

  //#number Container anzeigen
  $('#telNumber').click(function(){
    $('#number').removeClass('hidden');
    $('#divSOUNDUPLOAD').addClass('hidden');
    $('#rightSite').addClass('hidden');
    $('#editorBtn').addClass('hidden');

    //Telnummer auflisten
    $.ajax({
      type:'GET',
      contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
      dataType: 'json',
      data: {
              auth:localStorage.auth,
              couser:localStorage.couserID
            },
      url: 'https://apiqa.yoummday.com/vacd/numberoverview',
      success: function(result){
        // console.log('result=>',result);
        // console.log('result["numberlist"]=>',result['numberlist']);
        console.log('result["temproutinglist"]=>',result['temproutinglist']);
        delete result["authTime"];
        delete result["success"];
        window.localStorage.removeItem('telNr');



        //Tabelle Aufbau und Telefonnummer auflisten
        let tabele = $('#resultat table');
        Object.keys(result).forEach(key =>{
          // console.log('result[key]=>',result[key]);
          // console.log('key=>',key);
          if(key === 'numberlist'){

            //numberlist
            Object.keys(result[key]).forEach(index =>{
              // console.log('result=>',result);
              // console.log('key=>',key);
              // console.log('result[key]=>',result[key]);
              // console.log('result[key][index]=>',result[key][index]['graph']['name']);
              // console.log('index=>',index);

                let select = document.createElement('select');
                select.setAttribute('id',index);
                let option = document.createElement('option');
                option.setAttribute('value',index);
                option.append(result[key][index]['graph']['name']);
                select.append(option);
                let tr = document.createElement('tr');
                let tdTel = document.createElement('td');
                tdTel.setAttribute('width','100%');
                tdTel.setAttribute('style','font-weight:bold');
                let tdClf = document.createElement('td');
                tdClf.setAttribute('width','100%');


                tdClf.append(select);
                tdTel.append(index);
                tr.append(tdTel);
                tr.append(tdClf);
                tabele.append(tr);

                // $("#selectTELNUMMER").append('<option value="' + index + '">' + index + '</option>');

              let telnr = index;
              let graphname = result[key][index]['graph']['name'];
              let graphid = result[key][index]['graph']['id'];

              let ul = $('#zettel');
              let li = document.createElement('li');
              let spanNr = document.createElement('span');
              let spanName = document.createElement('span');
              let spanIcon = document.createElement('span');
              let input = document.createElement('input');
              let label = document.createElement('label');


              label.setAttribute('class','delet');
              label.setAttribute('for','delet');

              input.setAttribute('class','del-item');
              // input.setAttribute('id','delet');
              input.setAttribute('type','submit');
              input.setAttribute('style','display:none');

              spanNr.append(telnr);
              spanName.append(graphname);
              spanIcon.append(label);
              spanIcon.append(input);

              li.setAttribute('class','mb-3');
              li.setAttribute('id',graphid);

              li.append(spanNr);
              li.append(spanName);
              li.append(spanIcon);

              ul.append(li);





            });//Object.keys(result[key]).forEach

          }//if

          if(key === 'temproutinglist' && Object.keys(result[key]).length > 0){
            // temproutinglist
            Object.keys(result[key]).forEach(i =>{

              let tempGrPhone1 = result[key][i]['phone'];
              let tempGrStartTS1 = result[key][i]['startTS'];
              let tempGrID1 = result[key][i]['id'];


              $("#selectTELNUMMER").append('<option value="' + tempGrID1 + '">' + tempGrPhone1 + '</option>');


              if(Object.keys(result[key][i]['graph']).length > 0){

                Object.keys(result[key][i]['graph']).forEach(z=>{

                  var tempGrId2 = result[key][i]['graph'][z]['id'];
                  let tempGrName2 = result[key][i]['graph'][z]['name'];
                  let tempGrJson2 = result[key][i]['graph'][z]['json'];
                  let tempGrLastmodifiedTS2 = result[key][i]['graph'][z]['lastmodifiedTS'];

                  $("#grafikLIST2").append('<option value="' + tempGrId2 + '">' + tempGrName2 + '</option>');
                  console.log(result[key][i]['graph'][z]['id']);
                });

                $("#grafikLIST2").change(function(){

                  $('#grafikLIST2 option:selected').each(function(){


                    window.localStorage.removeItem('graphJSON');
                    window.localStorage.removeItem('graphNAME');
                    window.localStorage.removeItem('graphID');
                    window.localStorage.removeItem('graphObjTS');

                    console.log('this.value=>',this.value);
                    // console.log('i=>',i);
                    // console.log('result[key]=>',result[key]);
                    console.log(result[key][i]['graph']);
                    if($(this).val() === result[key][i]['graph'][0]){

                          let graphObjID = result[key][i]['graph'][z]['id'];
                          let graphObjNAME = result[key][i]['graph'][z]['name']
                          let graphObjJSON = result[key][i]['graph'][z]['json']
                          let graphObjTS = result[key][i]['graph'][z]['lastmodifiedTS']

                          console.log(graphObjNAME);
                          window.localStorage.setItem('graphID',graphObjID);
                          window.localStorage.setItem('graphNAME',graphObjNAME);
                          window.localStorage.setItem('graphObjTS',graphObjTS);


                    }//if(result[key])
                  });//$('#grafikLIST2 option:selected')
                });//$("#grafikLIST2")

              }
              });
          }

          //Auftrag: Telefonnummer Auswahl
          $("#selectTELNUMMER").change(function(){
            $('#selectTELNUMMER option:selected').each(function(){
              let tr = $('#result');
              let td2 = document.createElement('td');
              td2.setAttribute('id','num');

              // tr.empty();

              if(result[key]){

                Object.keys(result[key]).forEach(i => {

                  if(i === this.value){
                    console.log(this.text);

                    let graphName = result[key][i].graph.name;
                    let graphId = result[key][i].graph.id;
                    let graphLastModifiedTS = result[key][i].graph.lastmodifiedTS;
                    let lastUpdate = result[key][i].lastupdate;
                    let graphJson = result[key][i].graph.json;

                    window.localStorage.setItem('telNr',this.text);
                    let div = $('#liste');
                    let p = document.createElement('p');
                    p.append(this.text +' ');

                    div.append(p);
                    // $('#liste ul').empty();
                    // $('#liste ul').append('<li>Graphname:<small><i> ' + graphName + '</i></small></li><li> ' + 'GrapID:<small><i> ' + graphId + '</i></small></li><li> ' + 'Letzte Änderung:<small><i> ' + graphLastModifiedTS + '</i></small></li><li> ' + 'Letzte Update:<small><i> ' + lastUpdate + '</i></small></li>');
                    $('#result').find('td[id="num"]').remove();
                    td2.append(i);
                    tr.append(td2);

                  }



                });//Object.keys(result[key])
              }//if

            });//$('#selectTELNUMMER option:selected')

          });//$("#selectTELNUMMER")




        });//Object.keys(result).forEach



      },//success
          error: function(error){
            console.log('error=>',error);
          }
      });//$.ajax



  });//$('#telNumber').click


  //Element löschen
  $('#zettel').click(function(e){
    // console.log($(this).closest('li')[0].id);
    // e.preventDefault();

    $('.modal').removeClass('d-none');


    $('button[data-dismiss="modal"]').click(function(){
        $('.modal').addClass('d-none');
    });

    $('#ja').click(function(e){
      // console.log(e);
      var graphid = $('.del-item').closest('li')[0].id;
      console.log(graphid);

      $.ajax({
        type: 'POST',
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: "json",
        data: {
          auth:window.localStorage['auth'],
          couser:window.localStorage['couserID'],
          routingid:graphid
        },
          url: 'https://apiqa.yoummday.com/vacd/deletetemprouting',

        success: function(data)
        {
          console.log('data=>',data);
          $('.del-item').closest('li').remove();
          $('.modal').addClass('d-none');
          // console.log($(this).closest('li'));
          location.reload();
        },
        error: function(error){
          console.log(error);
        }
      });//$.ajax

    });




  });

  //Anrufverlaufliste mit Telnummer versehen
  $('#hinzu').on('click',function(e){
    let graphid = window.localStorage['graphID'];
    let num = window.localStorage['telNr'];

        $.ajax({
          type:'POST',
          contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
          dataType: 'json',
          data: {
                  auth:window.localStorage.getItem("auth"),
                  graphid: graphid,
                  number: num,
                  startTS:'2020-12-10 10:59:59'
                },
          url: 'https://apiqa.yoummday.com/vacd/temprouting',
          success: function(result){
          console.log('result=>',result);

            if(result.success == 1){
              alert('Danke Erfolgreich gespeichert!');
              console.log('geklappt!');
              location.reload();
                let div = $('#liste');
                let p = document.createElement('p');
                p.append(window.localStorage['telNr'] + window.localStorage['graphNAME']) + window.localStorage['graphObjTS'];

                // div.append(p);



            }else{
              console.log(result);
            }

            },
            error: function(error){
              console.log('error=>',error);
            }
        });//$.ajax
  });//$('#hinzufuegen').click
  //.editorbox Container anzeigen
  $('#callflow').click(function(){
    $('#rightSite').removeClass('hidden');
    $('#editorBtn').removeClass('hidden');
    $('#rete').removeClass('hidden');
    $('#number').addClass('hidden');
    $('#divSOUNDUPLOAD').addClass('hidden');





  });//$('#callflow').click


  $("#save").click(function() {
    let graphdata = window.localStorage['savedEditor'];
    console.log('graphdata=>',graphdata);
    let graphname = $("#neueGRAFIKNAME")[0].value;
    console.log('graphname=>',graphname);
    // console.log(this);
    if(graphname != ""){
      $.ajax({
          type: 'POST',
          contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
          dataType: "json",
          data: {
            auth: window.localStorage.getItem("auth"),
            couser: window.localStorage.getItem("couserID"),
            name: graphname,
            json: graphdata
          },
          url: 'https://apiqa.yoummday.com/vacd/submitgraph',
          success: function(responsedata){
            console.log('responsedata=>',responsedata);
            // to do: refresh grafikLIST on the nav leftside
            // location.reload();
            //inputfeld leeren
            $('#neueGRAFIKNAME')[0].value = '';
            // console.log($('#neueGRAFIKNAME')[0].value);
            // $("#submitmessage").fadeIn().fadeOut(2000);


          },
          error: function(error){
            console.log(error);
          }
        });
      } else{
        $("#smallmsg")
        .css("color", "red")
        .text('Name is empty');
      }
    });

  $('#graphLOESCHEN').click(function(){
    // // console.log(this);
    console.log('graphObj1=>',graphObj1);
    let graphID = graphObj1;
    console.log(graphID);
    $.ajax({
      type: 'POST',
      contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
      dataType: "json",
      data: {
        auth:window.localStorage['auth'],
        couser: window.localStorage['couserID'],
        graphid:graphID
      },
        url: 'https://apiqa.yoummday.com/vacd/deletegraph',

      success: function(data)
      {
        console.log(data);
        console.log(data.error);
        location.reload();
        // if(data.error != "nograph" && data.error != "auth"){
        // 	console.log('Erfolgreich gelöscht!');
        // 	location.reload();
        // }else{
        // 	alert('FEHLER');
        // 	console.log(data);
        // }


      },
      error: function(error){
        console.log(error);
      }
    });//$.ajax


  });
  //#divSOUNDUPLOAD Container anzeigen

  $('#sound').click(function(){
    $('#divSOUNDUPLOAD').removeClass('hidden');
    $('#number').addClass('hidden');

    //Hochgeladene Sounds anzeigen
    $.ajax({
      type: 'GET',
      contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
      dataType: "json",
      data:
      {
        auth: window.localStorage.getItem("auth"),
        couser: window.localStorage.getItem("couserID")
      },
      url: 'https://apiqa.yoummday.com/vacd/soundlist',
      success: function(result){

        console.log('result=>',result);
        delete result["authTime"];
        delete result["success"];

        let ausgabe = $('#ausgabe');
        let ausgabeUL = $('#ausgabe ul');
        ausgabeUL.empty();
        if(Object.keys(result).length > 0) {

          Object.keys(result).forEach(key => {
            if(Object.keys(result[key])){
              Object.keys(result[key]).forEach(index =>{
                if(result[key][index]['filename']){
                  let fieleID = result[key][index]["id"];
                  let fileName = result[key][index]["filename"];
                  let fileTS = result[key][index]["uploadTS"];

                  ausgabeUL.append('<li><input type="checkbox" name="' + fieleID + '" value="' + fileName + '"><label for="'+ fieleID + '"> '+ fileName + '</label><i><small>' + fileTS +'</small></i></li>');

                }else{
                  $("#soundLIST").append('<option value='+ result[key][index]["id"] + '>' + 'keine Name' + '</option>');
                }

              });//Object.keys(result[key]).forEach
            }//if
          });//Object.keys(result)
        }
        // ausgabe.append(deleteBtn);

      },
      error: function(error){
        console.log(error);
      }
    });//$.ajax

    //Sound hochladen
      $('form').on('submit',function (e) {
        e.preventDefault();
        console.log(e);
      });//$('form').on



  });//$('#sound').click(function()

  //sound hochladen
  $('#btnUPLOAD').click(function(){
    var formData = new FormData();
    let auth = localStorage.auth;
    let couser = localStorage.couserID;
    let fileName = $('#inputFILE')[0].files[0].name;

    // console.log('auth=>',auth);
    // console.log('couser=>',couser);
    // console.log('fileName=>',fileName);
    // console.log('file=>',$('#inputFILE')[0].files[0]);
    //
    formData.append("file", $('#inputFILE')[0].files[0]);
    console.log($('#inputFILE')[0].files[0]);
    formData.append('auth',auth);
    formData.append('name',fileName);
      formData.append('couser',couser);
      $.ajax({
        type: 'POST',
        url: 'https://apiqa.yoummday.com/vacd/uploadsound',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data)
        {
          if(data['error'] !== 'wrongfile'){
            alert('Prima, hochgeladen!');
            console.log('hochgeladen!');
            location.reload();
          }else{
            alert('Datei Type ist falsch! Bitte nur die wav Dateitype hochladen!');
            console.log(data['error']);
          }

          // location.reload();
          // $('#inputFILE')[0].files[0].clear;
          // console.log($('#inputFILE')[0].files[0]);
        },
        error: function(error){
          console.log(error);
        }
      });//$.ajax

  });//$('#btnUPLOAD').click


  //sound löschen
  $('#deleteBtn').click(function(){
    let checkbox = $('input[type="checkbox"]:checked');
    let soundID = checkbox[0].name;
    // console.log(checkbox[0].name);
    $.ajax({
      type: 'POST',
      contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
      dataType: "json",
      data: {
        auth:window.localStorage['auth'],
        soundid:soundID
      },
        url: 'https://apiqa.yoummday.com/vacd/deletesound',

      success: function(data)
      {
        console.log('data=>',data);
        console.log('Erfolgreich gelöscht!');
        // $("#soundLIST").reload;
        location.reload();
      },
      error: function(error){
        console.log(error);
      }
    });//$.ajax
  });//$('#deleteBtn').click







// });//$(document).ready