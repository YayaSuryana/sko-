@extends('stisla.layouts.app-table')

@section('title')
  Document
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ __('Detail Atlet') }}</h1>
  </div>
  <div class="row">
    {{-- @if ($user->can('Log Aktivitas')) --}}
      <div class="col-12">
        <div class="card">
          <div class="card-header text-center">
          </div>
          {{-- Biodata --}}
          <div class="card-body">
            <h4 class="text-center">Biodata Atlet</h4>
            <div class="row">
                <table class="table table-hover">
                    <tr>
                        <td rowspan="5" class="text-center"><img src="{{$collection->foto_profile}}" class="img-thumbnail" alt="{{$collection->nama}}" width="200px"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{$collection->nama}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{$collection->tempat_lahir}}, {{$collection->tanggal_lahir}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{$collection->alamat}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Cabor</td>
                        <td>:</td>
                        <td>{{$collection->cabor}}</td>
                    </tr>
                </table>
            </div>
          </div>

          {{-- Skill --}}
          <div class="card-body">
            <h5 class="text-center">Skill</h5>
            <table class="table table-border table-hover text-center">
                <tr>
                    <th>Dribling</th>
                    <th>Shooting</th>
                    <th>Long Pass</th>
                </tr>
                <tr>
                    @if($collection_skill != null)
                        <td>{{$collection_skill->dribling}}</td>
                        <td>{{$collection_skill->shooting}}</td>
                        <td>{{$collection_skill->long_pass}}</td>
                    @else
                        <td colspan="3"><h6>Data Tidak Ditemukan</h6></td>
                    @endif
                </tr>
            </table>
          </div>

          {{-- Fisik --}}
          <div class="card-body">
            <h5 class="text-center">Fisik</h5>
            <table class="table table-border table-hover text-center">
                <tr>
                    <th colspan="2">Sanding Boarding Jump</th>
                    <th colspan="2">Illinois</th>
                    <th>Bleep Test</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>R</th>
                    <th>L</th>
                    <th>VO2MAX</th>
                </tr>
                <tr>
                    @if($collection_fisik != null)
                        <td>{{$collection_fisik->jump_1}}</td>
                        <td>{{$collection_fisik->jump_2}}</td>
                        <td>{{$collection_fisik->illinois_left}}</td>
                        <td>{{$collection_fisik->illinois_right}}</td>
                        <td>{{$collection_fisik->vo2max}}</td>
                    @else
                        <td colspan="5"><h6>Data Tidak Ditemukan</h6></td>
                    @endif
                </tr>
            </table>
          </div>

          {{-- Spider Chart --}}
          <div class="card-body">
            <h5 class="text-center">Grafik</h5>
            <div class="row">
                <div class="col-md-7 m-auto">
                    <div id="chartjs-radar">
                        <canvas id="canvas"></canvas>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    {{-- @endif --}}
  </div>
@endsection

@push('js')
  <script>
    function openTo(link) {
      window.location.href = link;
    }
  </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script>
    window.chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(231,233,237)'
    };
    window.randomScalingFactor = function() {
    return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
    }
    var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
    };
    var now = moment();
    var dataTime1 = moment("2016-12-18T14:58:54.026Z");
    var dataTime2 = moment("2017-01-18T20:58:54.026Z");
    var dataTime3 = moment("2017-02-15T08:58:54.026Z");
    var label1 =moment.duration(dataTime1.diff(now)).humanize(true);
    var label2 =moment.duration(dataTime2.diff(now)).humanize(true);
    var label3 =moment.duration(dataTime3.diff(now)).humanize(true);
    var color = Chart.helpers.color;
    var config = {
    type: 'radar',
    data: {
        labels: [
        "Kecepatan", "Kelincahan", "Kelenturan","Power Tungkai", "Kekuatan Otot Lengah", "Kekutan Otot Perut","Kekuatan Otot Kaki", "Daya Tahan Jantung"],
        datasets: [{
        label: 'Target',
        backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
        borderColor: window.chartColors.red,
        pointBackgroundColor: window.chartColors.red,
        data: [5,5,5,5,5,5,5,5,5],
        notes: ["5","5","5","5","5","5","5","5"]
        }, {
        label: 'Hasil',
        backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
        borderColor: window.chartColors.blue,
        pointBackgroundColor: window.chartColors.blue,
        data: [2,2,2,2,1,4,5,2],
        notes: ["2","2","2","2","1","4","5","2"]
        }]
    },
    options: {
        legend: {
        position: 'top',
        },
        title: {
        display: true,
        text: 'Cabang Olahraga Pencak Silat'
        },
        scale: {
        ticks: {
            beginAtZero: true
        }
        },
        tooltips:{
        enabled:false,
        callbacks:{
            label: function(tooltipItem, data){
            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
            //This will be the tooltip.body
            return datasetLabel + ': ' + tooltipItem.yLabel +': '+ data.datasets[tooltipItem.datasetIndex].notes[tooltipItem.index];
            }
        },
        custom: function(tooltip){
            // Tooltip Element
            var tooltipEl = document.getElementById('chartjs-tooltip');
            if (!tooltipEl) {
                tooltipEl = document.createElement('div');
                tooltipEl.id = 'chartjs-tooltip';
                tooltipEl.innerHTML = "<table></table>"
                document.body.appendChild(tooltipEl);
            }
            // Hide if no tooltip
            if (tooltip.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
            }
            // Set caret Position
            tooltipEl.classList.remove('above', 'below', 'no-transform');
            if (tooltip.yAlign) {
                tooltipEl.classList.add(tooltip.yAlign);
            } else {
                tooltipEl.classList.add('no-transform');
            }
            function getBody(bodyItem) {
                return bodyItem.lines;
            }
            // Set Text
            if (tooltip.body) {
                var titleLines = tooltip.title || [];
                var bodyLines = tooltip.body.map(getBody);
                var innerHtml = '<thead>';
                titleLines.forEach(function(title) {
                innerHtml += '<tr><th>' + title + '</th></tr>';
                });
                innerHtml += '</thead><tbody>';
                bodyLines.forEach(function(body, i) {
                var colors = tooltip.labelColors[i];
                var style = 'background:' + colors.backgroundColor;
                style += '; border-color:' + colors.borderColor;
                style += '; border-width: 2px';
                var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                innerHtml += '<tr><td>' + span + body + '</td></tr>';
                });
                innerHtml += '</tbody>';
                var tableRoot = tooltipEl.querySelector('table');
                tableRoot.innerHTML = innerHtml;
            }
            var position = this._chart.canvas.getBoundingClientRect();
            // Display, position, and set styles for font
            tooltipEl.style.opacity = 1;
            tooltipEl.style.left = position.left + tooltip.caretX + 'px';
            tooltipEl.style.top = position.top + tooltip.caretY + 'px';
            tooltipEl.style.fontFamily = tooltip._fontFamily;
            tooltipEl.style.fontSize = tooltip.fontSize;
            tooltipEl.style.fontStyle = tooltip._fontStyle;
            tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
            }
        }
    }
    };
    window.onload = function() {
    window.myRadar = new Chart(document.getElementById("canvas"), config);
    };
    var colorNames = Object.keys(window.chartColors);
    </script>
@endpush
