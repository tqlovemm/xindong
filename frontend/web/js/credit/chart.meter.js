/**
 * 
 * @authors 王昱森
 * @date    2015-08-14 11:31:56
 * @version 1.0.3
 */
var Meter = (function () {

    var $fff = "#fff";
    var $transparent = "transparent";
    var options = {

        styles: {
            sAngle: 0.93,
            eAngle: 2.07,
            area: {
                radius: 8,
                colors: { 
                    '0': $transparent,
                    '0.15': $transparent,
                    '0.27': $transparent,
                    '0.75': $transparent,
                    '0.93': $transparent,
                    '1': $transparent
                },
                lineWidth: 3,
                scaleLength: 10,
                scaleWidth: 0.8,
                lineColor: $fff
            },
            range: {
                color: $fff,
                width: 2,
                arrow: {
                    height: 20,
                    radius: 2
                } 
            },


            //数字字体设置
            value: {
                margin: 0,
                color: $fff,
                font: 'bold 34px Microsoft YaHei'
            },
            title: {
                margin: 30,
                color: $fff,
                font: 'bold 16px Microsoft YaHei'
            },
            subTitle: {
                margin: 60,
                color: $fff,
                font: '14px Microsoft YaHei'
            },
            label: {
                radius: 30,
                color: $fff,
                background: $transparent,
                font: '12px Microsoft YaHei'
            },
            inner: {
                radius: 125,
                color: $fff,
                dashedWidth: 0
            }
        }
    };

    var element, 
        context, 
        styles,
        sAngle,
        eAngle,
        areaStyle,
        rangeStyle,
        valueStyle,
        titleStyle,
        subTitleStyle,
        labelStyle,
        innerStyle;

    var extend = function(obj1, obj2){
        for(var k in obj2) {
            if(obj1.hasOwnProperty(k) && typeof obj1[k] == 'object') {
                extend(obj1[k], obj2[k]);
            } else {
                obj1[k] = obj2[k];
            }
        }
    }

    var calcLocation = function(r, end){

        return {
            x: options.centerPoint.x + r * Math.cos(Math.PI * end),
            y: options.centerPoint.y + r * Math.sin(Math.PI * end)
        };
    }

    var calcValueRange = function(value){
        var data = options.data.area,
            index = data.length - 1;

        for (var i = index; i >= 0; i--) {
            if(value >= data[i].min && value < data[i].max){
                index = i;
            }
        };
        var r = (eAngle - sAngle)/data.length,
            s = r * index + sAngle,
            e = r * (index + 1) + sAngle,
            o = data[index];

        return {
            range: (value - o.min)/(o.max - o.min) * (e - s) + s,
            index: index
        };
    }

    var drawCircle = function(opts, flag) {
        var x = opts.x || options.centerPoint.x,
            y = opts.y || options.centerPoint.y,
            s = opts.start || 0,
            e = opts.end || 2;

        context.beginPath();
        //context.moveTo(x, y);

        switch(flag){
            case 1: 
                context.setLineDash && context.setLineDash([innerStyle.dashedWidth]);
            case 2:
                context.arc(x, y, opts.r, Math.PI*s, Math.PI*e);
                context.strokeStyle = opts.style;
                context.stroke();
                context.closePath();
                break;
            default:
                context.arc(x, y, opts.r, Math.PI*s, Math.PI*e);

                context.fillStyle = opts.style;
                context.fill();
                context.closePath();
                break;
        }      
    }

    var drawArea = function(){
        var grad  = context.createLinearGradient(0, 0, options.radius*2, 0);
        for(var k in areaStyle.colors) {
            grad.addColorStop(k, areaStyle.colors[k]);
        }

        drawCircle({
            r: options.radius,
            start: sAngle,
            end: eAngle,
            style: grad
        });

        drawCircle({
            r: options.radius - areaStyle.radius,
            style: $transparent
        });
    }

    var drawValueRange = function(valueRange){

        var r = options.radius - areaStyle.radius;

        drawCircle({
            r: r,
            start: sAngle,
            end: valueRange.range,
            style: labelStyle.background
        });

        drawCircle({
            r: r - labelStyle.radius,
            start: sAngle,
            end: valueRange.range,
            style: $transparent
        });

        drawCircle({
            r: r - labelStyle.radius - rangeStyle.width,
            style: $transparent //tqgai
        });
    }

    var fillText = function(opts){
        context.font = opts.font;
        context.fillStyle = opts.color;
        context.textAlign = opts.align || 'center';
        context.textBaseline = opts.vertical || 'middle';
        context.moveTo(opts.x, opts.y);
        context.fillText(opts.text, opts.x, opts.y); 
    }

    var drawInnerContent = function(valueRange, value){
        drawCircle({
            r: innerStyle.radius,
            start: sAngle,
            end: eAngle,
            style: innerStyle.color
        }, 1);

        drawCircle({
            r: innerStyle.radius-1,
            style: $transparent
        });

        var data = options.data;
        
        fillText({
            font: valueStyle.font,
            color: valueStyle.color,
            text: value,
            x: 150,//options.radius,
            y: options.radius + valueStyle.margin
        });

        fillText({
            font: titleStyle.font,
            color: titleStyle.color,
            text: data.title.replace('{t}', data.area[valueRange.index].text).replace('{v}', value),
            x: 150,
            y: options.radius + titleStyle.margin
        });

        fillText({
            font: subTitleStyle.font,
            color: subTitleStyle.color,
            text: data.subTitle,
            x: 150,
            y: options.radius + subTitleStyle.margin
        });
    }

    var drawArrow = function(valueRange){
        var r = options.radius - areaStyle.radius - labelStyle.radius,
            loc = calcLocation(r, valueRange.range),
            x = loc.x - 1,
            y = loc.y + 0.5;

        drawCircle({
            x: x,
            y: y,
            r: rangeStyle.arrow.radius,
            style: rangeStyle.color
        });
        
        var a = calcLocation(r - rangeStyle.arrow.height, valueRange.range),
            b = calcLocation(r, valueRange.range - 0.01),
            c = calcLocation(r, valueRange.range + 0.01);

        context.beginPath();
        context.moveTo(a.x - 1, a.y + 0.5);
        context.lineTo(b.x - 1, b.y + 0.5);
        context.lineTo(c.x - 1, c.y + 0.5);
        context.closePath();
        context.fillStyle = rangeStyle.color;
        context.fill();

        drawCircle({
            x: x,
            y: y,
            r: rangeStyle.arrow.radius - rangeStyle.width,
            style: $transparent
        });
    }

    var drawLine = function(line) {
        context.beginPath();
        context.moveTo(line.start.x, line.start.y);
        context.lineTo(line.end.x, line.end.y);
        context.closePath();
        context.strokeStyle = line.style;
        context.lineWidth = line.width || 1;
        context.stroke();
    }

    var drawTickMarks = function(){
        var scaleLength = areaStyle.scaleLength,
            data = options.data.area,
            len = scaleLength * data.length,
            range = (eAngle - sAngle)/len;

        for(var j = 1; j < len; j++){
            drawLine({
                start: calcLocation(options.radius, sAngle + range * j),
                end: calcLocation(options.radius - areaStyle.radius, sAngle + range * j),
                style: areaStyle.lineColor,
                width: j % scaleLength == 0 ? areaStyle.lineWidth: areaStyle.scaleWidth
            });
        }

        var lblArr = [];
        for(var i = 0; i < data.length; i++){
            var o = data[i];
            // 如果不需兼容IE9以下则不用join
            if(lblArr.join('').indexOf(o.min) == -1) {
                lblArr.push(o.min);
            }
            lblArr.push(o.text);
            lblArr.push(o.max);

        }

        var lblLen = lblArr.length - 1,
            lblRange = (eAngle - sAngle)/lblLen,
            lblOpt = labelStyle,
            lblR = options.radius - areaStyle.radius - lblOpt.radius/2;

        for(var k = 0; k <= lblLen; k++){
            var loc = calcLocation(lblR, sAngle + lblRange * k);
            lblOpt.x = loc.x;
            lblOpt.y = loc.y;
            lblOpt.text = lblArr[k];
            fillText(lblOpt);
        }

    }

    var drawing = function(w, h) {
        var value = options.data.value,
            valueTemp = options.data.area[0].min;

        var timer = setInterval(function(){
            context.clearRect(0, 0, w, h);
            context.fillStyle = $transparent;
            context.fillRect(0, 0, w, h);

            valueTemp = valueTemp + 10 > value ? value: valueTemp + 10;
            var valueRange = calcValueRange(valueTemp);

            drawArea();
            drawValueRange(valueRange);
            drawInnerContent(valueRange, valueTemp);
            drawArrow(valueRange);
            drawTickMarks();

            if(valueTemp === value) {
                clearInterval(timer);
            }
        }, 20);//设置时间
    }

    var exports = {};

    exports.setOptions = function(opts){
        extend(options, opts);

        styles = options.styles;
        sAngle = styles.sAngle;
        eAngle = styles.eAngle;
        areaStyle = styles.area;
        rangeStyle = styles.range;
        valueStyle = styles.value;
        titleStyle = styles.title;
        subTitleStyle = styles.subTitle;
        labelStyle = styles.label;
        innerStyle = styles.inner;

        element = typeof options.element == 'string' ? document.getElementById(options.element) : options.element;
        context = element.getContext('2d');
        return exports;
    };

    exports.init = function(){
        drawing(element.offsetWidth, element.offsetHeight);
        return exports;
    }

    return exports;
})();
