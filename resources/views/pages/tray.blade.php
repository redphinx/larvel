@extends('app') @section('head')

<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="http://d3js.org/d3.v3.min.js" language="JavaScript"></script>
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<script	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><!-- not used... yet -->
@section('c1')
<title>Tray Diagram</title>
@section('c2')

<table alignment = "center">
<tr><td>
<text name="hello"></text>
	<h1><center>My Tray Design</center></h1>
</td></tr><tr><td name="mysvg" id="mysvg">
<!-- this portion is the building of the diagram -->
<script language="Javascript">
//---||grab all variables from form||---// 
var mov ={!! $mov = Request::get ( 'mov' ); !!}// how did i get this to work...
var vfr ={!! $vfr = Request::get ( 'vfr' ); !!}// translates php to script can see this in html
var mol ={!! $mov = Request::get ( 'mol' ); !!}
var lfr ={!! $lfr = Request::get ( 'lfr' ); !!}
var p ={!! $p = Request::get ( 'p' ); !!}
var r ={!! $r = Request::get ( 'r' ); !!}
var sigma ={!! $r = Request::get ( 'sigma' ); !!}
var f ={!! $f = Request::get ( 'f' ); !!}
var rou ={!! $rou = Request::get ( 'rou' ); !!}
var t ={!! $t = Request::get ( 't' ); !!}

//---||calulations||---//
var rouv = p*mov/(r*t);
var flv = lfr*mol/(vfr*mov)*Math.pow(rouv/rou,0.5);
var ada=0.1;
if(flv>0.1){
	ada=0.1+(flv-0.1)/9;
}
if(flv>1){
	ada=0.2;
}
var F = 1/(1+1.4*Math.pow(((rou-rouv)/rouv),0.5));
var C2 =0.356*(1-F)*Math.pow((sigma/(rou-rouv)),0.25);
var Cult = C2*Math.pow(((rou-rouv)/rouv),0.5);
var ls = Cult*rouv*lfr*mol/(rou*vfr*mov);
var C1 = 0.455*(1-F)*Math.pow((sigma/(rou-rouv)),0.25)-1.4*ls;
if(C1<C2){
	Cult = C1*Math.pow((rou-rouv),0.5);
}
//---calulation for DT---//
var DT = Math.pow((4*vfr/3600*mov/(f*Cult*Math.PI*(1-ada)*rouv)),0.5)*3.28;


var holeDiameter =3/16;//constant (generally) can change to form later if required
var weirHeight = 3;//inches and also is generally given

//---calculation for hl---//
var lw = DT*0.73*12*3.28;
var ql = lfr/60*mol/(0.003785*rou);
var cl = 0.362+0.317*Math.pow(Math.E,-3.5*weirHeight);
var holeVelocity =vfr/3600*mov/(rouv*Math.PI/4);
var ua = holeVelocity/(1-2*ada)*3.28;
var ks = ua*Math.pow((rouv/(rou-rouv)),0.5);
var phie = Math.pow(Math.E,-4.257*Math.pow(ks,0.91));
var hli = phie*(weirHeight+cl*Math.pow(ql/(lw*phie),2/3));

//---calulation for hd---//
var u0=holeVelocity/ada*3.28;
var hd= 0.186*(Math.pow(u0,2)/Math.pow(0.73,2))*(rouv/rou);
 //---calulations for hsigma---//
var dbmax = holeDiameter/12/3.28;
var hsigma = 6*sigma/1000/(9.8*rou*dbmax)*3.28*12;
//---calulations for ht---//
var ht = hd+hli+hsigma;
ht = Math.round(ht*1000)/1000;
DT = Math.round(DT*1000)/1000;
hli = Math.round(hli*1000)/1000;
//---||tray segment||---//
var height = 5;
var frothHeight =10;
var wierHieght = 10;
var line = 50;
var shiftx=150;//shift everything to the right(was done for spacing purposes) minimum look at head loss text field(first to be cut off)
var svgContainer = d3.select("td").append("svg").attr("width",1050).attr("height",500).attr("allign","center");

