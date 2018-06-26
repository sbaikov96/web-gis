/**
 Template Name: Abstack - Bootstrap 4 Web App kit
 Author: CoderThemes
 Email: coderthemes@gmail.com
 File: Dashboard
 */


!function($) {
    "use strict";

    var ChartJs = function() {};

    ChartJs.prototype.respChart = function(selector,type,data, options) {
        // get selector by context
        var ctx = selector.get(0).getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart );

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                case 'Line':
                    new Chart(ctx, {type: 'line', data: data, options: options});
                    break;
                case 'Doughnut':
                    new Chart(ctx, {type: 'doughnut', data: data, options: options});
                    break;
                case 'Pie':
                    new Chart(ctx, {type: 'pie', data: data, options: options});
                    break;
                case 'Bar':
                    new Chart(ctx, {type: 'bar', data: data, options: options});
                    break;
                case 'Radar':
                    new Chart(ctx, {type: 'radar', data: data, options: options});
                    break;
                case 'PolarArea':
                    new Chart(ctx, {data: data, type: 'polarArea', options: options});
                    break;
            }
            // Initiate new chart or Redraw

        };
        // run function - render chart at first load
        generateChart();
    },

        //init
        ChartJs.prototype.init = function() {
            //barchart
            var barChart = {
                labels: ["0%-25%", "25%-50%", "50%-75%", "75%-100%"],
                datasets: [
                    {
                        label: "Количество заполненых баков",
                        backgroundColor: "#3ec396",
                        borderColor: "#3ec396",
                        borderWidth: 1,
                        hoverBackgroundColor: "#3ec396",
                        hoverBorderColor: "#3ec396",
                        data: [200, 59, 80, 81]
                    }
                ]
            };
            var barOpts = {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: "rgba(255,255,255,0.05)",
                            fontColor: '#fff'
                        },
                        ticks: {
                            max: 200,
                            min: 20,
                            stepSize: 20
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: "rgba(0,0,0,0.1)"
                        }
                    }]
                }
            };

             var barChart1 = {
                labels: ["0%-25%", "25%-50111%", "50%-75%", "75%-100%"],
                datasets: [
                    {
                        label: "Количество заполненых баков",
                        backgroundColor: "#3ec396",
                        borderColor: "#3ec396",
                        borderWidth: 1,
                        hoverBackgroundColor: "#3ec396",
                        hoverBorderColor: "#3ec396",
                        data: [200, 59, 80, 81]
                    }
                ]
            };
            var barOpts1 = {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: "rgba(255,255,255,0.05)",
                            fontColor: '#fff'
                        },
                        ticks: {
                            max: 200,
                            min: 20,
                            stepSize: 20
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: "rgba(0,0,0,0.1)"
                        }
                    }]
                }
            };


            this.respChart($("#sales-history"),'Bar',barChart, barOpts, barChart1, barOpts1);
        },
        $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

}(window.jQuery),

//initializing
    function($) {
        "use strict";
        $.ChartJs.init()
    }(window.jQuery);


