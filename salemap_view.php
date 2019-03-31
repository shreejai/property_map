<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Nagpur Homes®: Check ongoing property rates in Nagpur on Nagpur's Exclusive Property Map 📍 </title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
       .navbar{
      background-color: none;
      background: rgba(0, 0, 0, 0.5);
      }
      .card{
      display:inline;
        margin-right:10px;
      }
      .gm-svpc{
      display:none;} /*Hides unnecessary google maps buttons*/
      
      .gmnoprint{
      display:none}/*Hides unnecessary google maps buttons*/
      
      /*SPECIALLY ADDED FOR MAP PAGE*/
      .septext{
      text-transform:uppercase;
        letter-spacing:7px;
      }
      .active{
      color:orange;
      }
    </style>
  </head>
  <body>
  
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  	<a class="navbar-brand septext" style="font-size:small;" href="http://nagpurhomes.com"><img src="images/nagpurhomes.png" width="130px"></a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-		expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  	</button>

  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    	<ul class="navbar-nav mr-auto">
      
      </ul>
      
    	<div class="form-inline my-2 my-lg-0">
          
          
          
          <ul class="navbar-nav mr-auto">
            	<li class="nav-item">
        <a class="nav-link" href="http://nagpurhomes.com/">Home <span class="sr-only">(current)</span></a>
      	</li>
      	<li class="nav-item">
        <a class="nav-link" href="http://nagpurhomes.com/buy">Buy</a>
      	</li>
        <li class="nav-item">
        <a class="nav-link" href="http://nagpurhomes.com/rent">Rent</a>
      	</li>
      	<!--<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Rent
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      	</li>-->
      	<li class="nav-item active">
        <a class="nav-link disabled" style="color:orange" href="http://nagpurhomes.com/salemap">Property Map</a>
      	</li>
      	<li class="nav-item">
        <a class="nav-link disabled" href="http://nagpurhomes.com/postad">List your property</a>
      	</li>
    	</ul>
          
          
          
      	<!--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          
      	<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
    	</div>
  		</div>