//---||hl segment||---//
hl = 100-hli*10;//my change for the difference *note* max is 100/the current scale
//base 
var rectangle = svgContainer.append("rect").attr("x",395+shiftx).attr("y",200).attr("width",10).attr("height",100).attr("fill","blue");
//hl portion
var rectangle = svgContainer.append("rect").attr("x",395+shiftx).attr("y",200).attr("width",10).attr("height",100).attr("fill","blue");
rectangle.transition().attr("y",100+hl).attr("height",100-hl).duration(2000);
var rectangle = svgContainer.append("rect").attr("x",260+shiftx).attr("y",290).attr("width",140).attr("height",10).attr("fill","blue");
var rectangle = svgContainer.append("rect").attr("x",260+shiftx).attr("y",200).attr("width",10).attr("height",90).attr("fill","blue");

//each line pair(of 2) is a bend
var line1 = svgContainer.append("line").attr("x1", 370+shiftx).attr("y1", 110).attr("x2", 405+shiftx).attr("y2", 110).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 370+shiftx).attr("y1", 118).attr("x2", 395+shiftx).attr("y2", 118).attr("stroke","black").attr("stroke-width",3);

var line1 = svgContainer.append("line").attr("x1", 405+shiftx).attr("y1", 108.5).attr("x2", 405+shiftx).attr("y2", 300).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 395+shiftx).attr("y1", 116.5).attr("x2", 395+shiftx).attr("y2", 290).attr("stroke","black").attr("stroke-width",3);

var line1 = svgContainer.append("line").attr("x1", 270+shiftx).attr("y1", 290).attr("x2", 396.5+shiftx).attr("y2", 290).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 260+shiftx).attr("y1", 300).attr("x2", 406.5+shiftx).attr("y2", 300).attr("stroke","black").attr("stroke-width",3);

var line1 = svgContainer.append("line").attr("x1", 260+shiftx).attr("y1", 200).attr("x2", 260+shiftx).attr("y2", 301.5).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 270+shiftx).attr("y1", 200).attr("x2", 270+shiftx).attr("y2", 291.5).attr("stroke","black").attr("stroke-width",3);


//---||Back to Main tray segment||---//
//---all rectangles in tray---//
//inlet
var rectangle = svgContainer.append("rect").attr("x",55+shiftx).attr("y",50+height).attr("width",55).attr("height",100-height).attr("fill","blue");
//lower froth
var rectangle = svgContainer.append("rect").attr("x",57+shiftx).attr("y",149).attr("width",300).attr("height",50).attr("fill","blue");
var rectangle = svgContainer.append("rect").attr("x",57+shiftx).attr("y",149).attr("width",300).attr("height",50).attr("fill","blue");
//upper froth
var rectangle = svgContainer.append("rect").attr("x",60+shiftx).attr("y",149).attr("width",300).attr("height",50).attr("fill","blue");
rectangle.transition().attr("height",100-frothHeight).attr("y",90+frothHeight).duration(2000);
//froth to lower tray
var rectangle = svgContainer.append("rect").attr("x",360+shiftx).attr("y",90+frothHeight).attr("width",20).attr("height",260-frothHeight).attr("fill","blue");
//lower tray
var rectangle = svgContainer.append("rect").attr("x",290+shiftx).attr("y",340).attr("width",90).attr("height",20).attr("fill","blue");
//rectangle.transition().attr("width",150).attr("x",230+shiftx).duration(2000);
//---drawings---//
var i;

for (i = 0; i < 5; i++) {
	var image1 = svgContainer.append("image").attr("x",258+i*50).attr("y",155).attr("width",50).attr("height",50).attr("xlink:href","http://www.clipartbest.com/cliparts/KTj/gxz/KTjgxz7ac.gif");
	var image2 = svgContainer.append("image").attr("x",258+i*50).attr("y",155).attr("width",50).attr("height",50).attr("xlink:href","http://www.clipartbest.com/cliparts/KTj/gxz/KTjgxz7ac.gif");
	image2.transition().attr("y",120).delay(100).duration(2500).ease("linear");
	var image3 = svgContainer.append("image").attr("x",258+i*50).attr("y",155).attr("width",50).attr("height",50).attr("xlink:href","http://www.clipartbest.com/cliparts/KTj/gxz/KTjgxz7ac.gif");
	image3.transition().attr("y",120).delay(1500).duration(1500).ease("linear");
	image3.transition().attr("y",85).delay(100).duration(3000).ease("linear");
}

