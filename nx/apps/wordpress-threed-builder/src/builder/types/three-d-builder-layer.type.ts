import { Layer } from './layer.type';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';

export type DesignLayer = { layer: Layer, path: Path, type: 'layer'};
export type PatternLayer = { layer: Layer, basePath: Path, path: Path, patternImage: Path, type: 'pattern'};
export type LayerTypes = PatternLayer | DesignLayer ;
