
//Prototype Objet

WowGraph = Class.create();
WowGraph.prototype = {
    width : 700,
    height : 400,
    leftgutter : 30,
    bottomgutter : 20,
    topgutter : 20,
    colorhue : 0.0,
    color : "",
    color2 : "",
    r : null,
    txt : null,
    txt1 : null,
    txt2 : null,
    X : 0,
    max : 0,
    min : 0,
    Y : 0,
    worldCenter:null,
    initialize:function(element,center){
        this.worldCenter = center;
        this.colorhue = .6 || Math.random();
        this.color = "hsl(" + [this.colorhue, .5, .5] + ")";
        this.color2 = "rgb(220,15,15)";
        this.r = new Raphael(element, this.width, this.height);
        this.txt = {font: '12px Helvetica, Arial', fill: "#fff"};
        this.txt1 = {font: '10px Helvetica, Arial', fill: "#fff"};
        this.txt2 = {font: '12px Helvetica, Arial', fill: "#000"};
       
    },
    drawGraph:function(data,data2, dataname1,dataname2){
        //this.r.clear();
        this.X = (this.width - this.leftgutter) / data.length;
        m1 = Math.max.apply(Math, data);
        m2 = Math.max.apply(Math, data2);
        this.max = m1>m2?m1:m2;
        m1 = Math.min.apply(Math, data);
        m2 = Math.min.apply(Math, data2);
        this.min = m1<m2?m1:m2;
        this.Y = (this.height - this.bottomgutter - this.topgutter) / (this.max + Math.abs(this.min));

        this.drawGrid(this.leftgutter + this.X * .5 + .5, this.topgutter + .5, this.width - this.leftgutter - this.X, this.height - this.topgutter - this.bottomgutter, "#000");

        this.drawOrigen(this.leftgutter + this.X * .5 + .5, this.topgutter + .5, this.width - this.leftgutter - this.X, this.height - this.topgutter - this.bottomgutter, this.Y, this.min, this.max);
        
        var path = this.r.path().attr({stroke: this.color, "stroke-this.width": 4, "stroke-linejoin": "round"}),
        
        path2 = this.r.path().attr({stroke: this.color2, "stroke-this.width": 4, "stroke-linejoin": "round"}),
        
        bgp = this.r.path().attr({stroke: "none", opacity: .3, fill: this.color}),
        label = this.r.set(),
        lx = 0, ly = 0,
        is_label_visible = false,
        leave_timer,
        blanket = this.r.set();
        label.push(this.r.text(60, 12, "24 hits").attr(this.txt));
        label.push(this.r.text(60, 27, "22 September 2008").attr(this.txt1).attr({fill: this.color}));
        label.hide();
        var frame = this.r.popup(100, 100, label, "right").attr({fill: "#000", stroke: "#666", "stroke-this.width": 2, "fill-opacity": .7}).hide();
        //t = this.r.text(this.X-20, this.height - 6, "T").attr(this.txt2).toBack();
        var p,p2;
        for (var i = 0, ii = data.length; i < ii; i++) {
            var y = Math.round(this.height - this.bottomgutter - this.Y * data[i]) + (this.min<0?(this.min*this.Y):0),
                x = Math.round(this.leftgutter + this.X * (i + .5)),
                t = this.r.text(x, this.height - 6, i).attr(this.txt2).toBack();

                var y2 = Math.round(this.height - this.bottomgutter - this.Y * data2[i]) + (this.min<0?(this.min*this.Y):0);
            
            if (!i) {
                p = ["M", x, y, "L"];
                p2 = ["M", x, y2, "L"];
            }
            if (i && i < ii - 1) {
                p = p.concat([x, y]);
                p2 = p2.concat([x, y2]);
            }
            var dot = this.r.circle(x, y, 4).attr({fill: "#333", stroke: this.color, "stroke-width": 2});
            var dot2 = this.r.circle(x, y2, 4).attr({fill: "#333", stroke: this.color2, "stroke-width": 2});
            blanket.push(this.r.rect(this.leftgutter + this.X * i, 0, this.X, this.height - this.bottomgutter).attr({stroke: "none", fill: "#fff", opacity: 0}));
            var rect = blanket[blanket.length - 1];
            var that = this;
            (function (x, y, data, lbl, dot,data2) {
                var timer, i = 0;
                rect.hover(function () {
                    clearTimeout(leave_timer);
                    var side = "right";
                    if (x + frame.getBBox().width > that.width) {
                        side = "left";
                    }
                    var ppp = that.r.popup(x, y, label, side, 1),
                        anim = Raphael.animation({
                            path: ppp.path,
                            transform: ["t", ppp.dx, ppp.dy]
                        }, 200 * is_label_visible);
                    lx = label[0].transform()[0][1] + ppp.dx;
                    ly = label[0].transform()[0][2] + ppp.dy;
                    frame.show().stop().animate(anim);
                    label[0].attr({text: " X: " + data +" y: "+data2 }).show().stop().animateWith(frame, anim, {transform: ["t", lx, ly]}, 200 * is_label_visible);
                    label[1].attr({text: lbl + " Timpo: "+i+" seg." }).show().stop().animateWith(frame, anim, {transform: ["t", lx, ly]}, 200 * is_label_visible);
                    dot.attr("r", 6);
                    is_label_visible = true;
                }, function () {
                    dot.attr("r", 4);
                    leave_timer = setTimeout(function () {
                        frame.hide();
                        label[0].hide();
                        label[1].hide();
                        is_label_visible = false;
                    }, 1);
                });
            })(x, y, data[i] , i, dot, data2[i]);
        }
        p = p.concat([x, y, x, y]);
        p2 = p2.concat([x, y2, x, y2]);
        path.attr({path: p});
        path2.attr({path: p2});
        frame.toFront();
        label[0].toFront();
        label[1].toFront();
        blanket.toFront();
    },
    drawGrid:function (x, y, w, h, color) {
        color = color || "#000";
        var path = [
            "M", Math.round(x) + .5, Math.round(y) + .5, 
            "L", Math.round(x) + .5, Math.round(y + h) + .5];
        
        this.r.path(path.join(",")).attr({stroke: color});
        t = this.r.text(x-25, y+h , "Tiempo").attr(this.txt2).toBack();
        var path = [
            "M", Math.round(x) + .5, Math.round(y + h) + .5, 
            "L", Math.round(x + w) + .5, Math.round(y+h) + .5
            ];

        return this.r.path(path.join(",")).attr({stroke: color});
    },
    drawOrigen:function (x, y, w, h,Y, min, max) {
        if(min<0){
            y += (h) + (min*Y);
            t = this.r.text(x-25, y , "Origen").attr(this.txt2).toBack();
            var path = [
                "M", Math.round(x) + .5, Math.round(y) + .5, 
                "L", Math.round(x + w) + .5, Math.round(y) + .5];
            
            return this.r.path(path.join(",")).attr({stroke: "red"});
        }
    }
}

/**/