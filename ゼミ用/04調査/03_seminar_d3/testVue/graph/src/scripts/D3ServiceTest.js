import * as d3 from "d3";

export class D3Service {
    // static init(graph) {
    //     D3Service.init(graph, "view");
    // }
    
    static init(graph, selectName = "view") {

        var sidedata = d3.select("#side_data");

        //カーソルを合わせたときに表示する情報領域
        var datatip = d3.select("#datatip");

        var svg = d3
            .select('#' + selectName)
            .append("svg")
            .attr("width", 1000)
            .attr("height", 500),
            width = +svg.attr("width"),
            height = +svg.attr("height");

        var color = d3.scaleOrdinal(d3.schemeCategory20);

        var simulation = d3.forceSimulation()
            .velocityDecay(0.3)                                                     //摩擦
            .force('charge', d3.forceManyBody())                                      //詳細設定は後で
            .force('link', d3.forceLink().id(function (d) { return d.id; }))          //詳細設定は後で
            .force('colllision', d3.forceCollide(40))                                 //nodeの衝突半径：Nodeの最大値と同じとする
            .force('positioningX', d3.forceX())                                        //詳細設定は後で
            .force('positioningY', d3.forceY())                                        //詳細設定は後で
            .force('center', d3.forceCenter(width / 2, height / 2));                  //重力の中心

        //使用するnode図形計上形状定義(中心座標は(0,0))
        var Defs = svg.append("defs")
        //Circle
        var figCircle = Defs.append('circle')
            .attr("id", "circle")
            .attr('r', 20),   //5⇒20
            lenCircle = figCircle.node().getTotalLength(),
            spCircle = figCircle.node().getPointAtLength(0);
        //Rect
        var figRect = Defs.append('rect')
            .attr("id", "rect")
            .attr('width', 40)
            .attr('height', 30)
            .attr('rx', 7)  //角を丸める
            .attr('ry', 7)  //角を丸める
            .attr('x', -(40 / 2))  //circleと中心を合わせる
            .attr('y', -(30 / 2)),  //circleと中心を合わせる
            lenRect = figRect.node().getTotalLength(),
            spRect = figRect.node().getPointAtLength(0);

        //Ellipse
        var figEllipse = Defs.append('ellipse')
            .attr("id", "ellipse")
            .attr('rx', 30)
            .attr('ry', 20),
            lenEllipse = figEllipse.node().getTotalLength(),
            spEllipse = figEllipse.node().getPointAtLength(0);

        // hexagon ※pointsは反時計回りで定義すると他の図形と記述の順番の整合が取れる
        var figHexagon = Defs.append('polygon')
            .attr("id", "hexagon")
            .attr('points', "0,20 -17.3,10 -17.3,-10 0,-20 17.3,-10 17.3,10"),
            lenHexagon = figHexagon.node().getTotalLength(),
            spHexagon = figHexagon.node().getPointAtLength(0);

        //"svg"にZoomイベントを設定
        var zoom = d3.zoom()
            .scaleExtent([1 / 4, 4])
            .on('zoom', SVGzoomed);
        svg.call(zoom);

        //"svg"上に"g"をappend
        var g = svg.append("g");

        //Linksの定義
        var links = g.append("g")  //svg⇒gに
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
                datatip.style("left", d3.event.pageX + 20 + "px")
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

                datatip.select("h2")
                    .style("border-bottom", "2px solid " + color(d.source.group))
                    .style("margin-right", "50px")
                    .text("value:" + d.value);

                datatip.select("p")
                    .text(d.source.id + " to " + d.target.id);
            })
            .on('mousemove', function () {
                datatip.style("left", d3.event.pageX + 20 + "px")
                    .style("top", d3.event.pageY + 20 + "px")
            })
            .on('mouseout', function () {
                d3.select(this).attr('stroke', "#999"); //カーソルが外れたら元の色に
                datatip.style("z-index", -1)
                    .style("opacity", 0)
            })
            .call(d3.drag()             //無いとエラーになる。。
                .on('start', dragstarted)
                .on('drag', dragged)
                .on('end', dragended));

        //Markerの定義
        var marker = links.append("marker")
            .attr("id", function (d) { return "mkr" + d.source + d.target })
            .attr("viewBox", "0 0 20 20")
            .attr("markerWidth", 7)
            .attr("markerHeight", 7)
            .attr("refX", 19)
            .attr("refY", 10)
            .attr("orient", "auto-start-reverse")

        marker.append("path")
            .attr("d", "M0.5,0.75L18.88,10L0.5,19.25z")
            .attr("fill", "#ddd")          //背景色と同じ
            .attr("stroke-width", 1)

        //linkの定義
        var link = links.append("path")    //line⇒Path
            //      .attr("stroke","#999")  //輪郭線の色指定追加
            .attr("marker-start", function (d) { return "url(#mkr" + d.source + d.target + ")" })
            .attr("marker-end", function (d) { return "url(#mkr" + d.source + d.target + ")" })
            .attr("fill", "none")    //塗りつぶしなしを追加
            .attr("stroke-width", function (d) { return Math.sqrt(d.value); })
            .attr("stroke-dashoffset", 0)

        // nodeの定義
        var node = g.append('g')
            .attr('class', 'nodes')
            .selectAll('g')
            .data(graph.nodes)
            .enter()
            .append('g')
            .attr('id', 'nodefigure')
            .on('mousedown', set_sidedata)
            .call(d3.drag()
                .on('start', dragstarted)
                .on('drag', dragged)
                .on('end', dragended));

        // node 図形の定義
        node.append("use")
            .attr("xlink:href", function (d) { return "#" + nodeTypeID(d.group) })        //図形判定
            .attr('stroke', '#ccc')
            .attr('fill', function (d) { return color(d.group); })
            .style('stroke-width', '2')  //線の太さ
            .style('stroke-dasharray', function (d) { return stroke_dasharrayCD(d) })  //破線判定
            .on('mouseover', function (d) {
                d3.select(this).attr('fill', 'red'); //カーソルが合ったら赤に

                datatip.style("left", d3.event.pageX + 20 + "px")
                    .style("top", d3.event.pageY + 20 + "px")
                    .style("z-index", 0)
                    .style("opacity", 1)
                    .style('background-image', function () { if (typeof d.image === "undefined") { return 'url("image/unknown.png")' } else { return 'url("' + d.image + '")' } })

                datatip.select("h2")
                    .style("border-bottom", "2px solid " + color(d.group))
                    .style("margin-right", "0px")
                    .text(d.id);

                datatip.select("p")
                    .text("グループID:" + d.group);
            })
            .on('mousemove', function () {
                datatip.style("left", d3.event.pageX + 20 + "px")
                    .style("top", d3.event.pageY + 20 + "px")
            })
            .on('mouseout', function () {
                d3.select(this).attr('fill', function (d) { return color(d.group); })  //カーソルが外れたら元の色に

                datatip.style("z-index", -1)
                    .style("opacity", 0)
            })
        //node textの定義
        node.append('text')
            .attr('text-anchor', 'middle')
            .attr('fill', 'black')
            .style('pointer-events', 'none')
            .attr('font-size', function () { return '10px'; })
            .attr('font-weight', function () { return 'bold'; })
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
        simulation
            .nodes(graph.nodes)
            .on("tick", ticked);

        simulation.force("link")
            .distance(250) //Link長
            .links(graph.links);

        simulation.force('charge')
            .strength(function () { return -500 })              //node間の力

        simulation.force('positioningX')                      //X方向の中心に向けた引力
            .strength(0.04)

        simulation.force('positioningY')                      //Y方向の中心に向けた引力
            .strength(0.04)

        function ticked() {

            link
                .attr("d", linkArc)

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


        function SVGzoomed() {
            g.attr("transform", d3.event.transform);
            //倍率表示
            d3.select("#r_zoom_text")
                .text((d3.event.transform.k * 100).toFixed(0));  //スライダーの横にある表示を更新
            // document.getElementById('rng_zoom').value = Math.log2(d3.event.transform.k).toFixed(1)
        }

        //Sidedataに情報をセット
        function set_sidedata(d) {
            //画像表示
            sidedata.style("z-index", 0)
                .style("opacity", 1)
                .style('background-image', function () { if (typeof d.image === "undefined") { return 'url("image/unknown.png")' } else { return 'url("' + d.image + '")' } });

            //node名表示
            sidedata.select("h3")
                .text(d.id);

            //nodeのメモ表示
            sidedata.select("#data_memo")
                .attr("srcdoc", function () {
                    if (typeof d.memo === "undefined") {
                        return "<p style='font-size: 11px'></p>"
                    }
                    else {
                        return "<p style='font-size: 11px'>" + d.memo.replace(/\n/g, "<br>") + "</p>"
                    }
                });

            //nodeにつながるLink表示
            sidedata.select("#data_relation")
                .attr("srcdoc", function () {
                    var r_value = "",
                        r_target = graph.links.filter(function (item) { if (item.source.id == d.id) return true }),
                        r_source = graph.links.filter(function (item) { if (item.target.id == d.id) return true });
                    for (let key in r_target) {
                        r_value = r_value + "to: " + r_target[key].target.id + "<br>"
                    }
                    for (let key in r_source) {
                        r_value = r_value + "from: " + r_source[key].source.id + "<br>"
                    }
                    return "<p style='font-size: 11px'>" + r_value + "</p>"
                });
        }

        // function InputZoom() {
        //     //Zoom前の初期値を取得
        //     if (g.attr("transform") == null) {
        //         var trnsf = "translate(0,0) scale(1)"
        //     }
        //     else {
        //         var trnsf = g.attr("transform")
        //     }
        //     var pre_pos_str = trnsf.split('(')[1].split(')')[0],
        //         pre_pos = { x: +pre_pos_str.split(',')[0], y: +pre_pos_str.split(',')[1] },    //Zoom前座標
        //         pre_k = trnsf.split('(')[2].split(')')[0],             //Zoom前Scale
        //         pre_c = { x: +(1 - pre_k) * width / 2, y: +(1 - pre_k) * height / 2 },    //Zoom前画面センター座標
        //         d_pos = { x: (+pre_c.x - pre_pos.x) * (1 - pre_k), y: (+pre_c.y - pre_pos.y) * (1 - pre_k) };   //Panで移動した座標


        //     console.log("pre_pos_str:", pre_pos_str);
        //     console.log("pre_pos:", JSON.stringify(pre_pos));
        //     console.log("pre_k:", pre_k);
        //     console.log("pre_c:", JSON.stringify(pre_c));
        //     console.log("d_pos:", JSON.stringify(d_pos));

        //     var zoom_scale = Math.pow(2, document.getElementById("rng_zoom").value),  //sliderで指定した倍率
        //         g_c = { x: width / 2, y: height / 2 },                                        //画面センター（svg座標系）
        //         //  zoom_c = {x:0,y :0},      //Zoom後の画面センター座標
        //         pos = { x: -g_c.x - d_pos.x, y: -g_c.y - d_pos.y }

        //     console.log("zoom_scale:", zoom_scale);
        //     console.log("svg_c:", JSON.stringify(g_c));
        //     console.log("pos:", JSON.stringify(pos));

        //     svg.transition()
        //         .call(zoom.transform, transform);

        //     function transform() {
        //         return d3.zoomIdentity
        //             .translate(width / 2, height / 2)
        //             .scale(zoom_scale)
        //             .translate(-g_c.x, -g_c.y)               //指定nodeの座標
        //     }
        // }

        // function OnClickSearch() {
        //     var search_val = document.getElementById("txt_search").value
        //     if (search_val == "") {
        //         window.alert("検索文字列を入力して下さい")
        //     }
        //     else {
        //         var search_data = graph.nodes.filter(function (d) { if (d.id == search_val) return true })[0]
        //         if (typeof search_data === "undefined") {
        //             window.alert("無効な検索文字列です");
        //             document.getElementById("txt_search").value = "";
        //         }
        //         else {
        //             //対象先にズームイン
        //             svg.transition()
        //                 .duration(750)
        //                 .call(zoom.transform, transform);
        //             //sidedataにデータを表示
        //             set_sidedata(search_data);

        //             function transform() {
        //                 return d3.zoomIdentity
        //                     .translate(width / 2, height / 2)
        //                     .scale(4)                             //とりあえず4倍でZoomIn
        //                     .translate(-search_data.x, -search_data.y)               //指定nodeの座標
        //             }
        //         }
        //     }
        // }


        // function UpodateNodeLink() {
        //     var linkvalue = document.getElementById("rng_link").value;
        //     var nodegroup = document.getElementById("num_group").value;

        //     d3.select("#r_link_text").text(linkvalue);  //スライダーの横にある表示を更新

        //     if (nodegroup == "") {
        //         //node.group指定がnullのとき
        //         //全node表示
        //         d3.selectAll("#nodefigure").attr("display", "inline");

        //         //Linkは画面設定に従う
        //         var linkvalue = document.getElementById("rng_link").value;
        //         d3.selectAll("#linkArrow").attr("visibility", function (d) {
        //             if (d.value >= linkvalue) { return "visible" } else { return "hidden" }
        //         })  //各矢印の表示設定を更新
        //     }
        //     else {
        //         //node.group指定がnull以外のとき
        //         //各nodeの表示設定
        //         d3.selectAll("#nodefigure").attr("display", function (d) {
        //             if (d.group == nodegroup) { return "inline" } else { return "none" }
        //         })
        //         //nodeの表示設定とLinkの表示設定に従うLinkの表示設定
        //         d3.selectAll("#linkArrow").attr("visibility", function (d) {
        //             if ((d.source.group == nodegroup) && (d.target.group == nodegroup) && (d.value >= linkvalue)) { return "visible" } else { return "hidden" }
        //         })  //各矢印の表示設定を更新
        //     }
        // }

        //破線判定
        function stroke_dasharrayCD(d) {
            var arr = [2, 4, 6, 7, 9, 10, 11, 12, 0]
            if (arr.indexOf(d.group) >= 0) {
                return "3 2"  //3:2の破線
            }
            else {
                return "none"  //破線なし
            }
        }

        //図形判定
        function nodeTypeID(d) {
            var arrRect = [3, 4]
            var arrEllipse = [5, 6, 7]
            var arrHexagon = [9, 10, 11, 12, 0]

            if (arrRect.indexOf(d) >= 0) {
                //Rect
                return "rect"
            }
            else if (arrEllipse.indexOf(d) >= 0) {
                //Ellipse
                return "ellipse"
            }
            else if (arrHexagon.indexOf(d) >= 0) {
                //Hexagon
                return "hexagon"
            }
            else {
                //Circle
                return "circle"
            }
        }

        function linkArc(d) {
            var dx = d.target.x - d.source.x,
                dy = d.target.y - d.source.y,
                dr = Math.sqrt(dx * dx + dy * dy),
                srcPos = getIntersectionPos(d.source, d.target),
                tgtPos = getIntersectionPos(d.target, d.source);
            return "M" + srcPos.x + "," + srcPos.y + "A" + dr + "," + dr + " 0 0,1 " + tgtPos.x + "," + tgtPos.y;
        }

        //三点の座標から線の比率を返す
        function calcLoengthRate(pos1, pos2, pos3) {
            var v21 = { x: pos1.x - pos2.x, y: pos1.y - pos2.y },
                v23 = { x: pos3.x - pos2.x, y: pos3.y - pos2.y },
                x = v21.x * v23.x + v21.y * v23.y,    //v21・v23
                y = v21.x * v23.y - v21.y * v23.x,    //v21×v23
                theta = Math.atan2(y, x); //角度（radian）
            if (theta > 0) {
                return theta / (2 * Math.PI);
            }
            else {
                return 1 + theta / (2 * Math.PI);
            }
        }

        //node図形とlinkの交点座標を取得(d1側の座標)
        function getIntersectionPos(d1, d2) {
            var nodeID = nodeTypeID(d1.group);
            let pos1,
                pos2,
                pos3,
                rate,
                dpos;
                try {
                    switch (nodeID) {
                        case "rect":
                            pos1 = { x: d1.x + spRect.x, y: d1.y + spRect.y };
                            pos2 = { x: d1.x, y: d1.y };
                            pos3 = { x: d2.x, y: d2.y };
                            rate = calcLoengthRate(pos1, pos2, pos3);
                            dpos = figRect.node().getPointAtLength(lenRect * rate);
        
                            break;
                        case "ellipse":
                            pos1 = { x: d1.x + spEllipse.x, y: d1.y + spEllipse.y };
                            pos2 = { x: d1.x, y: d1.y };
                            pos3 = { x: d2.x, y: d2.y };
                            rate = calcLoengthRate(pos1, pos2, pos3);
                            dpos = figEllipse.node().getPointAtLength(lenEllipse * rate);
        
                            break;
                        case "hexagon":
                            pos1 = { x: d1.x + spHexagon.x, y: d1.y + spHexagon.y };
                            pos2 = { x: d1.x, y: d1.y };
                            pos3 = { x: d2.x, y: d2.y };
                            rate = calcLoengthRate(pos1, pos2, pos3);
                            dpos = figHexagon.node().getPointAtLength(lenHexagon * rate);
        
                            break;
                        default:
                            pos1 = { x: d1.x + spCircle.x, y: d1.y + spCircle.y };
                            pos2 = { x: d1.x, y: d1.y };
                            pos3 = { x: d2.x, y: d2.y };
                            rate = calcLoengthRate(pos1, pos2, pos3);
                            dpos = figCircle.node().getPointAtLength(lenCircle * rate);
        
                            break;
                    }
                  } catch (error) {
                    console.error(error);
                  }
            return { x: d1.x + dpos.x, y: d1.y + dpos.y }
        }

        function dragstarted(d) {
            if (!d3.event.active) simulation.alphaTarget(0.3).restart();
            d.fx = d.x;
            d.fy = d.y;
        }

        function dragged(d) {
            d.fx = d3.event.x;
            d.fy = d3.event.y;
        }

        function dragended(d) {
            if (!d3.event.active) simulation.alphaTarget(0);
            d.fx = null;
            d.fy = null;
        }

    }

    static clear() {
        this.svg = d3
            .select("#view")
            .selectAll("svg")
            .remove();
    }

}