//---all lines in tray---//
//entrence in tray
var line1 = svgContainer.append("line").attr("x1", 55+shiftx).attr("y1", line).attr("x2", 55+shiftx).attr("y2", 200).attr("stroke","black").attr("stroke-width",5);
var line1 = svgContainer.append("line").attr("x1", 110+shiftx).attr("y1", line).attr("x2", 110+shiftx).attr("y2", 150).attr("stroke","black").attr("stroke-width",5);
//base of tray line
var line1 = svgContainer.append("line").attr("x1", 52.5+shiftx).attr("y1", 200).attr("x2", 360+shiftx).attr("y2", 200).attr("stroke","black").attr("stroke-width",5);
//wier hight based lines
var line1 = svgContainer.append("line").attr("x1", 360+shiftx).attr("y1", 145-wierHieght).attr("x2", 360+shiftx).attr("y2", 345).attr("stroke","black").attr("stroke-width",5);
var line1 = svgContainer.append("line").attr("x1", 380+shiftx).attr("y1", 50).attr("x2", 380+shiftx).attr("y2", 360).attr("stroke","black").attr("stroke-width",5);
//tray bottom lines
var line1 = svgContainer.append("line").attr("x1", 290+shiftx).attr("y1", 362).attr("x2", 382.5+shiftx).attr("y2", 362).attr("stroke","black").attr("stroke-width",5);
var line1 = svgContainer.append("line").attr("x1", 361+shiftx).attr("y1", 342.5).attr("x2", 360+shiftx).attr("y2", 342.5).attr("stroke","black").attr("stroke-width",5);

//this is an example to add images to svg (the most simplistic way and easiest to use) please note wont scale :(!!!
//var image = svgContainer.append("image").attr("x",57).attr("y",149).attr("width",300).attr("height",50).attr("xlink:href","https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTO3xDAex8-iwgD7p1STNMQnj2zUig8rGP0i73Uq6f_S7oo9WkxGg");

//quickly repaint the two lines in hl segment 
var line1 = svgContainer.append("line").attr("x1", 370+shiftx).attr("y1", 110).attr("x2", 405+shiftx).attr("y2", 110).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 370+shiftx).attr("y1", 118).attr("x2", 395+shiftx).attr("y2", 118).attr("stroke","black").attr("stroke-width",3);

//---||ht segment||---//
var htUnscaled =ht;
ht = ht*10;
ht0= 100-ht;//height of ht segment
//connects to in tray
var line1 = svgContainer.append("line").attr("x1", 5+shiftx).attr("y1", 100).attr("x2", 65+shiftx).attr("y2", 100).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 10+shiftx).attr("y1", 108).attr("x2", 65+shiftx).attr("y2", 108).attr("stroke","black").attr("stroke-width",3);
//fill rectangles
var rectangle = svgContainer.append("rect").attr("x",5+shiftx).attr("y",280).attr("width",5).attr("height",20).attr("fill","blue");
rectangle.transition().attr("y",180+ht0).attr("height",120-ht0).duration(2000);
var rectangle = svgContainer.append("rect").attr("x",5+shiftx).attr("y",300).attr("width",40).attr("height",8).attr("fill","blue");
var rectangle = svgContainer.append("rect").attr("x",35+shiftx).attr("y",280).attr("width",10).attr("height",20).attr("fill","blue");
//the hook pipe variabls
var line1 = svgContainer.append("line").attr("x1", 4+shiftx).attr("y1", 98.5).attr("x2", 5+shiftx).attr("y2", 310).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 11.5+shiftx).attr("y1", 108).attr("x2", 11.5+shiftx).attr("y2", 300).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 5+shiftx).attr("y1", 308.5).attr("x2", 45+shiftx).attr("y2", 308.5).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 11.5+shiftx).attr("y1", 298.5).attr("x2", 35+shiftx).attr("y2", 298.5).attr("stroke","black").attr("stroke-width",3);

var line1 = svgContainer.append("line").attr("x1", 45+shiftx).attr("y1", 250).attr("x2", 45+shiftx).attr("y2", 309.5).attr("stroke","black").attr("stroke-width",3);
var line1 = svgContainer.append("line").attr("x1", 35+shiftx).attr("y1", 250).attr("x2", 35+shiftx).attr("y2", 299.5).attr("stroke","black").attr("stroke-width",3);



