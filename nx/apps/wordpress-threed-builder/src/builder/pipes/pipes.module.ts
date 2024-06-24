import { NgModule } from '@angular/core';
import { DesignLayerFilterPipe } from './design-layer-filter.pipe';

@NgModule({
  declarations: [
    DesignLayerFilterPipe
  ],
  exports: [
    DesignLayerFilterPipe
  ]
})
export class PipesModule {

}
