import {Stage2D, BoundaryService} from 'https://unpkg.com/@brocha-libs/builder-2d@33.2.0-1/index.mjs';
import { Alpine } from "https://fictivecodes.com/scripts/alphine.esm.js";
Alpine.data("editor", () => ({
    availablePrintAreas: [
        {
            name: 'name 1',
            resolution: {
                width: 300,
                height: 400,
            }
        },
        {
            name: 'name 2',
            resolution: {
                width: 300,
                height: 400,
            }
        }
    ],
    currentMainMenu: 'hello',
    async openEditor() {
        await loadStage();
    },
    setCurrentMainMenu(current) {
        this.currentMainMenu =
    }
}));
Alpine.start();
let rect;
const BOUNDARY = 'BOUNDARY';
async function loadStage() {
    builderHolder.classList.remove("hidden");
    const stage = new Stage2D();
    await stage.initializeStage();

    const boundaryService = new BoundaryService(stage);
    await boundaryService.createBoundary(BOUNDARY, 341, 640);
    // boundaryService.focusABoundary(BOUNDARY);
    // const rect = stage.createShape("rect");
    // await rect.setAttrs({ width: 100, height: 100, fill: "red" });
    // await boundaryService.addTShapeToBoundary(BOUNDARY, rect);
    // boundaryService.focusABoundary(BOUNDARY);

}
let builderHolder;
function createHolder() {
    builderHolder = document.createElement( 'div' );
    builderHolder.setAttribute('x-data', "editor");
    builderHolder.setAttribute('hx-trigger', "load");
    builderHolder.setAttribute('hx-get', "https://fictivecodes.com");
    builderHolder.setAttribute('class', "bg-black hidden absolute inset-0 flex w-100 h-100 top-0 right-0 bottom-0 left-0");
    builderHolder.style.zIndex = 100001;
    wpcontentElement.parentNode.insertBefore( builderHolder, wpcontentElement.nextSibling );
}
var wpcontentElement = document.getElementById( 'wpcontent' );
if ( wpcontentElement ) {
    createHolder()
}
//
// await loadStage();


