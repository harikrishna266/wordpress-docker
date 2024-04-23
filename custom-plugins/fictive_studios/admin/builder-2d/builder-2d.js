import {Stage2D} from 'https://unpkg.com/@brocha-libs/builder-2d@33.2.0-1/index.mjs';
import { Alpine } from "https://fictivecodes.com/scripts/alphine.esm.js";
let rect;
// async function loadStage() {
//     const stage = new Stage2D();
//     stage.initializeStage();
//     rect = stage.createShape('rect');
//     await rect.setAttrs({x: 0});
//     stage.addToLayer(rect);
//     await rect.setAttrs({x: 1})
// }
//
// function createHolder() {
//     const builderHolder = document.createElement( 'div' );
//     builderHolder.setAttribute('hx-trigger', "load");
//     builderHolder.setAttribute('hx-get', "https://fictivecodes.com");
//     builderHolder.setAttribute('class', "bg-black hidden absolute inset-0 flex w-100 h-100 top-0 right-0 bottom-0 left-0");
//     builderHolder.style.zIndex = 100001;
//     wpcontentElement.parentNode.insertBefore( builderHolder, wpcontentElement.nextSibling );
// }
// var wpcontentElement = document.getElementById( 'wpcontent' );
// if ( wpcontentElement ) {
//     createHolder()
// }
//
// await loadStage();


Alpine.data("editor", () => ({
    count: 1,
    increment() {
        this.count = this.count + 1;
    },
}));
Alpine.start();