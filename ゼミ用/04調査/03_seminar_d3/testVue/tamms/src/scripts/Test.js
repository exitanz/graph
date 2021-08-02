import * as d3 from "d3";

export class Test {
    svg;
    constructor() {
        this.svg = d3
            .select("#view")
            .append("svg")
            .attr("width", 500)
            .attr("height", 400);
        this.svg
            .append("rect")
            .attr("x", 0)
            .attr("y", 0)
            .attr("width", 500)
            .attr("height", 400)
            .style("fill", "red");
        this.test();
    }

    test() {
        // 消す処理（クリア）
        this.svg = d3
            .select("#view")
            .selectAll("svg")
            .remove();
        this.svg = d3
            .select("#view")
            .append("svg")
            .attr("width", 500)
            .attr("height", 600);
        this.svg
            .append("rect")
            .attr("x", 0)
            .attr("y", 0)
            .attr("width", 500)
            .attr("height", 600)
            .style("fill", "blue");
    }
}