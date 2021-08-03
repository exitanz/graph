import * as d3 from "d3";

export class D3Service {
    sidedata;
    datatip;
    svg;
    width;
    height;
    color;
    simulation;
    Defs;
    figCircle;
    lenCircle;
    spCircle;
    figRect;
    lenRect;
    spRect;
    figEllipse;
    lenEllipse;
    spEllipse;
    figHexagon;
    lenHexagon;
    spHexagon;
    zoom;
    g;

    //Jsonfileのデータを保持
    jsondata;
    constructor() {
        this.sidedata = d3.select("#side_data");

        //カーソルを合わせたときに表示する情報領域
        this.datatip = d3.select("#datatip");

        this.svg = d3
            .select("#view")
            .append("svg")
            .attr("width", 500)
            .attr("height", 400),
            this.width = +this.svg.attr("width"),
            this.height = +this.svg.attr("height");

        this.color = d3.scaleOrdinal(d3.schemeCategory20);

        this.simulation = d3.forceSimulation()
            .velocityDecay(0.3)                                                     //摩擦
            .force('charge', d3.forceManyBody())                                      //詳細設定は後で
            .force('link', d3.forceLink().id(function (d) { return d.id; }))          //詳細設定は後で
            .force('colllision', d3.forceCollide(40))                                 //nodeの衝突半径：Nodeの最大値と同じとする
            .force('positioningX', d3.forceX())                                        //詳細設定は後で
            .force('positioningY', d3.forceY())                                        //詳細設定は後で
            .force('center', d3.forceCenter(this.width / 2, this.height / 2));                  //重力の中心

        //使用するnode図形計上形状定義(中心座標は(0,0))
        this.Defs = this.svg.append("defs")
        //Circle
        this.figCircle = this.Defs.append('circle')
            .attr("id", "circle")
            .attr('r', 20),   //5⇒20
            this.lenCircle = this.figCircle.node().getTotalLength(),
            this.spCircle = this.figCircle.node().getPointAtLength(0);
        //Rect
        this.figRect = this.Defs.append('rect')
            .attr("id", "rect")
            .attr('width', 40)
            .attr('height', 30)
            .attr('rx', 7)  //角を丸める
            .attr('ry', 7)  //角を丸める
            .attr('x', -(40 / 2))  //circleと中心を合わせる
            .attr('y', -(30 / 2)),  //circleと中心を合わせる
            this.lenRect = this.figRect.node().getTotalLength(),
            this.spRect = this.figRect.node().getPointAtLength(0);

        //Ellipse
        this.figEllipse = this.Defs.append('ellipse')
            .attr("id", "ellipse")
            .attr('rx', 30)
            .attr('ry', 20),
            this.lenEllipse = this.figEllipse.node().getTotalLength(),
            this.spEllipse = this.figEllipse.node().getPointAtLength(0);

        // hexagon ※pointsは反時計回りで定義すると他の図形と記述の順番の整合が取れる
        this.figHexagon = this.Defs.append('polygon')
            .attr("id", "hexagon")
            .attr('points', "0,20 -17.3,10 -17.3,-10 0,-20 17.3,-10 17.3,10"),
            this.lenHexagon = this.figHexagon.node().getTotalLength(),
            this.spHexagon = this.figHexagon.node().getPointAtLength(0);

        //"svg"にZoomイベントを設定
        this.zoom = d3.zoom()
            .scaleExtent([1 / 4, 4])
            .on('zoom', this.SVGzoomed);
        this.svg.call(this.zoom);

        //"svg"上に"g"をappend
        this.g = this.svg.append("g");

        d3.json("miserables2.json", function (error, graph) {  //miserables2.jsonに変更
            if (error) throw error;

            //jsondataに値を格納.
            jsondata = graph;

            //Linksの定義
            this.links = this.g.append("g")  //svg⇒gに
                .attr("class", "links")
                .selectAll("g")
                .data(graph.links)
                .enter()
                .append("g")
                .attr("id", "linkArrow")  //外から使用するため、classでは無くidに
                .attr("fill", "#999")
                .attr("stroke", "#999")  //輪郭線の色指定追加
                .on('mouseover', function (d) {
                    d3.select(this).attr('stroke', 'red'); //カーソルが合ったら赤に
                    this.datatip.style("left", d3.event.pageX + 20 + "px")
                        .style("top", d3.event.pageY + 20 + "px")
                        .style("z-index", 0)
                        .style("opacity", 1)
                        .style('background-image', function () {
                            if (typeof d.source.image === "undefined") {
                                if (typeof d.target.image === "undefined") {
                                    return 'url("image/unknown.png"), url("image/unknown.png")'
                                }
                                else {
                                    return 'url("image/unknown.png"), ' + 'url("' + d.target.image + '")'
                                }
                            }
                            else {
                                if (typeof d.target.image === "undefined") {
                                    return 'url("' + d.source.image + '"), ' + 'url("image/unknown.png")'
                                }
                                else {
                                    return 'url("' + d.source.image + '"), url("' + d.target.image + '")'
                                }
                            }
                        });

                    this.datatip.select("h2")
                        .style("border-bottom", "2px solid " + color(d.source.group))
                        .style("margin-right", "50px")
                        .text("value:" + d.value);

                    this.datatip.select("p")
                        .text(d.source.id + " to " + d.target.id);
                })
                .on('mousemove', function () {
                    this.datatip.style("left", d3.event.pageX + 20 + "px")
                        .style("top", d3.event.pageY + 20 + "px")
                })
                .on('mouseout', function () {
                    d3.select(this).attr('stroke', "#999"); //カーソルが外れたら元の色に
                    this.datatip.style("z-index", -1)
                        .style("opacity", 0)
                })
                .call(d3.drag()             //無いとエラーになる。。
                    .on('start', this.dragstarted)
                    .on('drag', this.dragged)
                    .on('end', this.dragended));

            //Markerの定義
            this.marker = links.append("marker")
                .attr("id", function (d) { return "mkr" + d.source + d.target })
                .attr("viewBox", "0 0 20 20")
                .attr("markerWidth", 7)
                .attr("markerHeight", 7)
                .attr("refX", 19)
                .attr("refY", 10)
                .attr("orient", "auto-start-reverse")

            this.marker.append("path")
                .attr("d", "M0.5,0.75L18.88,10L0.5,19.25z")
                .attr("fill", "#ddd")          //背景色と同じ
                .attr("stroke-width", 1)

            //linkの定義
            this.link = this.links.append("path")    //line⇒Path
                //      .attr("stroke","#999")  //輪郭線の色指定追加
                .attr("marker-start", function (d) { return "url(#mkr" + d.source + d.target + ")" })
                .attr("marker-end", function (d) { return "url(#mkr" + d.source + d.target + ")" })
                .attr("fill", "none")    //塗りつぶしなしを追加
                .attr("stroke-width", function (d) { return Math.sqrt(d.value); })
                .attr("stroke-dashoffset", 0)

            // nodeの定義
            this.node = this.g.append('g')
                .attr('class', 'nodes')
                .selectAll('g')
                .data(graph.nodes)
                .enter()
                .append('g')
                .attr('id', 'nodefigure')
                .on('mousedown', this.set_sidedata)
                .call(d3.drag()
                    .on('start', this.dragstarted)
                    .on('drag', this.dragged)
                    .on('end', this.dragended));

            // node 図形の定義
            node.append("use")
                .attr("xlink:href", function (d) { return "#" + this.nodeTypeID(d.group) })        //図形判定
                .attr('stroke', '#ccc')
                .attr('fill', function (d) { return color(d.group); })
                .style('stroke-width', '2')  //線の太さ
                .style('stroke-dasharray', function (d) { return this.stroke_dasharrayCD(d) })  //破線判定
                .on('mouseover', function (d) {
                    d3.select(this).attr('fill', 'red'); //カーソルが合ったら赤に

                    this.datatip.style("left", d3.event.pageX + 20 + "px")
                        .style("top", d3.event.pageY + 20 + "px")
                        .style("z-index", 0)
                        .style("opacity", 1)
                        .style('background-image', function () { if (typeof d.image === "undefined") { return 'url("image/unknown.png")' } else { return 'url("' + d.image + '")' } })

                    this.datatip.select("h2")
                        .style("border-bottom", "2px solid " + color(d.group))
                        .style("margin-right", "0px")
                        .text(d.id);

                    this.datatip.select("p")
                        .text("グループID:" + d.group);
                })
                .on('mousemove', function () {
                    this.datatip.style("left", d3.event.pageX + 20 + "px")
                        .style("top", d3.event.pageY + 20 + "px")
                })
                .on('mouseout', function () {
                    d3.select(this).attr('fill', function (d) { return color(d.group); })  //カーソルが外れたら元の色に

                    this.datatip.style("z-index", -1)
                        .style("opacity", 0)
                })
            //node textの定義
            node.append('text')
                .attr('text-anchor', 'middle')
                .attr('fill', 'black')
                .style('pointer-events', 'none')
                .attr('font-size', function (d) { return '10px'; })
                .attr('font-weight', function (d) { return 'bold'; })
                .text(function (d) { return d.id; });

            //node imageの定義
            node.append('image')
                .attr('xlink:href', function (d) { if (typeof d.image === "undefined") { return "image/unknown.png" } else { return d.image } })
                .attr('width', 30)
                .attr('x', -15)
                .attr('y', -40)

            /*表示がうっとおしいので削除
              node.append("title")
                  .text(function(d) { return "node id:" + d.id; });
            */
            this.simulation
                .nodes(graph.nodes)
                .on("tick", ticked);

            this.simulation.force("link")
                .distance(250) //Link長
                .links(graph.links);

            this.simulation.force('charge')
                .strength(function (d) { return -500 })              //node間の力

            this.simulation.force('positioningX')                      //X方向の中心に向けた引力
                .strength(0.04)

            this.simulation.force('positioningY')                      //Y方向の中心に向けた引力
                .strength(0.04)

            function ticked() {

                link
                    .attr("d", this.linkArc)

                /*
                        .attr("x1", function(d) { return d.source.x; })
                        .attr("y1", function(d) { return d.source.y; })
                        .attr("x2", function(d) { return d.target.x; })
                        .attr("y2", function(d) { return d.target.y; });
                */
                node
                    .attr("cx", function (d) { return d.x; })
                    .attr("cy", function (d) { return d.y; })
                    .attr('transform', function (d) { return 'translate(' + d.x + ',' + d.y + ')' }) //nodesの要素が連動して動くように設定
            }
        });
    }

