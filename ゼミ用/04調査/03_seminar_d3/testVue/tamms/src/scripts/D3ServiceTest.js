// import * as d3 from "d3";

export class D3ServiceTest {
    //Jsonfileのデータを保持
    // jsondata;
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

    static init(
        sidedata,
        datatip,
        svg,
        width,
        height,
        color,
        simulation,
        Defs,
        figCircle,
        lenCircle,
        spCircle,
        figRect,
        lenRect,
        spRect,
        figEllipse,
        lenEllipse,
        spEllipse,
        figHexagon,
        lenHexagon,
        spHexagon,
        zoom,
        g) {
        this.sidedata = sidedata;
        this.sidedata = sidedata;
        this.datatip = datatip;
        this.svg = svg;
        this.width = width;
        this.height = height;
        this.color = color;
        this.simulation = simulation;
        this.Defs = Defs;
        this.figCircle = figCircle;
        this.lenCircle = lenCircle;
        this.spCircle = spCircle;
        this.figRect = figRect;
        this.lenRect = lenRect;
        this.spRect = spRect;
        this.figEllipse = figEllipse;
        this.lenEllipse = lenEllipse;
        this.spEllipse = spEllipse;
        this.figHexagon = figHexagon;
        this.lenHexagon = lenHexagon;
        this.spHexagon = spHexagon;
        this.zoom = zoom;
        this.g = g;
    }
}
