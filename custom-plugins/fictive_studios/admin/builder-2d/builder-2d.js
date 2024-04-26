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
    currentMainMenu: 'templates',
    async openEditor() {
        await loadStage();
        this.setCurrentMainMenu(this.currentMainMenu);
    },
    async closeEditor() {
        await closeEditor();
    },
    setCurrentMainMenu(current) {
        this.currentMainMenu = current;
        loadMainMenuOptions(current)
    },
    async createShape()  {
        const rect = stage.createShape("rect");
        await rect.setAttrs({ width: 100, height: 100, fill: "red" });
        await boundaryService.addTShapeToBoundary(BOUNDARY, rect);
    }
}));
Alpine.start();

let rect;
let stage;
const BOUNDARY = 'BOUNDARY';
async function loadStage() {
    builderHolder.classList.remove("hidden");
    stage = new Stage2D();
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
let mainMenuContent;
function createHolder() {
    builderHolder = document.createElement( 'div' );
    builderHolder.setAttribute('x-data', "editor");
    builderHolder.setAttribute('hx-trigger', "load");
    builderHolder.setAttribute('hx-get', "https://fictivecodes.com/templates/index.html");
    builderHolder.setAttribute('class', "bg-black hidden absolute inset-0 flex w-100 h-100 top-0 right-0 bottom-0 left-0");
    builderHolder.style.zIndex = 100001;
    wpcontentElement.parentNode.insertBefore( builderHolder, wpcontentElement.nextSibling );
}
const wpcontentElement = document.getElementById( 'wpcontent' );
if ( wpcontentElement ) {
    createHolder()
}

function closeEditor() {
    stage.stage.destroy();
    builderHolder.classList.add("hidden");
}

function loadMainMenuOptions(current) {
    const mainMenu = document.getElementById('main-menu');
    const mainMenuContentsArray = Array.from(document.getElementsByClassName('main-menu-content'));
    mainMenuContentsArray.forEach(element => element.remove());
    const mainMenuContent = document.createElement('div');
    mainMenuContent.classList.add('w-[50px]', 'h-full', 'bg-blue-300', 'main-menu-content');
    mainMenuContent.setAttribute('hx-trigger', 'load');
    mainMenuContent.setAttribute('hx-get', `https://fictivecodes.com/templates/${current}.html`);
    mainMenu.insertAdjacentElement( 'afterend', mainMenuContent );
}


