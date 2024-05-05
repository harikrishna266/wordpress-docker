import {Stage2D, BoundaryService} from 'https://unpkg.com/@brocha-libs/builder-2d@41/index.mjs';
import { Alpine } from "https://fictivecodes.com/scripts/alphine.esm.js";
import {SceneHelper, ArcRotationCameraHelper, LightHelper, loadModel, centerScene} from 'https://unpkg.com/@brocha-libs/builder-3d@44/index.mjs'
let builderHolder;
let boundaryService;
let stage;
const sceneHelper = new SceneHelper();


Alpine.store("threeDEditor", () => ({
    currentMainMenu: 'templates',
    async openEditor() {
        builderHolder.classList.remove('hidden');
        await create3dBuilder();
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

async function loadStage(width, height) {
     stage = new Stage2D();
    await stage.initializeStage();
    stage.isEditor = false;
}

async function create3dBuilder(width, height) {
    await sceneHelper.createScene(document.getElementById('render-canvas'));
    const arcRotateCamera = new ArcRotationCameraHelper();
    await arcRotateCamera.create(sceneHelper.scene);
    arcRotateCamera.attachControls(document.getElementById('render-canvas'));
    new LightHelper().addEnvSettings(sceneHelper.scene);
    const meshes = await loadModel(sceneHelper.scene, 'model', '', 'https://fictivecodes.com/glb/', 'compressed.glb')
    centerScene(sceneHelper.scene);
}

createHolder();