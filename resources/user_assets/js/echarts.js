const echarts = require('echarts/lib/echarts')
const dateFormat = require('dateformat')

require('echarts/lib/chart/line')
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')
require('echarts/lib/component/legend')
require('echarts/lib/component/toolbox')
require('echarts/lib/component/dataZoom')

let minAddzero = (num) => (num < 10 ? '0' + num : '' + num)

export default (data, dom, params) => {
  // console.log(document.getElementById(dom));
  let chart = echarts.init(document.getElementById(dom))
  // 出流量，单位:(M)
  let outflow = []
  // 入流量，单位:(M)
  let inflow = []
  for (let x of data) {
    let date = new Date(x.time * 1000)
    inflow.push([date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + minAddzero(date.getHours()) + ':' + minAddzero(date.getMinutes()) + ':' + minAddzero(date.getSeconds()), x.bandwidth_down.toFixed(3)])
  }
  for (let x of data) {
    let date = new Date(x.time * 1000)
    outflow.push([date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + minAddzero(date.getHours()) + ':' + minAddzero(date.getMinutes()) + ':' + minAddzero(date.getSeconds()), x.upstream_bandwidth_up.toFixed(3)])
  }
  let option = {
    animation: false,
    // title: {
    //   left: 'center',
    //   text: params.ip + ' —— 高防IP流量数据',
    //   subtext: '上传流量和下载流量（单位为M）'
    // },
    // legend: {
    //   x: 'left',
    //   data: ['上传流量', '下载流量']
    // },
    tooltip: {
      // position: function (pt) {
      //   return [pt[0], 130];
      // }
      trigger: 'axis'
      // axisPointer: {
      //   type: 'cross'
      // }
    },
    // toolbox: {
    //   left: 'center',
    //   itemSize: 25,
    //   top: 55,
    //   feature: {
    //     dataZoom: {
    //       yAxisIndex: 'none'
    //     },
    //     restore: {}
    //   }
    // },
    xAxis: {
      type: 'time',
      // axisLabel: {
      //   formatter: function (value, index) {
      //     let date = new Date(value);
      //     return date.getHours() + "时";
      //   }
      // },
      splitNumber: 8,
      // 最小刻度一分钟
      // minInterval: 60 * 1000,
      // 最大刻度一天
      // maxInterval: 3600 * 1000 * 24,
      axisPointer: {
        snap: true,
        lineStyle: {
          color: '#004E52',
          opacity: 0.5,
          width: 2
        },
        label: {
          show: true,
          formatter: function (params) {
            return echarts.format.formatTime('yyyy-MM-dd hh:mm:ss', params.value)
          },
          backgroundColor: '#004E52'
        }
        // , handle: {
        //   show: true,
        //   color: '#004E52'
        // }
      },
      splitLine: {
        show: false
      }
    },
    yAxis: {
      type: 'value',
      axisTick: {
        inside: true
      },
      splitLine: {
        show: false
      },
      axisLabel: {
        // inside: true,
        formatter: '{value}\n'
      },
      z: 10
    },
    grid: {
      // top: 110,
      // left: 80,
      // right: 10,
      // height: 160
    },
    // dataZoom: [{
    //   type: 'inside',
    //   throttle: 50
    // }],
    series: [
      {
        name: '下载流量',
        type: 'line',
        smooth: true,
        symbol: 'circle',
        symbolSize: 5,
        // sampling: 'average',
        showSymbol: false,
        showAllSymbol: false,
        itemStyle: {
          normal: {
            color: '#12cd66'
          }
        },
        areaStyle: {
          normal: {
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
              offset: 0,
              color: '#12cd66'
            }, {
              offset: 1,
              color: '#ffe'
            }])
          }
        },
        data: inflow
      },
      {
        name: '上传流量',
        type: 'line',
        smooth: true,
        symbol: 'circle',
        symbolSize: 5,
        // sampling: 'average',
        showSymbol: false,
        showAllSymbol: false,
        itemStyle: {
          normal: {
            color: '#4274f4'
          }
        },
        areaStyle: {
          normal: {
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
              offset: 0,
              color: '#4274f4'
            }, {
              offset: 1,
              color: '#ffe'
            }])
          }
        },
        data: outflow
      }
    ]
  }
  chart.setOption(option)
  return chart
}