    clear() {
        this.svg = d3
            .select("#view")
            .selectAll("svg")
            .remove();
    }

    SVGzoomed() {
        this.g.attr("transform", d3.event.transform);
        console.log(d3.event.transform);
        //倍率表示
        d3.select("#r_zoom_text")
            .text((d3.event.transform.k * 100).toFixed(0));  //スライダーの横にある表示を更新
        document.getElementById('rng_zoom').value = Math.log2(d3.event.transform.k).toFixed(1)
    }

    //Sidedataに情報をセット
    set_sidedata(d) {
        //画像表示
        this.sidedata.style("z-index", 0)
            .style("opacity", 1)
            .style('background-image', function () { if (typeof d.image === "undefined") { return 'url("image/unknown.png")' } else { return 'url("' + d.image + '")' } })

        //node名表示
        this.sidedata.select("h3")
            .text(d.id)

        //nodeのメモ表示
        this.sidedata.select("#data_memo")
            .attr("srcdoc", function () {
                if (typeof d.memo === "undefined") {
                    return "<p style='font-size: 11px'></p>"
                }
                else {
                    return "<p style='font-size: 11px'>" + d.memo.replace(/\n/g, "<br>") + "</p>"
                }
            })

        //nodeにつながるLink表示
        this.sidedata.select("#data_relation")
            .attr("srcdoc", function () {
                this.r_value = "",
                    this.r_target = jsondata.links.filter(function (item, index) { if (item.source.id == d.id) return true }),
                    this.r_source = jsondata.links.filter(function (item, index) { if (item.target.id == d.id) return true });
                for (this.key in this.r_target) {
                    this.r_value = this.r_value + "to: " + this.r_target[this.key].target.id + "<br>"
                }
                for (this.key in this.r_source) {
                    this.r_value = this.r_value + "from: " + this.r_source[this.key].source.id + "<br>"
                }
                return "<p style='font-size: 11px'>" + this.r_value + "</p>"
            })
    }

