// JavaScript Document
if(('$Nomer_komnati'.length==0)&&('$Nomer_korpusaEdit'.length==0))
 {
	 jq('#del').hide();
	
}
if(document.getElementById('add').value == 'Внести изменения'){
//	
//	//ivalue ='$korpus'
//	//document.getElementById('Nomer_korpusa').value = '$korpus';
// // $('div').text('234');
// 
 var kor = document.getElementById('Nomer_korpusa');	
	for ( var i=0; i<kor.options.length; i++ ){
         if (kor.options[i].value == '$korpus') {
			 kor.selectedIndex=i;
			  kor.selectedIndex=i; 
			  kor.onchange();
			  break;
		  }
	 }
   var vid = document.getElementById('Vid_prava');
   for ( var i=0; i<5; i++ ) { 
     if (vid.options[i].value == '$Vid_prava') {vid.selectedIndex=i;break;}}
   var kor = document.getElementById('Nomer_korpusa');
   for ( var i=0; i<kor.options.length; i++ ){
         if (kor.options[i].value == '$Nomer_korpusaEdit') {kor.selectedIndex=i;kor.onchange();kor.disabled=true;break;}}
	var etag = document.getElementById('Etag2');
   for ( var i=0; i<etag.options.length; i++ ){
         if (etag.options[i].value == '$Etag') {etag.selectedIndex=i;etag.disabled=true;break;}}	
	var cat = document.getElementById('Categoriya_pomesh');
	for ( var i=0; i<cat.options.length; i++ ){
         if (cat.options[i].value == '$Categoriya_pomesh') {cat.selectedIndex=i;break;}}
	document.getElementById('Naznachenie_pomesh').value ='$Naznachenie_pomesh' ;	 
  	document.getElementById('Sootvetstvie').value ='$Sootvetstvie' ;
	var vid = document.getElementById('Vid_ispolzovanie');	 
	 for ( var i=0; i<vid.options.length; i++ ){
         if (vid.options[i].value == '$Vid_ispolzovanie') {vid.selectedIndex=i;break;}}
	var ob = document.getElementById('Obremenenie');	
	for ( var i=0; i<ob.options.length; i++ ){
        if (ob.options[i].value == '$Obremenenie') {ob.selectedIndex=i;break;}}
	var reg = document.getElementById('Rejim_ispol');	
	for ( var i=0; i<reg.options.length; i++ ){;
         if (reg.options[i].value == '$Rejim_ispol') {reg.selectedIndex=i;break;}}
	 document.getElementById('Data_nachala').value='$Data_nachala';
	 document.getElementById('Data_nachala').disabled = true;
	  document.getElementById('Data_okonchaniya').value='$Data_okonchaniya';
	  document.getElementById('Kol-vo_mest_komment').value='$Kolvo_mest_komment';
	  var st = document.getElementById('Structurnoe_podrazdlenie');	
	 for ( var i=0; i<st.options.length; i++ ){
		         if (st.options[i].value == '$Structurnoe_podrazdlenie') {
					 st.selectedIndex=i; st.onchange();st.disabled=true;break;}}
   var o = document.getElementById('Otvetstvennoe_lico');
   for ( var i=0; i<o.options.length; i++ ){
         if (o.options[i].value == '$Otvetstvennoe_lico') {o.selectedIndex=i;break;}}
		 var o = document.getElementById('Okna');
   for ( var i=0; i<o.options.length; i++ ){
         if (o.options[i].value == '$Okna') {o.selectedIndex=i;break;}}
		 var d = document.getElementById('Dveri');
   for ( var i=0; i<d.options.length; i++ ){
         if (d.options[i].value == '$Dveri') {d.selectedIndex=i;break;}}
		 var s = document.getElementById('Steni');
   for ( var i=0; i<s.options.length; i++ ){
         if (s.options[i].value == '$Steni') {s.selectedIndex=i;break;}}
		 var p = document.getElementById('Potolok');
   for ( var i=0; i<p.options.length; i++ ){
         if (p.options[i].value == '$Potolok') {p.selectedIndex=i;break;}}
		 var p = document.getElementById('Pol');
   for ( var i=0; i<p.options.length; i++ ){
         if (p.options[i].value == '$Pol') {p.selectedIndex=i;break;}} 
	   var per = document.getElementById('Nalichie_pereplanirovok');
 	   if('$Nalichie_pereplanirovok'=='1')per.selectedIndex=0;
	   if('$Nalichie_pereplanirovok'=='0') per.selectedIndex=1;
	   document.getElementById('Nalichie_pereplanirovok_komment').value = '$Nalichie_pereplanirovok_komment';
	   document.getElementById('Nomer_komnati').value = '$Nomer_komnatiEdit';
	   document.getElementById('Sootvetstvie').value = '$Sootvetstvie';
	   document.getElementById('Naimenovanie_zdaniya').value = '$Naimenovanie_zdaniya';

	   document.getElementById('Nomer_tehpasporta').value = '$Nomer_tehpasporta';
	   document.getElementById('Obshaya_ploshad').value = '$Obshaya_ploshad';
	   document.getElementById('Kol-vo_mest').value = '$Kolvo_mest';
	   document.getElementById('Kol-vo_mest_komment').value = '$Kolvo_mest_komment';
	   document.getElementById('San_pasport').value = '$San_pasport';
	   document.getElementById('Data').value = '$Data';
	   var s1= document.getElementById('Сигнализация_0');
 	   if('$Сигнализация'=='1') {s1.checked=true;s1.onclick();}
	   var s2= document.getElementById('Сигнализация_1');
	   if('$Сигнализация2'=='1') {s2.checked=true;s2.onclick();}
	    document.getElementById('Zamechaniya').value = '$Zamechaniya';
		document.getElementById('Predlojeniya').value = '$Predlojeniya';
	  var u = document.getElementById('ViborUchastnik_kom');
      for ( var j2=1; j2<=n.length; j2++ ){
		 for ( var i=0; i<=u.options.length; i++ ){
			if (u.options[i].value == n[j2]) 
			{
				 u.selectedIndex=i;
				 form1.Dobavit.onclick();
			 }
	  } 
	}
}