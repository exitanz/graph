var sidedata = d3.select("#side_data"); //id=side_data(rel_diagram_view_test.php)
var sidedataimg = d3.select("#side_data_img"); //id=side_data_img(rel_diagram_view_test.php)
var datatip = d3.select("#datatip");//datatip

var svg = d3.select("svg"),
  width = +svg.attr("width"),
  height = +svg.attr("height");

var color = d3.scaleOrdinal(d3.schemeCategory20);

var simulation = d3
  .forceSimulation()
  .velocityDecay(0.3)
  .force("charge", d3.forceManyBody())
  .force(
    "link",
    d3.forceLink().id(function (d) {
      return d.id;
    })
  )
  .force("colllision", d3.forceCollide(40))
  .force("positioningX", d3.forceX())
  .force("positioningY", d3.forceY())
  .force("center", d3.forceCenter(width / 2, height / 2));

var Defs = svg.append("defs");
var figCircle = Defs.append("circle").attr("id", "circle").attr("r", 20),
  lenCircle = figCircle.node().getTotalLength(),
  spCircle = figCircle.node().getPointAtLength(0);
var figRect = Defs.append("rect")
  .attr("id", "rect")
  .attr("width", 40)
  .attr("height", 30)
  .attr("rx", 7)
  .attr("ry", 7)
  .attr("x", -(40 / 2))
  .attr("y", -(30 / 2)),
  lenRect = figRect.node().getTotalLength(),
  spRect = figRect.node().getPointAtLength(0);

var figEllipse = Defs.append("ellipse")
  .attr("id", "ellipse")
  .attr("rx", 30)
  .attr("ry", 20),
  lenEllipse = figEllipse.node().getTotalLength(),
  spEllipse = figEllipse.node().getPointAtLength(0);

var figHexagon = Defs.append("polygon")
  .attr("id", "hexagon")
  .attr("points", "0,20 -17.3,10 -17.3,-10 0,-20 17.3,-10 17.3,10"),
  lenHexagon = figHexagon.node().getTotalLength(),
  spHexagon = figHexagon.node().getPointAtLength(0);

var zoom = d3
  .zoom()
  .scaleExtent([1 / 4, 4])
  .on("zoom", SVGzoomed);

svg.call(zoom);

var g = svg.append("g").call(d3.drag().on("drag", SVGdragged));

function SVGzoomed() {
  g.attr("transform", d3.event.transform);
}

function SVGdragged(d) {
  d3.select(this)
    .attr("cx", (d.x = d3.event.x))
    .attr("cy", (d.y = d3.event.y));
}

var jsondata;

