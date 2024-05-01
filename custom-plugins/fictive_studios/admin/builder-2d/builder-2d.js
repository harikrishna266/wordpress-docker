import {Stage2D, BoundaryService} from 'https://unpkg.com/@brocha-libs/builder-2d@34/index.mjs';
import { Alpine } from "https://fictivecodes.com/scripts/alphine.esm.js";
let boundaryService;
let stage;


Alpine.store("editor", () => ({
    availablePrintAreas: [],
    fetchPrintAreas() {
        fetch('https://woocommerce.com/wp-admin/admin-ajax.php?action=get_print_areas')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse response as JSON
            })
             .then(data => {
                  this.availablePrintAreas = data;
            })
    },
     boundaryService: null,
    currentMainMenu: 'templates',
    async openEditor(width, height) {
        await loadStage(width, height);
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
        await boundaryService.addTShapeToBoundary('BOUNDARY', rect);
    }
}));
Alpine.start();

async function loadStage(width, height) {
    builderHolder.classList.remove("hidden");
    stage = new Stage2D();
    await stage.initializeStage();
    stage.isEditor = true;
    boundaryService = new BoundaryService(stage);
    await boundaryService.createBoundary('BOUNDARY', +width, +height);
    boundaryService.focusABoundary('BOUNDARY');
}
let builderHolder;
let mainMenuContent;
function createHolder() {
    builderHolder = document.createElement( 'div' );
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
//
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


