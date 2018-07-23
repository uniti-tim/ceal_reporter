$(function(){if(window.page === 'home'){
  let $quotesPie = $('#quotes_pie');
  let $quotesPieLoader = $('#quotes_pie_loader');
  let $quotesVolume =$('#quotes_volume');
  let $quotesVolumeLoader = $('#quotes_volume_loader');
  let $quotesMRC =$('#quotes_mrc');
  let $quotesMRCLoader = $('#quotes_mrc_loader');

  loadQuotesPieChart($quotesPie,$quotesPieLoader);
  loadQuoteVolumeChart($quotesVolume, $quotesVolumeLoader);
  loadQuoteMRCChart($quotesMRC, $quotesMRCLoader);
}});

function loadQuotesPieChart($quotesPie, $quotesPieLoader){
  $.ajax({
    url: "quotes/piechart_progress",
    type: "GET",
    beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRFToken", window.csrf_token);
    },
    success: function(result){
          let results = JSON.parse(result);
          $quotesPieLoader.remove();
          $quotesPie.removeClass('hidden');
          var ctx = document.getElementById('quotes_pie').getContext('2d');
          var myChart = new Chart(ctx, {
              type: 'pie',
              data: {
                  labels: results.labels,
                  datasets: [{
                      data: results.data,
                      backgroundColor: results.backgroundColor,
                  }]
              }
          });
    }
  })
}

function loadQuoteVolumeChart($quotesVolume, $quotesVolumeLoader){
  $.ajax({
    url: "quotes/volume_chart",
    type: "GET",
    beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRFToken", window.csrf_token);
    },
    success: function(result){
      let results = JSON.parse(result);
      let formattedDataAll = [];
      let formattedDataComplete = [];
      $quotesVolumeLoader.remove();
      $quotesVolume.removeClass('hidden');

      //format data for total quotes
      for (var date in results[0].data) {
        formattedDataAll.push({
          x: new Date(date),
          y: results[0].data[date],
        });
      }

      //format data for completed quotes
      for (var date in results[1].data) {
        formattedDataComplete.push({
          x: new Date(date),
          y: results[1].data[date],
        });
      }

      var ctx = document.getElementById('quotes_volume').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              datasets: [
                {
                  label:results[0].label,
                  data: formattedDataAll,
                  borderColor: results[0].borderColor,
                  fill: results[0].fill,
                  type: "line",
                },
                {
                  label:results[1].label,
                  data: formattedDataComplete,
                  backgroundColor: results[1].backgroundColor,
                  borderColor: results[1].borderColor,
                  borderWidth: results[1].borderWidth,
                  fill: results[1].fill,
                  lineTension: 0,
                  type: 'bar',
                },
            ]
          },
            options: {
              scales: {
                  xAxes: [{
                      type: 'time',
                      time: {
                        unit: 'month'
                      },
                      distribution: 'series',
                  }],
                  yAxes:[{
                    scaleLabel:{
                      display: true,
                      labelString: "Quotes Created",
                    },
                  }]
              }
            },
      });
    }
  })

}


function loadQuoteMRCChart($quotesMRC, $quotesMRCLoader){
  $.ajax({
    url: "quotes/mrc_chart",
    type: "GET",
    beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRFToken", window.csrf_token);
    },
    success: function(result){
      let results = JSON.parse(result);
      let formattedData = [];
      $quotesMRCLoader.remove();
      $quotesMRC.removeClass('hidden');
      for (var date in results.data) {
        formattedData.push({
          x: new Date(date),
          y: results.data[date],
        });
      }
      var ctx = document.getElementById('quotes_mrc').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: results.labels,
              datasets: [{
                  label: "Monthly Recurring Revenue Earned",
                  data: formattedData,
                  backgroundColor: results.backgroundColor,
                  borderColor : results.borderColor,
                  borderWidth: 1,
                  fill: true,
              }]
          },
            options: {
              scales: {
                  xAxes: [{
                      type: 'time',
                      time: {
                        unit: 'month'
                      },
                      distribution: 'series',
                  }],
                  yAxes:[{
                    scaleLabel:{
                      display: true,
                      labelString: "Recurring Revenue in Dollars USD",
                    },
                  }]
              }
            },
      });
    }
  })

}
