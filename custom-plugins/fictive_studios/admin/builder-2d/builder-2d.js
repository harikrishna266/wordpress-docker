import {Stage2D} from 'https://unpkg.com/@brocha-libs/builder-2d@10.0.0/index.mjs';
alert('in');
let rect;
async function loadStage() {
    const stage = new Stage2D();
    stage.initializeStage();
    rect = stage.createShape('rect'); 
    await rect.setAttrs({x: 0});
    stage.addToLayer(rect);
    await rect.setAttrs({x: 1})
}

await loadStage();

document.querySelector('#serializeShapes').addEventListener('click', saveSerializedData)

function saveSerializedData() {
    var xhr = new XMLHttpRequest();
    var templateName = document.getElementById('template-name');
    
    xhr.open('POST', ajaxurl, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    var data = {
        action: 'save_template_action',
        data: JSON.stringify(rect.serialize()),
        name: templateName.value
    };

    var formData = Object.keys(data).map(function(key) {
        return encodeURIComponent(key) + '=' + encodeURIComponent(data[key]);
    }).join('&');

    xhr.send(formData);
}
