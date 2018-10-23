
@extends('common.page_wrapper.index')


@section('filters')
    <div class="row" style="margin-top: 15px;">
        <div class="col-lg-6 m-form__group-sub">
            <select class="form-control m-input" id="year">
                <option value="">
                    Please select year
                </option>
                @foreach($years as $year)
                    <option value="{{ $year }}" @if(date('Y') == $year)selected="selected"@endif>{{ $year }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6 m-form__group-sub">
            <select class="form-control m-input" id="month">
                <option value="">
                    Please select month
                </option>
                @foreach($months as $id => $month)
                    <option value="{{ $id }}">{{ $month }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection


@section('content')

    <input type="hidden" id="school_id" value="{{ $school_id }}">

    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet col-lg-12 m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link control-graph active show" data-toggle="tab" href="#electrycity" role="tab" aria-selected="true">
                                    Electricity 
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link control-graph" data-toggle="tab" href="#heating" role="tab" aria-selected="false">
                                    Heating 
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link control-graph" data-toggle="tab" href="#water" role="tab" aria-selected="false">
                                    Water
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="electrycity" role="tabpanel">
                            Please select params
                        </div>
                        <div class="tab-pane" id="heating" role="tabpanel">
                            Please select params
                        </div>
                        <div class="tab-pane" id="water" role="tabpanel">
                            Please select params
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-6 offset-lg-6">
            <div class="m-portlet">
                {{-- <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Title
                            </h3>
                        </div>
                    </div>
                </div> --}}
                <!--begin::Form-->
                <form id="graph_params_form" class="m-form m-form--fit m-form--label-align-right">
                    <div class="m-portlet__body">
                
                       <div class="form-group m-form__group">
                            <label for="exampleInputEmail1">
                                Benchmark Manually
                            </label>
                            <input type="number" id="benchmark_manually" class="form-control m-input"  aria-describedby="emailHelp" placeholder="Enter value">
                        </div>
                        
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <div class="row">
                                <button type="submit" class="btn btn-success">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    
        
    </div>

    

@endsection

@section('script_content')
    {{-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script>
    let data = {}
    const wrapper = document.getElementById('graph_wrapper')
    const paramForm = document.getElementById('graph_params_form')
    const benchmark_manually = document.getElementById('benchmark_manually')
    const getValue = selector => document.querySelector(selector).value
    const school_id = getValue('#school_id')

    let line_graphs_list = []

    const updateGraphline = (chart, value, type) => {
        const defaultOptions = {
            "zIndex": 100,
            "value": value,
            "color": "red",
            "dashStyle": "solid",
            "width": 1,
            "label": {
                "style": {
                "color": "red",
                "fontWeight": "bold"
                },
                "text": `${value}${type === '#water' ? 'liters' : 'kWh'}`,
                "textAlign": "left",
                "x": -30
            }
        }
        for (let [key, value] of Object.entries(defaultOptions)) {
            chart.yAxis[0].options.plotLines[0][key] = value
        }
        
        chart.yAxis[0].update();
    }

    const updateLineOnNewValue = event => {
        if (event.target.tagName === 'FORM') event.preventDefault()

        const associate = {
            '#electrycity': 0,
            '#heating': 1,
            '#water': 2
        }

        const activeSelector = document.querySelector('a.control-graph.active').getAttribute('href')

        const current = line_graphs_list[associate[activeSelector]]

        const value = benchmark_manually.value
        updateGraphline(current, value, activeSelector)

        $.ajax({
            type: "POST",
            url: `/school/${school_id}/benchmark?type=${associate[activeSelector]}&value=${value}`,
            success: response => console.log(response),
        });
    }

    const Chart = class {
      constructor({container, data}) {
        this.container = container
        this.char = null
        this.data = data
      }

      render() {
        this.chart = new Highcharts.Chart({
          ...this.data,
          chart: {
            renderTo: this.container,
            type: 'column',
            backgroundColor: '#DCDCDC',
            options3d: {
              enabled: true,
              alpha: 0,
              beta: 20,
              depth: 50,
              viewDistance: 999
            }
          },
          plotOptions: {
            series: {
              dataLabels: {
                enabled: true,
                align: 'center',
                color: '#000000',
                verticalAlign: 'top'
              },
              pointPadding: 0.1,
              groupPadding: 0
            }
          }
        });
      }

      getSelf() {
        return this.chart
      }
    }

    const generateGraphs = (response, key, tabContent) => {
      let _data = {
        exporting: {
          filename: response.filename
        },
        chart: {
          type: 'column',
          options3d: {
            enabled: true,
            alpha: 0,
            beta: 0,
            viewDistance: 25,
            depth: 40
          }
        },
        title: {
          text: response.name
        },
        xAxis: {
          categories: response.categories,
          labels: {
            skew3d: true,
            style: {
              fontSize: '16px'
            }
          }
        },
        yAxis: {
          allowDecimals: false,
          min: 0,
          title: {
            text: response.yAxis,
            skew3d: true
          },
          plotLines: response.plotLines
        },
        series: [{
          name: response.series,
          data: response.data.map(value => +value)
        }]
      }

      const id = tabContent.id
      const chartContainer = document.createElement('div')
      const containerId = `${id}_${+new Date()}_${key}`
      chartContainer.className = 'col-lg-6'
      chartContainer.id = containerId
      tabContent.append(chartContainer)

      const Graph = new Chart({container: containerId, data: _data})
      Graph.render()
      return Graph.getSelf()
    }
       const getSelector = (selector) => document.querySelector(selector)


    
    const getGraphs = () => {
        const [school_id, year, month] = [getValue('#school_id'), getValue('#year'), getValue('#month')]

        const [electrycity, heating, water] = [getSelector('#electrycity'), getSelector('#heating'), getSelector('#water')]

        const associate = {
            0: electrycity,
            1: heating,
            2: water
        }

        
        fetch(`/school/graphData?school_id=${school_id}&year=${year}&month=${month}`)
            .then( json => json.json())
            .then( response => {
                Object.values(associate).forEach( selector => selector.innerHTML = '')
                line_graphs_list = []
                response.map( (data, idx) => {
                    const {money, value} = data
                    const currentTabContent = associate[idx]
                    generateGraphs(money, idx, currentTabContent)
                    line_graphs_list = [...line_graphs_list, generateGraphs(value, idx, currentTabContent)]
                } )
            } )
    
            .then(data => {
                const Graph = new Chart({ container: 'graph_container', data })
                Graph.render()
            })
    }
    
    
  

    
    document.addEventListener('DOMContentLoaded', () => {
       getGraphs()
       const selectBoxes = [getSelector('#school_id'), getSelector('#year'), getSelector('#month')]
       selectBoxes.forEach( box => box.addEventListener( 'change', event => {
           if (event.target.value || event.target.id === 'month') {
               getGraphs()
           }
       } ) )

       benchmark_manually.addEventListener( 'blur', updateLineOnNewValue )
       paramForm.addEventListener( 'submit', updateLineOnNewValue )
    })
    
    </script>
@endsection



