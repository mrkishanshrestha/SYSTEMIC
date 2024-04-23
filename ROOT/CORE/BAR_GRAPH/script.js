function createBarGraph(jsonBarData,appendTo,barGraphTitle){

  if(jsonBarData==null || jsonBarData == undefined){
    alert('Please send append to data in createBarGraph Function');
    return false;
  }


  if(appendTo==null || appendTo == undefined){
    alert('Please send append to data in createBarGraph Function');
    return false;
  }

  if(barGraphTitle==null || barGraphTitle == undefined){
    alert('Please send barGraphTitle data in createBarGraph Function');
    return false;
  }

/*jsonBarData = [{
  "name": "Kerry",
  "score": 20,
  "base_title": "KISHAN"
}, {
  "name": "Teegan",
  "score": 73,
  "base_title": "KISHAN"
}, {
  "name": "Jamalia",
  "score": 20,
  "base_title": "KISHAN"
}, {
  "name": "Quincy",
  "score": 89,
  "base_title": "KISHAN"
}, {
  "name": "Darryl",
  "score": 24,
  "base_title": "KISHAN"
}, {
  "name": "Jescie",
  "score": 86,
  "base_title": "KISHAN"
}, {
  "name": "Quemby",
  "score": 96,
  "base_title": "KISHAN"
}, {
  "name": "McKenzie",
  "score": 71,
  "base_title": "KISHAN"
}];
*/

//chart data
var chartjson = {
    "title": barGraphTitle,
    "data": jsonBarData,
    "xtitle": "Secured Marks",
    "ytitle": "Marks",
    "ymax": 100,
    "ykey": 'score',
    "zkey": 'base_title',
    "xkey": "name",
    "prefix": "%"
  }
  
  //chart colors
  var colors = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen'];
  
  //constants
  var TROW = 'tr',
    TDATA = 'td';
  
  var chart = document.createElement('div');
  //create the chart canvas
  var barchart = document.createElement('table');
    barchart.setAttribute('id', 'barchart-table');
  //create the title row
  var titlerow = document.createElement(TROW);
  //create the title data
  var titledata = document.createElement(TDATA);
  //make the colspan to number of records
  titledata.setAttribute('colspan', chartjson.data.length + 1);
  titledata.setAttribute('class', 'charttitle');
  titledata.innerText = chartjson.title;
  titlerow.appendChild(titledata);
  barchart.appendChild(titlerow);
  chart.appendChild(barchart);
  
  //create the bar row
  var barrow = document.createElement(TROW);
  
  //lets add data to the chart
  for (var i = 0; i < chartjson.data.length; i++) {
    barrow.setAttribute('class', 'bars');
    var prefix = chartjson.prefix || '';
    //create the bar data
    var bardata = document.createElement(TDATA);
    var bar = document.createElement('div');
    bar.setAttribute('class', colors[i]);
    bar.style.height = chartjson.data[i][chartjson.ykey] + prefix;
    bardata.innerText = chartjson.data[i][chartjson.ykey] + prefix;
    bardata.appendChild(bar);
    bardata.append(chartjson.data[i][chartjson.zkey]);
    barrow.appendChild(bardata);
  }
  
  //create legends
  var legendrow = document.createElement(TROW);
  var legend = document.createElement(TDATA);
  legend.setAttribute('class', 'barchart-legend');
  legend.setAttribute('colspan', chartjson.data.length);
  
  
  barrow.appendChild(legend);
  barchart.appendChild(barrow);
  barchart.appendChild(legendrow);
  chart.appendChild(barchart);
  document.getElementById(appendTo).innerHTML = chart.outerHTML;

}