</nav>
    <?php
    include('connection.php');
    
    $query01='SELECT id,title,amount,lat,lng,listingtype,imagefolder FROM ptable WHERE lat IS NOT NULL';
    $result01=mysqli_query($link,$query01);
    
    $pdata=[];
    
    while($row01=$result01->fetch_assoc()){
    $pdata[]=$row01;
    }
    
    //$titles=[];
	$amounts=[];
    
    foreach($pdata as $pd){
 
      
      if($pd['amount'] == 0){
		$pd['amount'] = "₹(Ask)";}  
	  else if ($pd['amount'] < 100000) {
     //Anything less than a million
    	$pd['amount'] = '₹ '.number_format($pd['amount']/1000).' K';} 
      else if ($pd['amount'] < 10000000) {
    // Anything less than a billion
        $pd['amount'] ='₹ '. number_format($pd['amount'] / 100000).' L';} 
      else {
    // At least a billion
      $pd['amount'] ='₹ '. number_format($pd['amount'] / 10000000).' Cr.';}

      
      
  //print_r(json_encode(floatval($pd['amount'])));
   //echo $pd['amount'];   
   //$rupee=(json_encode(floatval($pd['amount'])));
      array_push($amounts,$pd['amount']);
    //echo",";
    }
    //print_r($amounts[1]);
    
    $rpdata=json_encode($pdata);
    //var_dump($pdata);
    //echo $rpdata[0][1];
    ?>
    <div id="map" style="text-align:center; /*margin-top:200px*/"><div>Loading...</div></div>
     
    <script>

      function initMap() {

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: {lat: 21.1458, lng: 79.0882}
  });
  var infoWin = new google.maps.InfoWindow({maxWidth:200}); //decreasing size of infowindow
        
        var image = {
                  //url: 'http://www.homedepot.com/catalog/swatchImages/35/04/04a604de-8b52-4cd8-a394-6286f00b438d_35.jpg',
          //url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
          url: 'images/orangemarker2.png',
                  // This marker is 35 pixels wide by 35 pixels high.
                  size: new google.maps.Size(53, 58),//53,58
                  // The origin for this image is (0, 0).
                  origin: new google.maps.Point(0, 0),//0,0
                  // The anchor for this image is the base of the flagpole at (0, 32).
                  anchor: new google.maps.Point(0, 10),//0,10
          //setting the label in desired place 
          			labelOrigin: new google.maps.Point(26,43)//26,45
                }; 
        
                  //var labels=["123","B","C","D","E","F","G","H","I","J","K","L"];

       //MAJOR STEP FOR MARKER LABELS BELOW: I learnt that map accepts 'array' of labels so copied php array of amounts to a javascript variable 'label' here and called them one by one as per length of array in var marker below 
        var labels = new Array();  
    <?php foreach($amounts as $key => $val){ ?>
        labels.push('<?php echo $val; ?>');
    <?php } ?>
        
        
        
        // Add some markers to the map.
  // Note: The code uses the JavaScript Array.prototype.map() method to
  // create an array of markers based on a given "locations" array.
  // The map() method here has nothing to do with the Google Maps API.
  var markers = locations.map(function(location, i) {
<?php 
    include ('connection.php');
         $sql1 = "SELECT amount FROM ptable WHERE lat IS NOT NULL";
    $result1 = mysqli_query($link,$sql1);
    $p=array();
    while($row1 = $result1->fetch_assoc()){
    	$p[]=$row1;
    }
    $abc=[1,2,4,3,44,5,6,6,7,'View'];
 ?>
    var marker = new google.maps.Marker({
      icon: image,
      position: location,
      animation: google.maps.Animation.DROP,
      label: {text:labels[i % labels.length], color: 'white'} 
            //label: {text:labels[i % labels.length], color: 'white', fontWeight: 'bold'} 

      //label: {text: echo "'".$abc[8]."'"; ?>, color: 'white',
      //fontSize: '15px',
      //        lineHeight: '5',
      //fontWeight: 'bold'}
    });
    google.maps.event.addListener(marker, 'click', function(evt) {
      infoWin.setContent(location.info);
      infoWin.open(map, marker);
    })
    return marker;
  });

  // markerCluster.setMarkers(markers);
  // Add a marker clusterer to manage the markers.
  var markerCluster = new MarkerClusterer(map, markers, {
    imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
  });

}
var locations = [

        <?php

         include ('connection.php');
         $sql = "SELECT lat,lng,title,id,amount,listingtype,imagefolder FROM ptable WHERE lat IS NOT NULL";

         $result = mysqli_query($link,$sql);

         while ($row = $result->fetch_assoc()){
           
           $id=$row['id'];
           
           $amount =floatval($row['amount']);

           $lat=$row['lat'];

           $lng=$row['lng'];
           
           $lac=100000;
           $cr=10000000;
           
           $amountType="Expected";
           
           $imagefolder=$row['imagefolder'];
           
           $images = glob($imagefolder."*.*");
           
            if($row['listingtype'] == 'Sell'){$amountType='Expected Price:';}else{$amountType='Expected Rent:';} 
           	if($amount==0){
              $amount='(Ask)';}
     		elseif($amount < $lac){
              $amount=' ₹ '.number_format($amount/1000)." K";}
           	elseif($amount < $cr){
              $amount=' ₹ '.number_format($amount/100000)." L";}
            else{$amount=' ₹ '.number_format($amount/10000000)." Cr";}
			
           /*if($imagefolder=='images/nophotos.jpg'){
           //$title='<table><tr><td><img class="card" src="'.$imagefolder.'" width="50px"></td><td><a href="http://sjideas.com/nagpur/viewad?adid='.$id.'">'.$row['title'].'</a><br>'.$amountType.$amount.'</td></tr></table>';}
           //else{$title='<table><tr><td><img class="card" src="'.$imagefolder.'small/s.jpg" width="50px"></td><td><a href="http://sjideas.com/nagpur/viewad?adid='.$id.'">'.$row['title'].'</a><br>'.$amountType.$amount.'</td></tr></table>';}*/
           
           if(count($images)<1){
           $title='<table><tr><td><img class="card" src="images/nophotos.jpg" width="50px"></td><td><a href="http://nagpurhomes.com/viewad?adid='.$id.'">'.$row['title'].'</a><br>'.$amountType.$amount.'</td></tr></table>';}
           else{$title='<table><tr><td><img class="card" src="'.$imagefolder.'small/s.jpg" width="50px"></td><td><a href="http://nagpurhomes.com/viewad?adid='.$id.'">'.$row['title'].'</a><br>'.$amountType.$amount.'</td></tr></table>';}
?><?php
           //echo"{lat:".$lat.",lng:".$lng."},";
           echo"{lat:".$lat.",lng:".$lng.",info:'".$title."'},";

         }

        ?>
        //{lat: 21.149657, lng: 79.052183},
      ];

google.maps.event.addDomListener(window, "load", initMap);
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=*YOUR API KEY HERE*&callback=initMap">
    </script>
    
    
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</div>

<div class="sticky-bottom" style="text-align:center; color:white; background-color:#1a1d21; padding:20px; z-index:4; letter-spacing: 7px; text-transform: uppercase;">
NagpurHomes <span style="color:#f7a518">&copy;</span> 2018
</div>
</body>
</html>
