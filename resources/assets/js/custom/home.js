$(function(){if(window.page === 'home'){
  let $quotesPie = $('#quotes_pie');
  let $quotesPieLoader = $('#quotes_pie_loader');
  let $quotesVolume =$('#quotes_volume');
  let $quotesVolumeLoader = $('#quotes_volume_loader');

  loadQuotesPieChart($quotesPie,$quotesPieLoader);
  loadQuoteVolumeChart($quotesVolume, $quotesVolumeLoader);
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
  // $quotesVolumeLoader.remove();
  // $quotesVolume.removeClass('hidden');
  // var ctx = document.getElementById('quotes_volume').getContext('2d');
  // var myChart = new Chart(ctx, {
  //     type: 'line',
  //     data: {
  //         datasets: [{
  //           label: 'Test Dataset',
  //           data: [{
  //             x: new Date("6/12/2018"),
  //             y: 20
  //           },
  //           {
  //             x: new Date("6/12/2018"),
  //             y: 30
  //           },
  //           {
  //             x: new Date("6/13/2018"),
  //             y: 50
  //           }
  //         ],
  //           borderColor: "rgb(75, 192, 192)",
  //           fill: false,
  //         }]
  //     },
  //
  // });

  $.ajax({
    url: "quotes/volume_chart",
    type: "GET",
    beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRFToken", window.csrf_token);
    },
    success: function(result){
      let results = JSON.parse(result);
      let formattedData = [];
      $quotesVolumeLoader.remove();
      $quotesVolume.removeClass('hidden');
      for (var date in results.data) {
        formattedData.push({
          x: new Date(date),
          y: results.data[date],
        });
      }
      var ctx = document.getElementById('quotes_volume').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'line',
          data: {
              datasets: [{
                  label:results.label,
                  data: formattedData,
                  borderColor: "rgb(75, 192, 192)",
                  fill: true,
              }]
          },
            options: {
              scales: {
                  xAxes: [{
                      type: 'time',
                      time: {
                        unit: 'day'
                      },
                      distribution: 'series',
                  }],
              }
            },
      });
    }
  })

}