//draw ht segment
var line1 = svgContainer.append("line").attr("x1", shiftx-10).attr("y1", 280).attr("x2", shiftx-10).attr("y2", 280).attr("stroke","black").attr("stroke-width",3);
line1.transition().attr("y1",180+ht0).duration(2000)
var line1 = svgContainer.append("line").attr("x1", shiftx-0).attr("y1", 280).attr("x2", shiftx-20).attr("y2", 280).attr("stroke","black").attr("stroke-width",3);
line1.transition().attr("y1",180+ht0).attr("y2",180+ht0).attr("height",120-ht0).duration(2000);
var line1 = svgContainer.append("line").attr("x1", shiftx-0).attr("y1", 280).attr("x2", shiftx-20).attr("y2", 280).attr("stroke","black").attr("stroke-width",3);
var text = svgContainer.append("text").attr("x",shiftx-140).attr("y",(280-ht+280+10)/2).attr("font-family","sans-Serif").attr("font-size",15).text("head loss: "+htUnscaled+" ft");
//draw head loss length
var line1 = svgContainer.append("line").attr("x1", 420+shiftx).attr("y1", 200).attr("x2", 420+shiftx).attr("y2", 200).attr("stroke","black").attr("stroke-width",3);
line1.transition().attr("y1", 100+hl).duration(2000);
var line1 = svgContainer.append("line").attr("x1", 410+shiftx).attr("y1", 200).attr("x2", 430+shiftx).attr("y2", 200).attr("stroke","black").attr("stroke-width",3);
line1.transition().attr("y1", 100+hl).attr("y2", 100+hl).duration(2000);
var line1 = svgContainer.append("line").attr("x1", 410+shiftx).attr("y1", 200).attr("x2", 430+shiftx).attr("y2", 200).attr("stroke","black").attr("stroke-width",3);
var text = svgContainer.append("text").attr("x",430+shiftx).attr("y",(100+hl+200+10)/2).attr("font-family","sans-Serif").attr("font-size",15).text("hold up: "+hli+ " ft");

//---||Tower Diameter||---//
var line1 = svgContainer.append("line").attr("x1", 55+shiftx).attr("y1", 400).attr("x2", 382.5+shiftx).attr("y2", 400).attr("stroke","black").attr("stroke-width",5);
var line1 = svgContainer.append("line").attr("x1", 382.5+shiftx).attr("y1", 390).attr("x2", 382.5+shiftx).attr("y2", 410).attr("stroke","black").attr("stroke-width",5);
var line1 = svgContainer.append("line").attr("x1", 55+shiftx).attr("y1", 390).attr("x2", 55+shiftx).attr("y2", 410).attr("stroke","black").attr("stroke-width",5);
//DT is used here!!
var text = svgContainer.append("text").attr("x",150+shiftx).attr("y",425).attr("font-family","sans-Serif").attr("font-size",15).text("Tray Diameter: "+DT+" ft"); 

//---||calulation desplay||---//
//---DT portion---//

var yaxis = 20; var increment=20; var delay = 0; var delayinc = 200;
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Rou v: "+rouv+" kg/m^3");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Flv: "+flv);
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Ad/A: "+ada);
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("F-Factor: "+F);
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("C2: "+C2+" m/s");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Ls: "+ls);
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("C1: "+C1+" m/s");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Tray Diameter: "+DT/3.28+" m");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
//---calculation for hl---//

var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("hole diameter: "+holeDiameter+" in");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("weir height: "+weirHeight+" in");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Lw: "+lw+" in");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("ql: "+ql+" gpm");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("cl: "+cl);
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("hole velocity: "+holeVelocity+" m/s");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Ua: "+ua+" ft/s");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Ks: "+C2+" ft/s");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("phi e "+phie);
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("clear liquid holdup: "+hl+" in");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);

//---calulation for hd---//

var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("U0: "+u0+" ft/s");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("hd: "+hd+" in");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);

//---calulations for hsigma---//

var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("Db Max: "+dbmax+" m");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("hsigma: "+hsigma+" in");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);

//---calulations for ht---//
var text = svgContainer.append("text").attr("x",600+shiftx).attr("y",yaxis+=increment).attr("font-family","sans-Serif").attr("font-size",15).style("opacity", 0).text("head loss: "+ht+" in");
text.transition().style("opacity", 100).duration(4000).delay(delay+=delayinc);


</script>
</td></tr><tr><td>
<center>
<!-- this is the return button -->
	{!! Form::open(['url'=>'tray']) !!}
	<!--I escape back to main page -->
	{!! Form::submit('Back to Input',['class' => 'btn btn-primary
	form-control']) !!} {!! Form::close() !!}
	</center>
</td></tr></table>

</center>
@stop

