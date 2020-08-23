<!DOCTYPE html>
<html>
<head>
	<title>Covid-19</title>
	<meta http-equiv=”Content-Type” content=”text/html; charset=iso-8859-1″>
	<link rel="stylesheet" type="text/css" href="main.css"/>
</head>

<?php 

    $url = 'https://opendata.ecdc.europa.eu/covid19/casedistribution/csv';
    $arquivo = file_get_contents($url);
    $lines = explode(PHP_EOL, $arquivo);

    #$arquivo_local = file('C:\xampp\htdocs\projetos\gcovid\banco.csv');

    foreach ($lines as $line) {
        #$csv[] = explode(',', $line);

        $csv[] = str_getcsv($line);
    }
    
    
    $inicio = 1;
    while ($csv[$inicio][6] != 'Brazil'){
        $inicio += 1;
    }
    
    $final = $inicio;
    while ($csv[$final][0] != '01/04/2020'){
        $final += 1;
    }

?>



<body>
  <div id="chart"></div>
  <div class="views">
    <button onclick="updateSeries(1)">
      LAST 30 DAYS
    </button>

    <button onclick="updateSeries(2)">
      FULL
    </button>
  </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">


  var options = {
    chart: {
      type: 'candlestick',
      height: '75%',
      background: '#000',
      padding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
      },

      toolbar: {
        show: true,
        offsetX: 0,
        offsetY: 0,
        tools: {
          download: false,
          selection: false,
          zoom: false,
          zoomin: true,
          zoomout: true,
          pan: true,
          reset: true | '<img src="/static/icons/reset.png" width="20">',
          customIcons: []
        },
        autoSelected: 'pan' 
      },
    },
    series: [{
    name: 'Cases',
    data: [

    <?php  

      $mes = $inicio;
      #if($csv[$i+1][4] > $csv[$i][4]){  echo $csv[$i+1][4] }else { echo $csv[$i][4] }
      while ($csv[$mes][2] == $csv[$inicio][2]){
          $mes += 1;
      }
      
      for ($i=$mes-1; $i != $inicio-1; $i--) {  ?>     
        {  
          x: new Date(2020, <?php echo $csv[$i][2]-1  ?>, <?php echo $csv[$i][1] ?>),
          y: [<?php echo $csv[$i+1][4]  ?>, 
          <?php if ($csv[$i+1][4] > $csv[$i][4]) {
            echo $csv[$i+1][4];
          }else {
            echo $csv[$i][4]; 
          };?>,
          <?php if ($csv[$i+1][4] > $csv[$i][4]) {
            echo $csv[$i][4];
          }else {
            echo $csv[$i+1][4]; 
          };?>, 
          <?php echo $csv[$i][4]  ?>]    
        },
    <?php  } ?>
    ]
  }],
  
    xaxis: {
      type: 'datetime',
      labels: {
        style: {
            colors: '#C0C0C0',
            fontWeight: 'normal',
            fontSize: '0.7em',
        },
        offsetY: 5,
      }
    },   
    yaxis: {
      labels: {
        style: {
            colors: '#C0C0C0',
            fontWeight: 'normal',
            fontSize: '0.7em',
        },
        offsetX: -10,
      }
    }, 
    title:{
      text: 'COVID-19 CASES - BRAZIL',
      align: 'center',
      offsetY: 50,
      style:{
        color: '#C0C0C0',
        fontWeight: 'normal',
        fontSize: '1.2em',
        fontFamily: 'sans-serif'
      }
    },
    plotOptions: {
      candlestick: {
        colors: {
          upward: '#3C90EB',
          downward: '#DF7D46'
        }
      }
    }


  }

  var chart = new ApexCharts(document.querySelector("#chart"), options);

  chart.render();

  function updateSeries(x){

    if (x == 1){
      chart.updateSeries([{
      data: [ 
        <?php  
          for ($i=$mes-1; $i != $inicio-1; $i--) {  ?>     
            {  
              x: new Date(2020, <?php echo $csv[$i][2]-1  ?>, <?php echo $csv[$i][1] ?>),
              y: [<?php echo $csv[$i+1][4]  ?>, 
              <?php if ($csv[$i+1][4] > $csv[$i][4]) {
                echo $csv[$i+1][4];
              }else {
                echo $csv[$i][4]; 
              };?>,
              <?php if ($csv[$i+1][4] > $csv[$i][4]) {
                echo $csv[$i][4];
              }else {
                echo $csv[$i+1][4]; 
              };?>, 
              <?php echo $csv[$i][4]  ?>]    
            },
          <?php  }; ?>
      ]
    }])
    };

    if (x == 2){
      chart.updateSeries([{
      data: [ 
        <?php  
          for ($i=$final; $i != $inicio-1; $i--) {  ?>     
            {  
              x: new Date(2020, <?php echo $csv[$i][2]-1  ?>, <?php echo $csv[$i][1] ?>),
              y: [<?php echo $csv[$i+1][4]  ?>, 
              <?php if ($csv[$i+1][4] > $csv[$i][4]) {
                echo $csv[$i+1][4];
              }else {
                echo $csv[$i][4]; 
              };?>,
              <?php if ($csv[$i+1][4] > $csv[$i][4]) {
                echo $csv[$i][4];
              }else {
                echo $csv[$i+1][4]; 
              };?>, 
              <?php echo $csv[$i][4]  ?>]    
            },
        <?php  }; ?>
      ]
    }])
    }
    
  };
</script>
</html>