    InputZoom() {
        //Zoom前の初期値を取得
        if (this.g.attr("transform") == null) {
            this.trnsf = "translate(0,0) scale(1)"
        }
        else {
            this.trnsf = this.g.attr("transform")
        }
        this.pre_pos_str = this.this.trnsf.split('(')[1].split(')')[0],
            this.pre_pos = { x: +this.pre_pos_str.split(',')[0], y: +this.pre_pos_str.split(',')[1] },    //Zoom前座標
            this.pre_k = this.trnsf.split('(')[2].split(')')[0],             //Zoom前Scale
            this.pre_c = { x: +(1 - this.pre_k) * this.width / 2, y: +(1 - this.pre_k) * this.height / 2 },    //Zoom前画面センター座標
            this.d_pos = { x: (+this.pre_c.x - this.pre_pos.x) * (1 - this.pre_k), y: (+this.pre_c.y - this.pre_pos.y) * (1 - pre_k) };   //Panで移動した座標


        console.log("pre_pos_str:", this.pre_pos_str);
        console.log("pre_pos:", JSON.stringify(this.pre_pos));
        console.log("pre_k:", this.pre_k);
        console.log("pre_c:", JSON.stringify(this.pre_c));
        console.log("d_pos:", JSON.stringify(this.d_pos));

        this.zoom_scale = Math.pow(2, document.getElementById("rng_zoom").value),  //sliderで指定した倍率
            this.g_c = { x: this.width / 2, y: this.height / 2 },                                        //画面センター（svg座標系）
            //  zoom_c = {x:0,y :0},      //Zoom後の画面センター座標
            this.pos = { x: -this.g_c.x - this.d_pos.x, y: -this.g_c.y - this.d_pos.y }

        console.log("zoom_scale:", this.zoom_scale);
        console.log("svg_c:", JSON.stringify(this.g_c));
        console.log("pos:", JSON.stringify(this.pos));

        this.svg.transition()
            .call(this.zoom.transform, transform);

        function transform() {
            return d3.zoomIdentity
                .translate(this.width / 2, this.height / 2)
                .scale(this.zoom_scale)
                .translate(-this.g_c.x, -this.g_c.y)               //指定nodeの座標
        }
    }

OnClickSearch() {
    this.search_val = document.getElementById("txt_search").value
    if (this.search_val == "") {
        window.alert("検索文字列を入力して下さい")
    }
    else {
        this.search_data = jsondata.nodes.filter(function (d) { if (d.id == this.search_val) return true })[0]
        if (typeof this.search_data === "undefined") {
            window.alert("無効な検索文字列です");
            document.getElementById("txt_search").value = "";
        }
        else {
            //対象先にズームイン
            this.svg.transition()
                .duration(750)
                .call(this.zoom.transform, transform);
            //sidedataにデータを表示
            this.set_sidedata(search_data);

            function transform() {
                return d3.zoomIdentity
                    .translate(this.width / 2, this.height / 2)
                    .scale(4)                             //とりあえず4倍でZoomIn
                    .translate(-this.search_data.x, -this.search_data.y)               //指定nodeの座標
            }
        }
    }
}


UpodateNodeLink() {
    this.linkvalue = document.getElementById("rng_link").value;
    this.nodegroup = document.getElementById("num_group").value;

    d3.select("#r_link_text").text(this.linkvalue);  //スライダーの横にある表示を更新

    if (this.nodegroup == "") {
        //node.group指定がnullのとき
        //全node表示
        d3.selectAll("#nodefigure").attr("display", "inline");

        //Linkは画面設定に従う
        this.linkvalue = document.getElementById("rng_link").value;
        d3.selectAll("#linkArrow").attr("visibility", function (d) {
            if (d.value >= this.linkvalue) { return "visible" } else { return "hidden" }
        })  //各矢印の表示設定を更新
    }
    else {
        //node.group指定がnull以外のとき
        //各nodeの表示設定
        d3.selectAll("#nodefigure").attr("display", function (d) {
            if (d.group == this.nodegroup) { return "inline" } else { return "none" }
        })
        //nodeの表示設定とLinkの表示設定に従うLinkの表示設定
        d3.selectAll("#linkArrow").attr("visibility", function (d) {
            if ((d.source.group == this.nodegroup) && (d.target.group == this.nodegroup) && (d.value >= this.linkvalue)) { return "visible" } else { return "hidden" }
        })  //各矢印の表示設定を更新
    }
}

//破線判定
stroke_dasharrayCD(d) {
    this.arr = [2, 4, 6, 7, 9, 10, 11, 12, 0]
    if (this.arr.indexOf(d.group) >= 0) {
        return "3 2"  //3:2の破線
    }
    else {
        return "none"  //破線なし
    }
}

//図形判定
nodeTypeID(d) {
    this.arrRect = [3, 4]
    this.arrEllipse = [5, 6, 7]
    this.arrHexagon = [9, 10, 11, 12, 0]

    if (this.arrRect.indexOf(d) >= 0) {
        //Rect
        return "rect"
    }
    else if (this.arrEllipse.indexOf(d) >= 0) {
        //Ellipse
        return "ellipse"
    }
    else if (this.arrHexagon.indexOf(d) >= 0) {
        //Hexagon
        return "hexagon"
    }
    else {
        //Circle
        return "circle"
    }
}

linkArc(d) {
    this.dx = d.target.x - d.source.x,
    this.dy = d.target.y - d.source.y,
    this.dr = Math.sqrt(dx * dx + dy * dy),
    this.srcPos = this.getIntersectionPos(d.source, d.target),
    this.tgtPos = this.getIntersectionPos(d.target, d.source);
    return "M" + this.srcPos.x + "," + this.srcPos.y + "A" + this.dr + "," + this.dr + " 0 0,1 " + this.tgtPos.x + "," + this.tgtPos.y;
}

//三点の座標から線の比率を返す
calcLoengthRate(pos1, pos2, pos3) {
    this.v21 = { x: pos1.x - pos2.x, y: pos1.y - pos2.y },
    this.v23 = { x: pos3.x - pos2.x, y: pos3.y - pos2.y },
    this.x = v21.x * v23.x + v21.y * v23.y,    //v21・v23
    this.y = v21.x * v23.y - v21.y * v23.x,    //v21×v23
    this.theta = Math.atan2(this.y, this.x); //角度（radian）
    if (this.theta > 0) {
        return this.theta / (2 * Math.PI);
    }
    else {
        return 1 + this.theta / (2 * Math.PI);
    };
}

//node図形とlinkの交点座標を取得(d1側の座標)
getIntersectionPos(d1, d2) {
    this.nodeID = this.nodeTypeID(d1.group);
    switch (nodeID) {
        case "rect":
            this.pos1 = { x: d1.x + this.spRect.x, y: d1.y + this.spRect.y },
            this.pos2 = { x: d1.x, y: d1.y },
            this.pos3 = { x: d2.x, y: d2.y },
            this.rate = this.calcLoengthRate(this.pos1, this.pos2, this.pos3),
            this.dpos = this.figRect.node().getPointAtLength(this.lenRect * this.rate);
            return { x: d1.x + this.dpos.x, y: d1.y + this.dpos.y }
            break;
        case "ellipse":
            this.pos1 = { x: d1.x + this.spEllipse.x, y: d1.y + this.spEllipse.y },
            this.pos2 = { x: d1.x, y: d1.y },
            this.pos3 = { x: d2.x, y: d2.y },
            this.rate = this.calcLoengthRate(this.pos1, this.pos2, this.pos3),
            this.dpos = this.figEllipse.node().getPointAtLength(this.lenEllipse * this.rate);
            return { x: d1.x + this.dpos.x, y: d1.y + this.dpos.y }
            break;
        case "hexagon":
            this.pos1 = { x: d1.x + this.spHexagon.x, y: d1.y + this.spHexagon.y },
            this.pos2 = { x: d1.x, y: d1.y },
            this.pos3 = { x: d2.x, y: d2.y },
            this.rate = this.calcLoengthRate(this.pos1, this.pos2, this.pos3),
            this.dpos = this.figHexagon.node().getPointAtLength(this.lenHexagon * this.rate);
            return { x: d1.x + this.dpos.x, y: d1.y + this.dpos.y }
            break;
        default:
            this.pos1 = { x: d1.x + this.spCircle.x, y: d1.y + this.spCircle.y },
            this.pos2 = { x: d1.x, y: d1.y },
            this.pos3 = { x: d2.x, y: d2.y },
            this.rate = this.calcLoengthRate(this.pos1, this.pos2, this.pos3),
                this.dpos = this.figCircle.node().getPointAtLength(this.lenCircle * this.rate);
            return { x: d1.x + this.dpos.x, y: d1.y + this.dpos.y }
    }
}

dragstarted(d) {
    if (!d3.event.active) this.simulation.alphaTarget(0.3).restart();
    d.fx = d.x;
    d.fy = d.y;
}

dragged(d) {
    d.fx = d3.event.x;
    d.fy = d3.event.y;
}

dragended(d) {
    if (!d3.event.active) this.simulation.alphaTarget(0);
    d.fx = null;
    d.fy = null;
}



}
