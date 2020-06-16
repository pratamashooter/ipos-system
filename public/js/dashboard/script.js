function changeDataPelanggan(chart, label_array, data_array){
  chart.data = {
      labels: label_array,
      datasets: [{
          label: '',
          data: data_array,
          backgroundColor: 'RGB(44, 77, 240)',
          borderColor: 'RGB(44, 77, 240)',
          borderWidth: 0
      }]
  }
  chart.options = {
    title: {
        display: false,
        text: ''
    },
    scales: {
      yAxes: [{
          ticks: {
              beginAtZero: true,
              callback: function(value, index, values) {
                return value;
             }
          }
      }],
      xAxes: [{
          barPercentage: 0.2
      }]
    },
    legend: {
        display: false
    },
    tooltips: {
        callbacks: {
           label: function(tooltipItem) {
                  return tooltipItem.yLabel;
           }
        }
    }
  }
  chart.update();
  Chart.defaults.global.datasets.bar.categoryPercentage = 0.95;
}

function changeDataPemasukan(chart, label_array, data_array){
  chart.data = {
      labels: label_array,
      datasets: [{
          label: '',
          data: data_array,
          backgroundColor: 'RGB(44, 77, 240)',
          borderColor: 'RGB(44, 77, 240)',
          borderWidth: 0
      }]
  }
  chart.options = {
    title: {
        display: false,
        text: ''
    },
    scales: {
      yAxes: [{
          ticks: {
              beginAtZero: true,
              callback: function(value, index, values) {
                if (parseInt(value) >= 1000) {
                   return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } else {
                   return 'Rp. ' + value;
                }
             }
          }
      }],
      xAxes: [{
          barPercentage: 0.2
      }]
    },
    legend: {
        display: false
    },
    tooltips: {
        callbacks: {
           label: function(tooltipItem) {
                  return tooltipItem.yLabel;
           }
        }
    }
  }
  chart.update();
}

$(document).on('click', '.btn-view-all', function(e) {
  $("body,html").animate(
    {
      scrollTop: $("#footer-content").offset().top
    }, 400
  );
});

$(function() {
  $("form[name='market_form']").validate({
    rules: {
      nama_toko: "required",
      no_telp: "required",
      alamat: "required"
    },
    messages: {
      nama_toko: "Nama toko tidak boleh kosong",
      no_telp: "No telepon tidak boleh kosong",
      alamat: "Alamat tidak boleh kosong"
    },
    errorPlacement: function(error, element) {
        var name = element.attr("name");
        $("#" + name + "_error").html(error);
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});