d3.json("./lib/json/miserables_test.json", function (error, graph) {
  if (error) throw error;

  var links = g
    .append("g")
    .attr("class", "links")
    .selectAll("g")
    .data(graph.links)
    .enter()
    .append("g")
    .attr("class", "linkArrow")
    .attr("fill", "#999")
    .attr("stroke", "#999")
    //---------------mouseover----------------
    .on("mouseover", function (d) {
      d3.select(this).attr("stroke", "red"); //色を赤に変える
      datatip
        .style("left", d3.event.pageX + 20 + "px")
        .style("top", d3.event.pageY + 20 + "px")
        .style("z-index", 0)
        .style("opacity", 1)
        //------------image--------------
        .style("background-image", function () {
          if (typeof d.source.image === "undefined") { //souce.imageがなかったら
            if (typeof d.target.image === "undefined") { //target.imageがなかったら
              return 'url("image/unknown.png"), url("image/unknown.png")'; //imageはunknown.pngにする
            } else {
              return (
                'url("image/unknown.png"), ' + 'url("' + d.target.image + '")' //target.imageのみ表示
              );
            }
          } else {
            if (typeof d.target.image === "undefined") { //target.imageがなかったら
              return (
                'url("' + d.source.image + '"), ' + 'url("image/unknown.png")' //source.imageのみ表示
              );
            } else {
              return (
                'url("' + d.source.image + '"), url("' + d.target.image + '")' //source.image、target.image共に表示
              );
            }
          }
        });

      datatip
        .select("h2")
        .style("border-bottom", "2px solid " + color(d.source.group))
        .style("margin-right", "120px")
        .text("value:" + d.value);

      datatip.select("p").text(d.source.id + " to " + d.target.id); //text欄souce.id(名前)to+target.id(名前)
    })
    .on("mousemove", function () {
      datatip
        .style("left", d3.event.pageX + 20 + "px")
        .style("top", d3.event.pageY + 20 + "px");
    })
    .on("mouseout", function () {
      d3.select(this).attr("stroke", "#999");
      datatip.style("z-index", -1).style("opacity", 0);
    })
    .call(
      d3
        .drag()
        .on("start", dragstarted)
        .on("drag", dragged)
        .on("end", dragended)
    );

  var marker = links
    .append("marker")
    .attr("id", function (d) {
      return "mkr" + d.source + d.target;
    })
    .attr("viewBox", "0 0 20 20")
    .attr("markerWidth", 7)
    .attr("markerHeight", 7)
    .attr("refX", 19)
    .attr("refY", 10)
    .attr("orient", "auto-start-reverse");

  marker
    .append("path")
    .attr("d", "M0.5,0.75L18.88,10L0.5,19.25z")
    .attr("fill", "#ddd")
    .attr("stroke-width", 1);

  var link = links
    .append("path")
    .attr("marker-start", function (d) {
      return "url(#mkr" + d.source + d.target + ")";
    })
    .attr("marker-end", function (d) {
      return "url(#mkr" + d.source + d.target + ")";
    })
    .attr("fill", "none")
    .attr("stroke-width", function (d) {
      return Math.sqrt(d.value);
    })
    .attr("stroke-dashoffset", 0);

  var node = g
    .append("g")
    .attr("class", "nodes")
    .selectAll("g")
    .data(graph.nodes)
    .enter()
    .append("g")
    .on("mousedown", set_sidedata)
    .call(
      d3
        .drag()
        .on("start", dragstarted)
        .on("drag", dragged)
        .on("end", dragended)
    );

  node
    .append("use")
    .attr("xlink:href", function (d) {
      return "#" + nodeTypeID(d.group);
    })
    .attr("stroke", "#ccc")
    .attr("fill", function (d) {
      return color(d.group);
    })
    .style("stroke-width", "2")
    .style("stroke-dasharray", function (d) {
      return stroke_dasharrayCD(d);
    })
    .on("mouseover", function (d) {
      d3.select(this).attr("fill", "red");

      datatip
        .style("left", d3.event.pageX + 20 + "px")
        .style("top", d3.event.pageY + 20 + "px")
        .style("z-index", 0)
        .style("opacity", 1)
        .style("background-image", function () {
          if (typeof d.image === "undefined") {
            return 'url("image/unknown.png")';
          } else {
            return 'url("' + d.image + '")';
          }
        });

      datatip
        .select("h2")
        .style("border-bottom", "2px solid " + color(d.group))
        .style("margin-right", "0px")
        .text(d.id);

      datatip.select("p").text("グループID:" + d.group);
    })
    .on("mousemove", function () {
      datatip
        .style("left", d3.event.pageX + 20 + "px")
        .style("top", d3.event.pageY + 20 + "px");
    })
    .on("mouseout", function () {
      d3.select(this).attr("fill", function (d) {
        return color(d.group);
      });

      datatip.style("z-index", -1).style("opacity", 0);
    });
  node
    .append("text")
    .attr("text-anchor", "middle")
    .attr("fill", "black")
    .style("pointer-events", "none")
    .attr("font-size", function (d) {
      return "10px";
    })
    .attr("font-weight", function (d) {
      return "bold";
    })
    .text(function (d) {
      return d.id;
    });

  node
    .append("image")
    .attr("xlink:href", function (d) {
      if (typeof d.image === "undefined") {
        return "image/unknown.png";
      } else {
        return d.image;
      }
    })
    .attr("width", 30)
    .attr("x", -15)
    .attr("y", -40);

  simulation.nodes(graph.nodes).on("tick", ticked);

  simulation
    .force("link")
    .distance(250)
    .links(graph.links);

  simulation.force("charge").strength(function (d) {
    return -500;
  });

  simulation
    .force("positioningX")
    .strength(0.04);

  simulation
    .force("positioningY")
    .strength(0.04);

  function ticked() {
    link.attr("d", linkArc);

    node
      .attr("cx", function (d) {
        return d.x;
      })
      .attr("cy", function (d) {
        return d.y;
      })
      .attr("transform", function (d) {
        return "translate(" + d.x + "," + d.y + ")";
      });
  }
});

//-------------------sidedata(サイドデータ欄)の設定------------------------
function set_sidedata(d) {
  sidedata.style("z-index", 0).style("opacity", 1);
  sidedataimg.style("background-image", function () {
    if (typeof d.image === "undefined") {
      return 'url("image/unknown.png")';
    } else {
      return 'url("' + d.image + '")';
    }
  });

  sidedata.select("#data_name").text(d.id);

  sidedata.select("#data_memo").text(function () {
    if (typeof d.memo === "undefined") {
      return "";
    } else {
      return d.memo.replace(/\n/g, "<br/>");
    }
  });
  
  //sidedata.select("#data_group").text(d.group);
  //sidedata.select("#data_time").text(d.time);
}

