(table2graph = function(){

  /* variables */
  var triggerClass = 'tochart';
  var chartClass = 'fromtable';
  var hideClass = 'hidden';
  var chartColor = '339933';
  var chartSize = '450x150';
  var chartType = 'p';
  
  var toTableClass = 'totable';
  var tableClass = 'generatedfromchart';
  /* end variables */

  var tables = document.getElementsByTagName('table');
  var sizeCheck = /\s?size([^\s]+)/;
  var colCheck = /\s?color([^\s]+)/;
  var ctypeCheck = /\s?ctype([^\s]+)/;
  for(var i=0;tables[i];i++){
    var t = tables[i];
    var c = t.className;
    var data = [];
    var labels = []
    if(c.indexOf(triggerClass) !== -1){
      var size = sizeCheck.exec(c);
      size = size ? size[1] : chartSize;
      var col = colCheck.exec(c);
      col = col ? col[1] : chartColor;
      var ctype = ctypeCheck.exec(c);
      ctype = ctype ? ctype[1] : chartType;	  
      var charturl = 'http://chart.apis.google.com/chart?cht=' + ctype + '&chco=' + col + '&chs=' + size + '&chd=t:';
      t.className += ' '+ hideClass;
      var tds = t.getElementsByTagName('tbody')[0].getElementsByTagName('td');
      for(var j=0;tds[j];j+=2){
        labels.push(tds[j].innerHTML);
        data.push(tds[j+1].innerHTML);
      };
      var chart = document.createElement('img');
      chart.setAttribute('src',charturl+data.join(',') + '&chl=' + labels.join('|'));
      chart.setAttribute('alt',t.getAttribute('summary'));
	  chart.setAttribute('title',t.getAttribute('summary'));
      chart.className = chartClass;
      t.parentNode.insertBefore(chart,t);
    };
  };
  
}());
