export class CanvasManager {
    constructor(canvas, staticCanvas) {
        this.canvas = canvas;
        this.staticCanvas = staticCanvas;
        this.context = canvas.getContext("2d");
        this.staticContext = staticCanvas.getContext("2d");
    }

    clear() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }

    drawStatic() {
        this.context.drawImage(this.staticCanvas, 0, 0);
    }

    getCanvas() {
        return this.canvas;
    }

    getStaticCanvas() {
        return this.staticCanvas;
    }

    getCtx() {
        return this.context;
    }

    getStaticCtx() {
        return this.staticContext;
    }
}