function OnClickSearch() {
  var search_val = document.getElementById("txt_search").value;
  if (search_val == "") {
    window.alert("検索文字列を入力して下さい");
  } else {
    var search_data = jsondata.nodes.filter(function (d) {
      if (d.id == search_val) return true;
    })[0];
    if (typeof search_data === "undefined") {
      window.alert("無効な検索文字列です");
      document.getElementById("txt_search").value = "";
    } else {
      svg
        .transition()
        .duration(750)
        .call(zoom.transform, transform(search_data));
      set_sidedata(search_data);
    }
  }
}

function OnClickChange() {
  $("#data_save").prop("disabled", true);
}

function transform(d) {
  return d3.zoomIdentity
    .translate(width / 2, height / 2)
    .scale(4)
    .translate(-d.x, -d.y);
}

function stroke_dasharrayCD(d) {
  var arr = [2, 4, 6, 7, 9, 10, 11, 12, 0];
  if (arr.indexOf(d.group) >= 0) {
    return "3 2";
  } else {
    return "none";
  }
}

function nodeTypeID(d) {
  var arrRect = [3, 4];
  var arrEllipse = [5, 6, 7];
  var arrHexagon = [9, 10, 11, 12, 0];

  if (arrRect.indexOf(d) >= 0) {
    return "rect";
  } else if (arrEllipse.indexOf(d) >= 0) {
    return "ellipse";
  } else if (arrHexagon.indexOf(d) >= 0) {
    return "hexagon";
  } else {
    return "circle";
  }
}

function linkArc(d) {
  var dx = d.target.x - d.source.x,
    dy = d.target.y - d.source.y,
    dr = Math.sqrt(dx * dx + dy * dy),
    srcPos = getIntersectionPos(d.source, d.target),
    tgtPos = getIntersectionPos(d.target, d.source);
  return (
    "M" +
    srcPos.x +
    "," +
    srcPos.y +
    "A" +
    dr +
    "," +
    dr +
    " 0 0,1 " +
    tgtPos.x +
    "," +
    tgtPos.y
  );
}

function calcLoengthRate(pos1, pos2, pos3) {
  var v21 = { x: pos1.x - pos2.x, y: pos1.y - pos2.y },
    v23 = { x: pos3.x - pos2.x, y: pos3.y - pos2.y },
    x = v21.x * v23.x + v21.y * v23.y,
    y = v21.x * v23.y - v21.y * v23.x,
    theta = Math.atan2(y, x);
  if (theta > 0) {
    return theta / (2 * Math.PI);
  } else {
    return 1 + theta / (2 * Math.PI);
  }
}

function getIntersectionPos(d1, d2) {
  var nodeID = nodeTypeID(d1.group);
  switch (nodeID) {
    case "rect":
      var pos1 = { x: d1.x + spRect.x, y: d1.y + spRect.y },
        pos2 = { x: d1.x, y: d1.y },
        pos3 = { x: d2.x, y: d2.y },
        rate = calcLoengthRate(pos1, pos2, pos3),
        dpos = figRect.node().getPointAtLength(lenRect * rate);
      return { x: d1.x + dpos.x, y: d1.y + dpos.y };
      break;
    case "ellipse":
      var pos1 = { x: d1.x + spEllipse.x, y: d1.y + spEllipse.y },
        pos2 = { x: d1.x, y: d1.y },
        pos3 = { x: d2.x, y: d2.y },
        rate = calcLoengthRate(pos1, pos2, pos3),
        dpos = figEllipse.node().getPointAtLength(lenEllipse * rate);
      return { x: d1.x + dpos.x, y: d1.y + dpos.y };
      break;
    case "hexagon":
      var pos1 = { x: d1.x + spHexagon.x, y: d1.y + spHexagon.y },
        pos2 = { x: d1.x, y: d1.y },
        pos3 = { x: d2.x, y: d2.y },
        rate = calcLoengthRate(pos1, pos2, pos3),
        dpos = figHexagon.node().getPointAtLength(lenHexagon * rate);
      return { x: d1.x + dpos.x, y: d1.y + dpos.y };
      break;
    default:
      var pos1 = { x: d1.x + spCircle.x, y: d1.y + spCircle.y },
        pos2 = { x: d1.x, y: d1.y },
        pos3 = { x: d2.x, y: d2.y },
        rate = calcLoengthRate(pos1, pos2, pos3),
        dpos = figCircle.node().getPointAtLength(lenCircle * rate);
      return { x: d1.x + dpos.x, y: d1.y + dpos.y };
  }
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
