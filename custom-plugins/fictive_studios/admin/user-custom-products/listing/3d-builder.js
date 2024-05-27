import { Alpine } from "https://fictivecodes.com/scripts/alphine.esm.js";
import {SceneHelper, ArcRotationCameraHelper, LightHelper, loadModel, centerScene, createDynamicTexture} from 'https://unpkg.com/@brocha-libs/builder-3d@45/index.mjs'
import {Stage2D, BoundaryService} from 'https://unpkg.com/@brocha-libs/builder-2d@45/index.mjs';

let builderHolder;
let boundaryService;
let stage;
const sceneHelper = new SceneHelper();


Alpine.store("threeDEditor", () => ({
    currentMainMenu: 'templates',
    async openEditor() {
        builderHolder.classList.remove('hidden');
        await loadStage();
        await create3dBuilder();
        this.setCurrentMainMenu(this.currentMainMenu);
    },
    setCurrentMainMenu(current) {
        this.currentMainMenu = current;
        loadMainMenuOptions(current)
    },
    closeEditor() {
        builderHolder.classList.add('hidden');
        sceneHelper.scene.meshes.forEach((mesh) => mesh.dispose());
        sceneHelper.scene.materials.forEach((material) => material.dispose() );
        sceneHelper.scene.textures.forEach((texture) => texture.dispose());
        sceneHelper.scene.lights.forEach(function(light) {
            light.dispose();
        });
        sceneHelper.scene.cameras.forEach(function(camera) {
            camera.dispose();
        });
        sceneHelper.scene.dispose();
    }
}))
Alpine.start();

function createHolder() {
    builderHolder = document.createElement( 'div' );
    builderHolder.setAttribute('hx-trigger', "load");
    builderHolder.setAttribute('id', "modal-3d");
    builderHolder.setAttribute('hx-get', "https://fictivecodes.com/templates/3d-builder/index.html");
    builderHolder.classList.add("bg-black", "hidden", "absolute", "inset-0", "flex", "w-100", "h-100", "top-0", "right-0", "bottom-0", "left-0", "hidden");
    builderHolder.style.zIndex = 100001;
    document.body.appendChild( builderHolder);
}

async function loadStage() {
    stage = new Stage2D();
    await stage.initializeStage();
    stage.isEditor = false;
    boundaryService = new BoundaryService(stage);
    await boundaryService.createBoundary('BOUNDARY', 2048, 2048);
    const rect = stage.createShape('rect');
    await rect.setAttrs({ width: 2048, height: 2048, fill: 'red' });
    await boundaryService.addTShapeToBoundary('BOUNDARY', rect);
}



async function create3dBuilder(width, height) {
    await sceneHelper.createScene(document.getElementById('render-canvas'));
    const arcRotateCamera = new ArcRotationCameraHelper();
    await arcRotateCamera.create(sceneHelper.scene);
    arcRotateCamera.attachControls(document.getElementById('render-canvas'));
    new LightHelper().addEnvSettings(sceneHelper.scene);
    const meshes = await loadModel(sceneHelper.scene, 'model', '', 'https://fictivecodes.com/glb/', 'compressed.glb')
    centerScene(sceneHelper.scene);
    const dynamicTexture = await createDynamicTexture('main-texture',
        stage.layer.getCanvas()._canvas,
        sceneHelper.scene
    );
     meshes.forEach((mesh) => {
        if (mesh.material) {
            const material = mesh.material;
            material.albedoTexture = dynamicTexture;
        }
    });
    dynamicTexture.update()
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

createHolder();